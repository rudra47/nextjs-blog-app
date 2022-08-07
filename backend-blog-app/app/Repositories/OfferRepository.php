<?php

namespace App\Repositories;

use App\Interfaces\OfferRepositoryInterface;
use App\Models\Offer;
use App\Models\Package;
use App\Models\Product;
use App\Services\Utils\FileUploadService;

class OfferRepository implements OfferRepositoryInterface {

    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function getAllOffer() {
        return Offer::with(['products', 'offerable'])->latest()->get();
    }

    public function getOfferById($id) {

    }

    public function deleteOffer($id) {
        return Offer::destroy($id);
    }

    public function createOffer($request) {
        $image_name = null;
        $offer_type = $request->offer_type;
        if($offer_type == 'package') {
            if ($request->image) {
                $image_name = $this->fileUploadService->uploadFile($request->image, Offer::FILE_STORE_PATH, null);
            }
            $model = Package::findOrFail($request->package_id);
        }elseif ($offer_type == 'single_product' || $offer_type == 'buy_and_get') {
            $model = Product::findOrFail($request->product_id);
        }

        // offer create
        $offer = $model->offers()->create([
            'buy_quantity' => $request->buy_quantity,
            'message' => $request->message,
            'offer' => $request->offer,
            'image' => $image_name,
            'offer_type' => $request->offer_type,
            'discount_type' => $request->discount_type,
            'offer_variation' => $offer_type == 'single_product' ? null :  $request->offer_variation,
            'status' => $request->status,
        ]);

        // assign offer product
        if($request->offer_product_id) {
            $offer->products()->attach($request->offer_product_id);
        }

        return $offer;
    }

    public function updateOffer($id, $request) {

    }
}

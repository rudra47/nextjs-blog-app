<?php

namespace App\Repositories;

use App\Interfaces\SliderRepositoryInterface;
use App\Models\Slider;
use App\Services\Summernote\SummernoteImageService;
use App\Services\Utils\FileUploadService;
use Illuminate\Support\Str;

class SliderRepository implements SliderRepositoryInterface
{

    protected $summernoteImageService;
    protected $fileUploadService;

    public function __construct(SummernoteImageService $summernoteImageService, FileUploadService $fileUploadService)
    {
        $this->summernoteImageService = $summernoteImageService;
        $this->fileUploadService = $fileUploadService;
    }

    public function getAllSlider()
    {
        return Slider::latest()->get();
    }

    public function getSliderById($id)
    {
        return Slider::findOrFail($id);
    }

    public function deleteSlider($id)
    {
        $slider = Slider::findOrFail($id);
        try {
            $this->fileUploadService->delete(Slider::FILE_STORE_PATH . '/' . $slider->image);
        } catch (\Exception $e) {
        }

        $slider->delete();
        return $slider;
    }

    public function createSlider($request)
    {

        $image_name = null;

        if ($request->image) {
            $image_name = $this->fileUploadService->uploadFile($request->image, Slider::FILE_STORE_PATH, null);
        }

        return Slider::create([
            'mini_title' => $request->mini_title,
            'title' => $request->title,
            'description' => $request->description,
            'btn_name' => $request->btn_name,
            'btn_link' => $request->btn_link,
            'image' => $image_name,
            'status' => $request->status,
        ]);
    }

    public function updateSlider($id, $request)
    {
        $image_name = null;
        $slider = Slider::findOrFail($id);

        if ($request->image) {
            $image_name = $this->fileUploadService->uploadFile($request->image, Slider::FILE_STORE_PATH, Slider::FILE_STORE_PATH . '/' . $slider->image);
        }else{
            $image_name = $slider->image;
        }

        $slider->mini_title = $request->mini_title;
        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->btn_name = $request->btn_name;
        $slider->btn_link = $request->btn_link;
        $slider->btn_color_code = $request->btn_color_code;
        $slider->text_right_or_left = $request->text_right_or_left;
        $slider->text_font_color = $request->text_font_color;
        $slider->image = $image_name;
        $slider->status = $request->status;
        $slider->save();

        return $slider;
    }
}

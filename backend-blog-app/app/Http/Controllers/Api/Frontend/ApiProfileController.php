<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ProfileRepositoryInterface;

class ApiProfileController extends Controller 
{
    public $profileRepository;
    public function __construct(ProfileRepositoryInterface $profileRepository){
        $this->profileRepository = $profileRepository;
    }

    public function profile($user_id)
    {
        return $this->profileRepository->getUserInfoById($user_id);
    }
    
    public function add_shipping_details($user_id)
    {
        return $this->profileRepository->getUserInfoById($user_id);
    }

    public function store_shipping_details(Request $request, $user_id)
    {
        $response = $this->profileRepository->storeShippingDetails($request, $user_id);
        
        return response()->json($response);
    }
}

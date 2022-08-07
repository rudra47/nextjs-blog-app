<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Configuration\ConfigurationResource;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => new ConfigurationResource(Configuration::first())
        ]);

    }
}

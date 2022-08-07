<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function save_log( $activity_log_type, $properties, $model_id = null, $user_id = null,  $details = null){
        if(Auth::check()){
            if(empty($user_id)) {
                $user_id = Auth::user()->id;
            }

            ActivityLog::create([
                'user_id' => $user_id,
                'activity_log_type' => $activity_log_type,
                'model_id' => $model_id,
                'properties' => json_encode($properties),
            ]);
        }
    }
}

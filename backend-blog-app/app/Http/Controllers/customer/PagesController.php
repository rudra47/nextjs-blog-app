<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use App\Models\Saloon;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $saloons = Saloon::where('status', 1)->get();
        //dd($saloons->toArray());
        $coords = array_map(function($data) {
                return  $data['latitude'].",".$data['longitude'];
            }, $saloons->toArray() );

        $from_latlong = implode("|", $coords);
        if(auth()->check()){
            $to_latlong = "".auth()->user()->latitude.",".auth()->user()->longitude;
        }else{
            $to_latlong = "23.7283894,90.4206081";
        }
        $googleApi = "AIzaSyDuSN0u2fpgle4eYZ1kxPHmTA8maKJynYE&sensor=false";
        $distance_data = file_get_contents(
                'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.$from_latlong.'&destinations='.$to_latlong.'&key='.$googleApi
                );

        return view('customer.index', compact('saloons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

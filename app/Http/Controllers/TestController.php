<?php

namespace App\Http\Controllers;

use App\Events\SendLocation;
use App\Events\SendOnlineStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    
    public function nearByPlaces()
    {
        $response = Http::withHeaders([
            'Content-Type'      => 'application/json',
            'X-Goog-Api-Key'    => config('google_api_key'),
            'X-Goog-FieldMask'  => 'places.id,places.displayName,places.location'
        ])->post('https://places.googleapis.com/v1/places:searchNearby', [
            'includedTypes'     => ["restaurant"],
            'maxResultCount'    => 10,
            'circle'            => ["center" => ["latitude" => 37.7937, "longitude" => -122.3965]],
            'radius'            => 500.0
        ]);
        return ($response);
    }

    public function updateLocation(Request $request)
    {
        $rules = [
            'lat'                            => ['required'],
            'long'                          => ['required'],
            'driver_id'                         => ['required']
        ];

        $messages = [
            'lat.required'                     => 'Please enter Latitude',
            'long.required'                   => 'Please choose Longitude',
            'driver_id.required'                  => 'Please enter Driver Id.',
        ];


        $validator = Validator::make($request->all(),$rules,$messages);

        if( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()]);
         }


        $lat                    = $request->input('lat');
        $long                   = $request->input('long');
        $driver_id              = $request->input('driver_id');
        $location               = ["lat" => $lat, "long" => $long];
        $driver                 = User::find($driver_id);
        $driver->latitude       = $lat;
        $driver->longitude      = $long;
        $driver->is_online      = 1;
        $driver->save();
        SendLocation::dispatch($location, $driver);
        return response()->json(['status' => 'success', 'data' => $location]);
    }


    public function updateOnlineStatus(Request $request)
    {
        $rules = [
            'is_online'                            => ['required'],
            'driver_id'                            => ['required']
        ];

        $messages = [
            'is_online.required'                  => 'Please enter is_online',
            'driver_id.required'                  => 'Please enter Driver Id.',
        ];


        $validator = Validator::make($request->all(),$rules,$messages);
        if( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()]);
         }

        $driver_id              = $request->input('driver_id');
        $driver                 = User::find($driver_id);
        $name = $driver->firstname.' '.($driver->lastname ?? '');
        $driver->is_online      = $request->input('is_online') ? true : false;
        $driver->save();

        SendOnlineStatus::dispatch($driver->is_online, $driver_id,$name);

        return response()->json(['status' => 'success', 'is_online' =>  $driver->is_online, 'driver_id' =>  $driver->id]);
    }
}

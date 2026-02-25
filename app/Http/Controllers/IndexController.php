<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\Merchant;
use App\Models\Task;
use App\Models\TaskPhoto;
use App\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IndexController extends Controller
{
    public function customerRequestForm($slug)
    {
        $merchant = Merchant::findBySlug($slug);
        $vehicle_types = VehicleType::get();
        return view('administrator.merchants.customer-request-form', compact('merchant', 'vehicle_types'));
    }

    public function storeCustomerRequestForm(Request $request, $slug)
    {
        $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            // 'email'                 => ['required', 'string', 'email', 'max:255'],
            'phone'                 => ['required'],
            'address'               => ['required'],
            'vehicle_type'          => ['required'],
            'registration_number'   => ['required'],
            'destination_address' => [$request->merchant_id ? 'required' : 'nullable'],
                                        
                                        
        ]);

        $merchant = Merchant::findBySlug($slug);
        $store = $merchant->storeDetail;
        
       if($request->merchant_id){
        Task::create([
            'merchant_id'            => $merchant->id,
            'driver_id'              => null,
            'type'                   => 'Towing',
            'name'                   => $request->name,
            'email'                  => $request->email,
            'iso2'                   => $request->iso2,
            'dialcode'               => $request->dialcode,
            'phone'                  => $request->phone,
            'address'                => $request->address,
            'latitude'               => $request->latitude,
            'longitude'              => $request->longtitude,
            'location'               => $request->location,
            'due_time'               => Carbon::now()->format("Y-m-d 11:59:00"),
            'vehicle_type'           => $request->vehicle_type,
            'registration_number'    => $request->registration_number,
            'destination_contact_name' => $request->destination_contact_name,
            'destination_contact_email' => $request->destination_contact_email,
            'destination_dialcode' => $request->destination_dialcode,
            'destination_phone' => $request->destination_phone,
            'destination_address' => $request->destination_address,
            'destination_building_floor_room' => $request->destination_building_floor_room,
            'destination_latitude' => $request->destination_latitude,
            'destination_longitude' => $request->destination_longitude,
            'destination_iso2' => $request->destination_iso2,
            'priority'               => 'medium',
            'towing_fee'             => 0,
            'status'                 => 'active',
            'requirements'           => ['photos', 'signature', 'notes', 'cash-on-delivery'],
            'notes'                  => $request->notes,
            'arrival_time'           => null,
            'completion_time'        => null,
            'driver_notes'           => null,
            'added_by_id'            => null,
            'dispatched_by_id'       => null,
        ]);
       }else{
         Task::create([
            'merchant_id'            => $merchant->id,
            'driver_id'              => null,
            'type'                   => 'Towing',
            'name'                   => $request->name,
            'email'                  => $request->email,
            'iso2'                   => $request->iso2,
            'dialcode'               => $request->dialcode,
            'phone'                  => $request->phone,
            'address'                => $request->address,
            'latitude'               => $request->latitude,
            'longitude'              => $request->longtitude,
            'location'               => $request->location,
            'due_time'               => Carbon::now()->format("Y-m-d 11:59:00"),
            'vehicle_type'           => $request->vehicle_type,
            'registration_number'    => $request->registration_number,
            'destination_contact_name' => $store?->name,
            'destination_contact_email' => $store?->email,
            'destination_dialcode' => $store?->dialcode,
            'destination_phone' => $store?->phone,
            'destination_address' => $store?->address,
            'destination_building_floor_room' => $store?->building_floor_room,
            'destination_latitude' => $store?->latitude,
            'destination_longitude' => $store?->longitude,
            'destination_iso2' => $store?->iso2,
            'priority'               => 'medium',
            'towing_fee'             => 0,
            'status'                 => 'active',
            'requirements'           => ['photos', 'signature', 'notes', 'cash-on-delivery'],
            'notes'                  => $request->notes,
            'arrival_time'           => null,
            'completion_time'        => null,
            'driver_notes'           => null,
            'added_by_id'            => null,
            'dispatched_by_id'       => null,
        ]);
       }
       

        $admins = Administrator::whereStatus('1')->whereNotNull('app_push_token')->get('app_push_token');
        if (count($admins) > 0) {
            foreach ($admins as $admin) {
                $this->appNotify($admin->app_push_token, 'New Task added', 'Added by customer ' . $request->name);
            }
        }

        return redirect()->back()->with('success', 'Your request form has been sent successfully!');
    }

    public function appNotify($token, $title, $msg)
    {
        $response = Http::post('https://exp.host/--/api/v2/push/send', [
            'to' => $token,
            'title' => $title,
            'body' => $msg,
        ]);
    }

    function getEpods ($id){
        $epods = TaskPhoto::whereTaskId($id)->get();
        $images = [];
        if( count($epods) > 0 ){
            foreach($epods as $e){
              $images[ucfirst($e->type).' EPOD'][] =  [
                'name' => !is_null($e->photo) ? explode('.', $e->photo)[0] : null,
                'uri'  => asset('storage/uploads/task-photos' . '/' . $id . '/' . $e->photo)
              ];           
            }
        $task = Task::find($id);
            $images['Driver Signature'][] = [
                'name' => 'sign',
                'uri'  => $task->signature
            ];
        }
       return $images;

    }

    public function trackRequest($slug, $id)
    {
        $task           = Task::find($id);
        $data           = isset($task->driver_id) ? Http::get("https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $task->driver->latitude . "," . $task->driver->longitude . "&destinations=" . $task->latitude . "," . $task->longitude . "&key=" . config("app.google_api_key")) : '';
        $eta            = isset($task->driver_id) && $task->status != "completed" ? $data['rows'][0]['elements'][0]['duration']['text'] : "Driver to be Assigned";
        $distance_away  = isset($task->driver_id) && $task->status != "completed" ? $data['rows'][0]['elements'][0]['distance']['text'] : 0;
        $merchant       = Merchant::findBySlug($slug);
        $vehicle_types  = VehicleType::get();
        $epods = $this->getEpods($id);
       
        return view('administrator.tasks.track-order', compact('epods','task', 'merchant', 'vehicle_types', 'eta', 'distance_away'));
    }
}

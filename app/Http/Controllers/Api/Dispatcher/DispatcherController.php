<?php

namespace App\Http\Controllers\Api\Dispatcher;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\ContactUs;
use App\Models\Merchant;
use App\Models\MerchantStoreDetail;
use App\Models\Service;
use App\Models\Task;
use App\Models\TaskPhoto;
use App\Models\User;
use App\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class DispatcherController extends Controller
{
    public function dashboard(Request $request)
    {

        $filter['date_range']       = $request->filter;
        $filter['start_date']       = $request->start_date;
        $filter['end_date']         = $request->end_date;
        $user                       = $request->user();

        if ($request->start_date) {
          
            $total_tasks            = Task::whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
            $total_active_tasks     = Task::where('status', 'in-transist')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
            $total_completed_tasks  = Task::where('status', 'completed')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
            $total_failed_tasks     = Task::where('status', 'failed')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
            $total_unassigned_tasks = Task::whereNull('driver_id')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
            $total_assigned_tasks   = Task::whereNotNull('driver_id')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();

            return response()->json(compact('filter', 'total_tasks', 'total_active_tasks', 'total_completed_tasks', 'total_failed_tasks', 'total_unassigned_tasks', 'total_assigned_tasks'));
        }

        if ($request->filter == 'today') {
          
            $total_tasks            = Task::whereDate('created_at', Carbon::now())->count();
            $total_active_tasks     =Task::where('status', 'in-transist')->whereDate('created_at', Carbon::now())->count();
            $total_completed_tasks  = Task::where('status', 'completed')->whereDate('created_at', Carbon::now())->count();
            $total_failed_tasks     = Task::where('status', 'failed')->whereDate('created_at', Carbon::now())->count();
            $total_unassigned_tasks = Task::whereNull('driver_id')->whereDate('created_at', Carbon::now())->count();
            $total_assigned_tasks   = Task::whereNotNull('driver_id')->whereDate('created_at', Carbon::now())->count();

            return response()->json(compact('filter', 'total_tasks', 'total_active_tasks', 'total_completed_tasks', 'total_failed_tasks', 'total_unassigned_tasks', 'total_assigned_tasks'));
        }

        if ($request->filter == 'yesterday') {
          
            $total_tasks            = Task::whereDate('created_at', Carbon::yesterday())->count();
            $total_active_tasks     =Task::where('status', 'in-transist')->whereDate('created_at', Carbon::yesterday())->count();
            $total_completed_tasks  = Task::where('status', 'completed')->whereDate('created_at', Carbon::yesterday())->count();
            $total_failed_tasks     = Task::where('status', 'failed')->whereDate('created_at', Carbon::yesterday())->count();
            $total_unassigned_tasks = Task::whereNull('driver_id')->whereDate('created_at', Carbon::yesterday())->count();
            $total_assigned_tasks   = Task::whereNotNull('driver_id')->whereDate('created_at', Carbon::yesterday())->count();

            return response()->json(compact('filter', 'total_tasks', 'total_active_tasks', 'total_completed_tasks', 'total_failed_tasks', 'total_unassigned_tasks', 'total_assigned_tasks'));
        }

        if ($request->filter == "week") {
           
            $total_tasks            = Task::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $total_active_tasks     =Task::where('status', 'in-transist')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $total_completed_tasks  = Task::where('status', 'completed')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $total_failed_tasks     = Task::where('status', 'failed')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $total_unassigned_tasks = Task::whereNull('driver_id')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $total_assigned_tasks   = Task::whereNotNull('driver_id')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

            return response()->json(compact('filter', 'total_tasks', 'total_active_tasks', 'total_completed_tasks', 'total_failed_tasks', 'total_unassigned_tasks', 'total_assigned_tasks'));
        }

        if ($request->filter == "month") {
          
            $total_tasks            = Task::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
            $total_active_tasks     =Task::where('status', 'in-transist')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
            $total_completed_tasks  = Task::where('status', 'completed')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
            $total_failed_tasks     = Task::where('status', 'failed')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
            $total_unassigned_tasks = Task::whereNull('driver_id')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
            $total_assigned_tasks   = Task::whereNotNull('driver_id')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

            return response()->json(compact('filter', 'total_tasks', 'total_active_tasks', 'total_completed_tasks', 'total_failed_tasks', 'total_unassigned_tasks', 'total_assigned_tasks'));
        }

        if ($request->filter == "year") {
          
            $total_tasks            = Task::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
            $total_active_tasks     =Task::where('status', 'in-transist')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
            $total_completed_tasks  = Task::where('status', 'completed')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
            $total_failed_tasks     = Task::where('status', 'failed')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
            $total_unassigned_tasks = Task::whereNull('driver_id')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
            $total_assigned_tasks   = Task::whereNotNull('driver_id')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();

            return response()->json(compact('filter', 'total_tasks', 'total_active_tasks', 'total_completed_tasks', 'total_failed_tasks', 'total_unassigned_tasks', 'total_assigned_tasks'));
        }

      
        $total_tasks            = Task::count();
        $total_active_tasks     =Task::where('status', 'in-transist')->count();
        $total_completed_tasks  = Task::where('status', 'completed')->count();
        $total_failed_tasks     = Task::where('status', 'failed')->count();
        $total_unassigned_tasks = Task::whereNull('driver_id')->count();
        $total_assigned_tasks   = Task::whereNotNull('driver_id')->count();


        return response()->json(compact('filter', 'total_tasks', 'total_active_tasks', 'total_completed_tasks', 'total_failed_tasks', 'total_unassigned_tasks', 'total_assigned_tasks'));
    }

    public function tasks(Request $request)
    {
        // dd($request->all());

        switch ($request->type) {
            case 'assigned':
                $tasks = Task::whereNotNull('driver_id');
                break;
            case 'unassigned':
                $tasks = Task::whereNull('driver_id');
                break;
            case 'completed':
                $tasks = Task::whereStatus('completed');
                break;
            case 'failed':
                $tasks = Task::whereStatus('failed');
                break;
            case 'my':
                $tasks = Task::whereDispatchedById($request->user()->id);
                break;
            default:
                $tasks = Task::whereNotIn('status', ['completed', 'failed']);
        }
        $filtered = false;

        if (!is_null($request->task_type) && $request->task_type != 'null') {
            $tasks->where('type', $request->task_type);
            $filtered = true;
        }
        if (!is_null($request->vehicle_number) && $request->vehicle_number != 'null') {
            $tasks->where('registration_number', 'like', '%' . $request->vehicle_number . '%');
            $filtered = true;
        }
        if (!is_null($request->prority) && $request->prority != 'null') {
            $tasks->where('priority', $request->prority);
            $filtered = true;
        }
        if (!is_null($request->driver_id) && $request->driver_id != 'null') {
            $tasks->where('driver_id', $request->driver_id);
            $filtered = true;
        }

        // if(!is_null($request->source)){
        //     if( $request->source == 'merchant')
        //     $tasks->whereNotNull('merchant_id');
        //     else
        //     $tasks->whereNotNull('driver_id');

        // }


        $tasks = $tasks->orderBy('id', 'desc')->paginate(10);
        $all = Task::count();
        $unassigned = Task::whereNull('driver_id')->count();
        $assigned   = Task::whereNotNull('driver_id')->count();
        $my = Task::whereDispatchedById($request->user()->id)->count();

        $tasks->through(function ($task) {
            return [
                'id'        => $task->id,
                'driver_id' => $task->driver_id,
                'address'   => $task->address,
                'name'      => $task->name,
                'merchant'  => $task->merchant?->name,
                'added_on'  => Carbon::parse($task->created_at)->format('d M, h:m A'),
                'prority'   => ucfirst($task->priority),
                'type'      => $task->type,
                'status'    => $task->status,
            ];
        });
        return response()->json(compact(
            'tasks',
            'all',
            'assigned',
            'unassigned',
            'filtered',
            'my'
        ));
    }
    public function getTask($id)
    {
        $task = Task::find($id);
        $epod = TaskPhoto::select('id')->whereTaskId($id)->first() ? 1 : 0;

        $task =  [
            'id'      => $task->id,
            'address' => $task->address,
            'name'   => $task->name,
            'email'    => $task->email,
            'phone'    => $task->phone,
            'dialcode' => $task->dialcode,
            'merchant_id' => $task->merchant_id,
            'merchant' => $task->merchant?->name,
            'added_on' => Carbon::parse($task->created_at)->format('d M, h:m A'),
            'prority'  => ucfirst($task->priority),
            'status'  =>  ucfirst($task->status),
            'driver_id' => $task->driver_id,
            'driver_name' => $task->driver?->firstname . ' ' . $task->driver?->lastname,
            'type'     => $task->type,
            'service_id' => $task->service_id,
            'services' => $task->service?->name,
            'towing_fee' => $task->towing_fee,
            'requirements' => $task->requirements,
            'registration_number' => $task->registration_number,
            'notes' => $task->notes,
            'location'  => $task->location,
            'vehicle_type' => $task->vehicle_type,
            'latitude' => $task->latitude,
            'longitude' => $task->longitude,
            'd_latitude' => $task->driver?->latitude,
            'd_longitude' => $task->driver?->longitude,
            'epod' => $epod,
            'destination_contact_name' => $task->destination_contact_name,
            'destination_address' => $task->destination_address,
            'destination_contact_email' => $task->destination_contact_email,
            'destination_phone' => $task->destination_phone,
            'destination_building_floor_room' => $task->destination_building_floor_room,
            'destination_notes' => $task->destination_notes,
            'destination_dialcode' => $task->destination_dialcode,
            'destination_iso2' => $task->destination_iso2,
            'destination_latitude' => $task->destination_latitude,
            'destination_longitude' => $task->destination_longitude,
            'ticket_no' => $task->ticket_no,
            'battery_tyre_size' => $task->battery_tyre_size,
            'remarks' =>  $task->remarks


        ];

        return response()->json([
            'task' => $task
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
        return response()->json([
            'images' => $images
        ]);

    }
    public function create()
    {
        $merchants      = Merchant::get(['id as key', 'name as value']);
        $drivers        = User::select(DB::raw("CONCAT(firstname, ' ', lastname) AS value"), "id as key")->whereNotNull('firstname')->get();
        $services       = Service::get(['id as key', 'name as value', 'price']);
        $vehicle_types  = VehicleType::get(['id as key', 'name as value']);

        return response()->json([
            'merchants'     => $merchants,
            'drivers'       => $drivers,
            'services'      => $services,
            'vehicle_types' => $vehicle_types,

        ]);
    }

    public function getServices(Request $request)
    {
        $filter['type']           = $request->type;
        $filter['merchant']       = $request->merchant;
        $services                 = Service::query();
        if (isset($filter['type'])) {
            if ($filter['type']       == "Towing & Battery/Tyre") {
                $services             = $services->whereJsonContains('type', ["Towing", "Battery/Tyre"]);
            } else {
                $services             = $services->whereJsonContains('type', [$filter['type']]);
            }
        }
        $services                 = isset($filter['merchant']) ? $services->whereJsonContains('merchants', [(int)$filter['merchant']]) : $services;
        $services                 = $services->get(['id as key', 'name as value', 'price']);
        return response()->json(['services' => $services], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'workshop'              => ['required'],
            'service'               => ['required'],
            'type'                  => ['required'],
            'name'                  => ['required', 'string', 'max:255'],
            // 'email'                 => ['required', 'string', 'email', 'max:255'],
            'phone'                 => ['required'],
            'breakdownLocation'     => ['required'],
            'vehicle'               => ['required'],
            'licensePlateNumber'   => ['required'],
            'priority'              => ['required'],
            'shippingfee'            => ['required'],
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }

        $task                      = new Task();
        $task->merchant_id         = $request->workshop;
        $task->driver_id           = $request->driver ? $request->driver : null;
        $task->service_id          = $request->service;
        $task->type                = $request->type  == 'Towing & Battery/Tyre' ? 'Towing' : $request->type;
        $task->name                = $request->name;
        $task->email               = $request->email;
        $task->iso2                = 'sg';
        $task->dialcode            = '+65';
        $task->phone               = $request->phone;
        $task->address             = $request->breakdownLocation;
        $task->latitude            = $request->latitude;
        $task->longitude           = $request->longitude;
        $task->location            = $request->locationDetail;
        // $task->due_time            = $request->due_time;
        $task->vehicle_type        = $request->vehicle;
        $task->registration_number = $request->licensePlateNumber;
        $task->priority            = $request->priority;
        $task->due_amount          = 0;
        $task->towing_fee          = $request->shippingfee;
        $task->status              = 'active';
        $task->requirements        = $request->requirements;
        $task->notes               = $request->notes;
        $task->remarks             = $request->remarks;
        $task->service_time        = 0;
        $task->arrival_time        = null;
        $task->completion_time     = null;
        $task->signature           = null;
        $task->driver_notes        = null;
        $task->added_by_id         = $request->user()->id;
        $task->dispatched_by_id    = $request->user()->id;

         $task->destination_contact_name = $request->destination_contact_name;
         $task->destination_contact_email = $request->destination_contact_email;
         $task->destination_dialcode = $request->destination_dialcode;
         $task->destination_phone = $request->destination_phone;
         $task->destination_address = $request->destination_address;
         $task->destination_building_floor_room = $request->destination_building_floor_room;
         $task->destination_latitude = $request->destination_latitude;
         $task->destination_longitude = $request->destination_longitude;
         $task->destination_notes = $request->destination_notes;
         $task->destination_iso2 = $request->destination_iso2;
         $task->ticket_no           = $request->ticket_no;
         $task->battery_tyre_size   = $request->battery_tyre_size;

        $task->save();

        $pid = $task->id;

        if ($request->type == "Towing & Battery/Tyre") {
            $task                      = new Task();
            $task->merchant_id         = $request->workshop;
            $task->parent_task_id      = $pid;
            $task->driver_id           = $request->driver ? $request->driver : null;
            $task->service_id          = $request->service;
            $task->ticket_no           = $request->ticket_no;
            $task->battery_tyre_size   = $request->battery_tyre_size;
            $task->type                = "Battery/Tyre";
            $task->name                = $request->name;
            $task->email               = $request->email;
            $task->iso2                = 'sg';
            $task->dialcode            = '+65';
            $task->phone               = $request->phone;
            $task->address             = $request->breakdownLocation;
            $task->latitude            = $request->latitude;
            $task->longitude           = $request->longitude;
            $task->location            = $request->locationDetail;
            // $task->due_time            = $request->due_time;
            $task->vehicle_type        = $request->vehicle;
            $task->registration_number = $request->licensePlateNumber;
            $task->priority            = $request->priority;
            $task->due_amount          = 0;
            $task->towing_fee          = 0;
            $task->status              = 'active';
            $task->requirements        = $request->requirements;
            $task->remarks             = $request->remarks;
            $task->notes               = $request->notes;
            $task->service_time        = 0;
            $task->arrival_time        = null;
            $task->completion_time     = null;
            $task->signature           = null;
            $task->driver_notes        = null;
            $task->added_by_id         = $request->user()->id;
            $task->dispatched_by_id    = $request->user()->id;
            $task->save();
        }

        return response()->json([
            'status_code' => 200,
            'success' => 'Task created Successfully.'
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'workshop'              => ['required'],
            'service'               => ['required'],
            'type'                  => ['required'],
            'name'                  => ['required', 'string', 'max:255'],
            // 'email'                 => ['required', 'string', 'email', 'max:255'],
            'phone'                 => ['required'],
            'breakdownLocation'     => ['required'],
            'vehicle'               => ['required'],
            'licensePlateNumber'   => ['required'],
            'priority'              => ['required'],
            'shippingfee'            => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }

        $task                      = Task::find($request->task_id);
        $task->merchant_id         = $request->workshop;
        $task->driver_id           = $request->driver ? $request->driver : null;
        $task->service_id          = $request->service;
        $task->type                = $request->type;
        $task->name                = $request->name;
        $task->email               = $request->email;
        $task->iso2                = 'sg';
        $task->dialcode            = '+65';
        $task->phone               = $request->phone;
        $task->address             = $request->breakdownLocation;
        $task->latitude            = $request->latitude;
        $task->longitude           = $request->longitude;
        $task->location            = $request->locationDetail;
        // $task->due_time            = $request->due_time;
        $task->vehicle_type        = $request->vehicle;
        $task->registration_number = $request->licensePlateNumber;
        $task->priority            = $request->priority;
        $task->due_amount          = 0;
        $task->towing_fee          = $request->shippingfee;
        $task->status              = 'active';
        $task->requirements        = $request->requirements;
        $task->notes               = $request->notes;
        $task->remarks             = $request->remarks;
        $task->service_time        = 0;
        $task->arrival_time        = null;
        $task->completion_time     = null;
        $task->signature           = null;
        $task->driver_notes        = null;
        //$task->added_by_id         = is_null($task->added_by_id) ? $request->user()->id : null;
        $task->dispatched_by_id    = is_null($task->dispatched_by_id) ? $request->user()->id : null;


        $task->destination_contact_name = $request->destination_contact_name;
        $task->destination_contact_email = $request->destination_contact_email;
        $task->destination_dialcode = $request->destination_dialcode;
        $task->destination_phone = $request->destination_phone;
        $task->destination_address = $request->destination_address;
        $task->destination_building_floor_room = $request->destination_building_floor_room;
        $task->destination_latitude = $request->destination_latitude;
        $task->destination_longitude = $request->destination_longitude;
        $task->destination_notes = $request->destination_notes;
        $task->destination_iso2 = $request->destination_iso2;
        $task->ticket_no           = $request->ticket_no;
        $task->battery_tyre_size   = $request->battery_tyre_size;

        $task->save();

        return response()->json([
            'status_code' => 200,
            'success' => 'Task updated Successfully.'
        ]);
    }


    public function help(Request $request)
    {
        ContactUs::create([
            'user_id' => $request->user()->id,
            'user' => 'dispatcher',
            'source' => 'dispatcher-app',
            'name' => $request->user()->firstname . ' ' . $request->user()->lastname,
            'email' => $request->user()->email,
            'phone' => $request->user()->phone,
            'message' => $request->message
        ]);
        return response()->json(['success' => 'Query added successfully!']);
    }

    public function getDrivers()
    {
        $drivers = User::select(DB::raw("CONCAT(firstname, ' ', lastname) AS value"), "id as key")->get();
        return response()->json([
            'drivers' => $drivers
        ]);
    }

    public function googlePlaces(Request $request)
    {
        $query = $request->input('search');
        $apiKey =  'AIzaSyA3dee6tVqiCy3L5nLbxdwG0wNI0JWCO-o';
        if (!$query) {
            return response()->json(['error' => 'Search parameter is required'], 400);
        }

        $response = Http::get('https://maps.googleapis.com/maps/api/place/autocomplete/json', [
            'input' => $query,
            'key' => $apiKey,
            'language' => 'en',
            'components' => 'country:sg'
            // 'includedRegionCodes' => ['sg']
        ]);

        if ($response->successful()) {
            $predictions = $response->json()['predictions'];
            $locations = [];


            foreach ($predictions as $place) {

                $placeDetails = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                    'place_id' => $place['place_id'],
                    'key' => $apiKey,
                ]);


                if ($placeDetails->successful()) {
                    $location = $placeDetails->json()['result']['geometry']['location'];

                    $locations[] = [
                        'key' => $place['place_id'],
                        'value' => $place['description'],
                        'latitude' => $location['lat'],
                        'longitude' => $location['lng'],
                    ];
                }
            }

            return response()->json($locations);
        } else {
            return response()->json(['error' => $response->json()['error_message']], 500);
        }
    }

    public function mapDrivers(Request $request)
    {
        $drivers  = User::select('id', 'phone', 'firstname','avatar','slug', 'email', 'is_online', 'lastname', 'latitude', 'longitude', 'vehicle_type', 'vehicle_description', 'vehicle_registration_no');
        if (isset($request->filter)) {
            $drivers = $drivers->whereIsOnline($request->filter);
        }
        $drivers = $drivers->whereStatus('1')->orderBy('id', 'desc')->get();

        $drivers = $drivers->map((function ($driver) {

            $ini = $driver->firstname[0] . '' . (isset($driver->lastname) ? $driver->lastname[0] : '');

            return [

                'id' => $driver->id,
                'name' => $driver->firstname . ' ' . $driver->lastname,
                'lat'  => $driver->latitude,
                'long' => $driver->longitude,
                'initials' => $ini,
                'email'   => $driver->email,
                'is_onine' => $driver->is_online,
                'phone' => $driver->phone,
                'avatar' => !is_null($driver->avatar) ? asset('storage/uploads/drivers/' . $driver->slug . '/' . $driver->avatar) : null,
                'vehicle' => $driver->vehicle_type . ' | ' . $driver->vehicle_description . ' | ' . $driver->vehicle_registration_no
            ];
        }));

        return response()->json(['drivers' => $drivers]);
    }

       
    public function addDriver(Request $request)
    {
        $password = Hash::make($request->password);
        $inputs = $request->all();
        $inputs['password'] = $password;

        User::create($inputs);
        return response()->json(['success' => 'Driver added successfully.']);
    }

    public function assignDriver(Request $request)
    {

        $task = Task::find($request->task_id);
        if( is_null($task->service_id) ){
            return response()->json([
                'fail' => 'There has been no service added on this task. Please add service on task first',
                'id' => $task->id
            ]);
        }
        $task->driver_id = $request->driver_id;
        $task->dispatched_by_id    = is_null($task->dispatched_by_id) ? $request->user()->id : null;
        $task->save();

        $parent_task_id = $task->parent_task_id;
        if (!is_null($parent_task_id)) {
            $parent_task = Task::find($parent_task_id)->first();
            $parent_task->driver_id = $request->driver_id;
            $parent_task->save();
        }

        Task::whereParentTaskId($request->task_id)->update(['driver_id' => $request->driver_id]);

        return response()->json([
            'success' => 'Driver has been assigned.',
            'id' => $task->id
        ]);
    }

    public function destinationDetails($id){

        $destination = MerchantStoreDetail::where('merchant_id', $id)->first();
        return response()->json([
            'destination' => null
        ]);
    }
}

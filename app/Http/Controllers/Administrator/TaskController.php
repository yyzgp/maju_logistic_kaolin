<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\DriverTask;
use App\Models\Merchant;
use App\Models\Service;
use App\Models\Task;
use App\Models\TaskPhoto;
use App\Models\User;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter                 = [];
        $filter['name']         = $request->name;
        $filter['email']        = $request->email;
        $filter['phone']        = $request->phone;
        $filter['merchant']     = $request->merchant;
        $filter['driver']       = $request->driver;
        $filter['priority']     = $request->priority;
        $filter['status']       = $request->status;
        $filter['driver']       = $request->driver;
        $filter['created_at']   = $request->created_at;
        $filter['task']         = $request->task;
        $filter['month']        = $request->month;

        $tasks                  = Task::query();
        $tasks                  = isset($filter['name']) ? $tasks->where("name", 'LIKE', '%' . $filter['name'] . '%') : $tasks;
        $tasks                  = isset($filter['email']) ? $tasks->where('email', 'LIKE', '%' . $filter['email'] . '%') : $tasks;
        $tasks                  = isset($filter['phone']) ? $tasks->where('phone', 'LIKE', '%' . $filter['phone'] . '%') : $tasks;
        $tasks                  = isset($filter['driver']) ? $tasks->where('driver_id', $filter['driver']) : $tasks;
        $tasks                  = isset($filter['task']) && $filter['task'] == 'my'  ? $tasks->where('dispatched_by_id', auth()->user()?->id) : $tasks;

        if (isset($filter['status']) && $filter['status'] != 'unassigned') {
             if ($filter['status'] == 'all') {
                $tasks = $tasks;
            } else
            {
                $tasks->where('status', $filter['status']);
            }
        } elseif ($filter['status'] == 'unassigned') {
            $tasks->where('driver_id', null);
        } else {
            $tasks;
        }
        $tasks                  = isset($filter['merchant']) ? $tasks->where('merchant_id', $filter['merchant']) : $tasks;
        $tasks                  = isset($filter['priority']) ? $tasks->where('priority', $filter['priority']) : $tasks;
        $tasks                  = isset($filter['created_at']) ? $tasks->whereDate('created_at', $filter['created_at']) : $tasks;
        $tasks                  = isset($filter['month']) ? $tasks->whereMonth('created_at', $filter['month']) : $tasks;
        if (isset($filter['driver'])) {
            if ($filter['driver'] == "unassigned") {
                $tasks                  = $tasks->whereNull("driver_id");
            }
            if ($filter['driver'] == "assigned") {
                $tasks                  = $tasks->whereNotNull("driver_id");
            }
        }
        $tasks                  = $tasks->orderBy('id', 'desc');

        if (isset($request->current_month)) {
            $tasks->whereMonth('created_at', Carbon::now()->format('m'));
        }
        $tasks = $tasks->paginate(10);

        $merchants              = Merchant::get(['id', 'name']);
        $drivers                = User::get(['id', 'firstname', 'lastname', 'avatar']);

        $all_drivers            = $drivers->map(function ($driver) {
            return [
                'id'                    => $driver->id,
                'firstname'             => $driver->firstname,
                'lastname'              => $driver->lastname,
                'avatar'                => isset($driver->avatar) ? asset('storage/uploads/drivers/' . $driver->slug . '/' . $driver->avatar) : "https://placehold.co/150x150/D82D36/FFF?text=" . $driver->firstname[0] . '' . (isset($driver->lastname) ? $driver->lastname[0]  : ''),
                'total_assigned_jobs'   => Task::where('driver_id', $driver->id)->whereIn('status', ['active', 'in-transist', 'arrived'])->count(),
                'total_completed_jobs'  => Task::where('driver_id', $driver->id)->where('status', 'completed')->count()
            ];
        });
        return view('administrator.tasks.list', compact('tasks', 'filter', 'merchants', 'drivers', 'all_drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $merchants      = Merchant::get(['id', 'name']);
        $drivers        = User::get(['id', 'firstname', 'lastname']);
        $services       = Service::get(['id', 'name']);
        $vehicle_types  = VehicleType::get();
        return view('administrator.tasks.create', compact('merchants', 'drivers', 'services', 'vehicle_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'merchant'              => ['required'],
            'service'               => $request->type != "Other" ? ['required'] : "",
            'type'                  => ['required'],
            'name'                  => ['required', 'string', 'max:255'],
            // 'email'                 => ['required', 'string', 'email', 'max:255'],
            'phone'                 => ['required'],
            'address'               => ['required'],
            // 'due_time'              => ['required'],
            'vehicle_type'          => ['required'],
            'registration_number'   => ['required'],
            'priority'              => ['required'],
            'towing_fee'            => ['required'],
            'status'                => ['required'],
        ]);
        $request->status == "unassigned" ? "active" :  $request->status;

        $task                      = new Task();
        $task->merchant_id         = $request->merchant;
        if ($request->status == "unassigned") {
            $task->driver_id           = null;
        } else {
            $task->driver_id           = $request->driver ? $request->driver : null;
        }
        $task->service_id          = $request->service;
        $task->type                = $request->type  == 'Towing & Battery/Tyre' ? 'Towing' : $request->type;
        $task->battery_tyre_size   = $request->battery_tyre_size;
        $task->name                = $request->name;
        $task->email               = $request->email;
        $task->iso2                = $request->iso2;
        $task->dialcode            = $request->dialcode;
        $task->phone               = $request->phone;
        $task->address             = $request->address;
        $task->latitude            = $request->latitude;
        $task->longitude           = $request->longitude;
        $task->location            = $request->location;
        $task->due_time            = $request->due_time;
        $task->vehicle_type        = $request->vehicle_type;
        $task->registration_number = $request->registration_number;
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
        $task->priority            = $request->priority;
        $task->due_amount          = 0;
        $task->remarks             = $request->remarks;
        $task->towing_fee          = $request->towing_fee;
        $task->status              = $request->status == "unassigned" ? "active" :  $request->status;
        $task->requirements        = $request->requirements;
        $task->notes               = $request->notes;
        $task->ticket_no           = $request->ticket_no;
        $task->service_time        = 0;
        $task->arrival_time        = null;
        $task->completion_time     = null;
        $task->signature           = null;
        $task->driver_notes        = null;
        $task->added_by_id         = Auth::user()->id;
        $task->dispatched_by_id    = null;
        $task->save();

        if ($request->type == "Towing & Battery/Tyre") {
            $new_task                      = new Task();
            $new_task->merchant_id         = $request->merchant;
            $new_task->parent_task_id      = $task->id;
            $new_task->driver_id           = $request->driver ? $request->driver : null;
            $new_task->service_id          = $request->service;
            $new_task->type                = "Battery/Tyre";
            $task->battery_tyre_size       = $request->battery_tyre_size;
            $new_task->name                = $request->name;
            $new_task->email               = $request->email;
            $new_task->iso2                = $request->iso2;
            $new_task->dialcode            = $request->dialcode;
            $new_task->phone               = $request->phone;
            $new_task->address             = $request->address;
            $new_task->latitude            = $request->latitude;
            $new_task->longitude           = $request->longitude;
            $new_task->location            = $request->location;
            $new_task->due_time            = $request->due_time;
            $new_task->vehicle_type        = $request->vehicle_type;
            $new_task->registration_number = $request->registration_number;
            $new_task->destination_contact_name = $request->destination_contact_name;
            $new_task->destination_contact_email = $request->destination_contact_email;
            $new_task->destination_dialcode = $request->destination_dialcode;
            $new_task->destination_phone = $request->destination_phone;
            $new_task->destination_address = $request->destination_address;
            $new_task->destination_building_floor_room = $request->destination_building_floor_room;
            $new_task->destination_latitude = $request->destination_latitude;
            $new_task->destination_longitude = $request->destination_longitude;
            $new_task->destination_notes = $request->destination_notes;
            $new_task->destination_iso2 = $request->destination_iso2;
            $new_task->priority            = $request->priority;
            $new_task->due_amount          = 0;
            $new_task->towing_fee          = 0;
            $new_task->status              = $request->status == "unassigned" ? "active" :  $request->status;
            $new_task->requirements        = $request->requirements;
            $new_task->notes               = $request->notes;
            $new_task->ticket_no           = $request->ticket_no;
            $new_task->service_time        = 0;
            $new_task->arrival_time        = null;
            $new_task->completion_time     = null;
            $new_task->signature           = null;
            $new_task->driver_notes        = null;
            $new_task->added_by_id         = Auth::user()->id;
            $new_task->dispatched_by_id    = null;
            $new_task->save();
        }
        $driver = User::find($request->driver);
        if (!is_null($driver))
            $this->appNotify($driver->app_push_token, 'New Task Assigned', 'Found a new task for you. please check');



        return redirect()->route('administrator.tasks.index')->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task           = Task::find($id);
        $task->avatar   = "https://placehold.co/150x150/D82D36/FFF?text=" . $task->name[0] . '' . ucfirst($task->name[1]);
        $merchants      = Merchant::get(['id', 'name']);
        $drivers        = User::get(['id', 'firstname', 'lastname']);
        $services       = Service::get(['id', 'name']);
        $vehicle_types  = VehicleType::get();
        $epods = $this->getEpods($id);
        return view('administrator.tasks.show', compact('task', 'merchants', 'drivers', 'services', 'epods'));
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
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task          = Task::find($id);
        $merchants      = Merchant::get(['id', 'name']);
        $drivers        = User::get(['id', 'firstname', 'lastname']);
        $services       = Service::get(['id', 'name']);
        $vehicle_types  = VehicleType::get();
        return view('administrator.tasks.edit', compact('task', 'merchants', 'drivers', 'services', 'vehicle_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'type'                  => ['required'],
            'merchant'              => ['required'],
            'service'               => $request->type != "Other" ? ['required'] : "",
            'name'                  => ['required', 'string', 'max:255'],
            //'email'                 => ['required', 'string', 'email', 'max:255'],
            'phone'                 => ['required'],
            'address'               => ['required'],
            // 'due_time'              => ['required'],
            'vehicle_type'          => ['required'],
            'registration_number'   => ['required'],
            'priority'              => ['required'],
            'towing_fee'            => ['required'],
            'status'                => ['required'],
        ]);

        //  dd($request->type);

        $task                      = Task::find($id);
        $task->merchant_id         = $request->merchant;
        if ($request->status == "unassigned") {
            $task->driver_id           = null;
        } else {
            $task->driver_id           = $request->driver ? $request->driver : null;
        }
        $task->service_id          = $request->service;
        $task->type                = $request->type;
        $task->battery_tyre_size   = $request->battery_tyre_size;
        $task->name                = $request->name;
        $task->email               = $request->email;
        $task->iso2                = $request->iso2;
        $task->dialcode            = $request->dialcode;
        $task->phone               = $request->phone;
        $task->address             = $request->address;
        $task->latitude            = $request->latitude;
        $task->longitude           = $request->longitude;
        $task->location            = $request->location;
        $task->due_time            = $request->due_time;
        $task->vehicle_type        = $request->vehicle_type;
        $task->registration_number = $request->registration_number;
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
        $task->priority            = $request->priority;
        $task->due_amount          = 0;
        $task->towing_fee          = $request->towing_fee;
        $task->status              =  $request->status == "unassigned" ? "active" :  $request->status;
        $task->requirements        = $request->requirements;
        $task->notes               = $request->notes;
        $task->remarks             = $request->remarks;
        $task->ticket_no           = $request->ticket_no;
        $task->service_time        = 0;
        $task->arrival_time        = null;
        $task->completion_time     = null;
        $task->signature           = null;
        $task->driver_notes        = null;
        $task->added_by_id         = Auth::user()->id;
        $task->dispatched_by_id    = null;
        $task->save();

        $child_task_exists = Task::where('parent_task_id', $id)->exists();
        if($child_task_exists){
            $child_task = Task::where('parent_task_id', $id)->first();
            $child_task->destination_contact_name = $request->destination_contact_name;
            $child_task->destination_contact_email = $request->destination_contact_email;
            $child_task->destination_dialcode = $request->destination_dialcode;
            $child_task->destination_phone = $request->destination_phone;
            $child_task->destination_address = $request->destination_address;
            $child_task->destination_building_floor_room = $request->destination_building_floor_room;
            $child_task->destination_latitude = $request->destination_latitude;
            $child_task->destination_longitude = $request->destination_longitude;
            $child_task->destination_notes = $request->destination_notes;
            $child_task->destination_iso2 = $request->destination_iso2;

            $child_task->address             = $request->address;
            $child_task->latitude            = $request->latitude;
            $child_task->longitude           = $request->longitude;
            $child_task->location            = $request->location;

            $child_task->save();
        }

        $driver = User::find($request->driver);
        if (!is_null($driver))
            $this->appNotify($driver->app_push_token, 'Task Updated', 'Task assigned to you has been updated.');

        return redirect()->route('administrator.tasks.index')->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::find($id)->delete();
        return redirect()->route('administrator.tasks.index')->with('success', 'Task deleted successfully!');
    }

    public function changeStatus(Request $request)
    {
        $task = Task::find($request->task_id);
        Task::find($request->task_id)->update(['status' => $request->status]);
        if ($request->status == 'active') {
            DriverTask::where(
                [
                    'task_id' => $request->task_id,
                    'user_id' => $task->driver_id,

                ]
            )->delete();
        } else {
            DriverTask::updateOrCreate(
                [
                    'task_id' => $request->task_id,
                    'user_id' => $task->driver_id,
                ],
                [
                    'status' => $request->status,
                    'decline_reason' => 'Manually changed from admin'
                ]
            );
        }

        return response()->json(['success' => 'Task status has been changed successfully!'], 200);
    }

    public function bulkDelete(Request $request)
    {
        Task::whereIn('id', $request->tasks)->delete();
        return response()->json(['success' => 'Tasks deleted successfully!'], 200);
    }

    public function assignDriver(Request $request)
    {
        $task = Task::find($request->task_id);
        Task::find($request->task_id)->update(['driver_id' => $request->driver]);
        return response()->json(['success' => 'Driver assigned successfully!'], 200);
    }

    public function driverAssign(Request $request)
    {
        $task = Task::find($request->task_id);
        $service = Service::find($request->service);
        if ($task->status == "failed") {
            Task::find($request->task_id)->update(['driver_id' => $request->driver, 'status' => 'active']);

        } else {
            Task::find($request->task_id)->update(['driver_id' => $request->driver]);
        }

        $child_task_exists = Task::where("parent_task_id", $request->task_id);
        if ($child_task_exists->exists()) {
            $child_task = Task::where("parent_task_id", $request->task_id)->first();
            $child_task->driver_id = $request->driver;
            $child_task->save();
        }
        Task::find($request->task_id)->update(['driver_id' => $request->driver, 'service_id' => $service->id, 'towing_fee' => $service->price]);
        return redirect()->back()->with('success', 'Driver assigned successfully!');
    }

    public function getDetails(Request $request)
    {
        $task = Task::find($request->task_id);
        return response()->json(["task" => $task]);
    }

    public function appNotify($token, $title, $msg)
    {
        $response = Http::post('https://exp.host/--/api/v2/push/send', [
            'to' => $token,
            'title' => $title,
            'body' => $msg,
        ]);
    }
}

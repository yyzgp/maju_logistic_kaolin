<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }
    public function index(Request $request){
        $assigned_tasks       = Task::whereNotNull("driver_id")->whereIn('status',['active','in-transist','arrived'])->orderBy("id", "desc")->get();
        $unassigned_tasks     = Task::whereNull("driver_id")->orderBy("id", "desc")->get();
        $completed_tasks      = Task::where("status", "completed")->orderBy("id", "desc")->get();
        $drivers              = User::get();
        $drivers              = $drivers->map(function ($driver) {
            return [
                'id'                    => $driver->id,
                'firstname'             => $driver->firstname,
                'lastname'              => $driver->lastname,
                'latitude'              => $driver->latitude,
                'longitude'             => $driver->longitude,
                'status'                => $driver->status,
                'dialcode'                => $driver->dialcode,
                'phone'                => $driver->phone,
                'email'                => $driver->email,
                'address'                => $driver->address,
                'vehicle_type'          => $driver->vehicle_type,
                'vehicle_registration_no' => $driver->vehicle_registration_no,
                'avatar'                => isset($driver->avatar) ? asset('storage/uploads/drivers/' . $driver->slug . '/' . $driver->avatar) : "https://placehold.co/150x150/D82D36/FFF?text=" . $driver->firstname[0] . '' .( isset( $driver->lastname ) ? $driver->lastname[0]  : ''),
                'total_assigned_jobs'   => Task::where('driver_id', $driver->id)->whereIn('status',['active','in-transist','arrived'])->count(),
                'total_completed_jobs'  => Task::where('driver_id', $driver->id)->where('status', 'completed')->count()
            ];
        });
        return view("administrator.maps.index", compact('assigned_tasks', 'unassigned_tasks', 'completed_tasks', 'drivers'));
    }

    public function driversNearby(Request $request){
        $task = Task::where('id', $request->task_id)->get()[0];
        $drivers              = User::get();
        $services             = Service::whereJsonContains('merchants', [(int)$task->merchant_id])->get();
        $drivers              = $drivers->map(function ($driver) use ($task) {
            return [
                'id'                    => $driver->id,
                'firstname'             => $driver->firstname,
                'lastname'              => $driver->lastname,
                'latitude'              => $driver->latitude,
                'longitude'             => $driver->longitude,
                'status'                => $driver->status,
                'dialcode'                => $driver->dialcode,
                'phone'                => $driver->phone,
                'email'                => $driver->email,
                'address'                => $driver->address,
                'vehicle_type'          => $driver->vehicle_type,
                'vehicle_registration_no' => $driver->vehicle_registration_no,
                'avatar'                => isset($driver->avatar) ? asset('storage/uploads/drivers/' . $driver->slug . '/' . $driver->avatar) : "https://placehold.co/150x150/D82D36/FFF?text=" . $driver->firstname[0] . '' .( isset( $driver->lastname ) ? $driver->lastname[0]  : ''),
                'total_assigned_jobs'   => Task::where('driver_id', $driver->id)->whereIn('status',['active','in-transist','arrived'])->count(),
                'total_completed_jobs'  => Task::where('driver_id', $driver->id)->where('status', 'completed')->count(),
                'distance'              => $driver->distance($task->latitude, $task->longitude)
            ];
        })->sortBy('distance');
        $html = view('administrator.maps.assign', compact('task', 'drivers', 'services'))->render();
        return response()->json($html);
    }
}

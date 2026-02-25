<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    public function index(Request $request)
    {
        $filter                 = [];
        $filter['merchant']     = $request->merchant;
        $filter['status']       = $request->status;
        $filter['driver']       = $request->driver;

        $tasks                  = Task::whereIn('status',['active','in-transist','arrived']);
        // $tasks                  = isset($filter['status']) ? $tasks->where('status', $filter['status']) : $tasks;
        $tasks                  = isset($filter['merchant']) ? $tasks->where('merchant_id', $filter['merchant']) : $tasks;
        $tasks                  = isset($filter['driver']) ? $tasks->where('driver_id', $filter['driver']) : $tasks;
        $tasks                  = $tasks->orderBy('id', 'desc')->get(['id', 'type', 'merchant_id', 'status', 'driver_id']);
        $merchants              = Merchant::all();
        $drivers                = User::get();
        return view("administrator.calendar.list", compact('tasks', 'merchants', 'drivers', 'filter'));
    }
}

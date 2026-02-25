<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\Merchant;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Concurrency\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:administrator');
    }

    // public function index(Request $request)
    // {
    //     $filter['date_range']       = $request->filter;
    //     $filter['start_date']       = $request->start_date;
    //     $filter['end_date']         = $request->end_date;
    //     $user                       = Auth::guard('administrator')->user();

    //     if ($request->start_date) {
    //         $total_merchants        = Merchant::whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
    //         $total_drivers          = User::whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
    //         $total_dispatchers      = Administrator::where('role', 'dispatcher')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
    //         $total_tasks            = Task::whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
    //         $total_active_tasks     = Task::where('status', 'active')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
    //         $total_completed_tasks  = Task::where('status', 'completed')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
    //         $total_failed_tasks     = Task::where('status', 'failed')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
    //         $total_cancelled_tasks  = Task::where('status', 'cancelled')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
    //         $total_unassigned_tasks = Task::whereNull('driver_id')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
    //         $total_assigned_tasks   = Task::whereNotNull('driver_id')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();

    //         return view('administrator.dashboard.dashboard', compact('filter', 'total_merchants', 'total_drivers', 'total_dispatchers', 'total_tasks', 'total_active_tasks', 'total_completed_tasks', 'total_failed_tasks', 'total_cancelled_tasks', 'total_unassigned_tasks', 'total_assigned_tasks', 'user'));
    //     }

    //     if ($request->filter == 'today') {
    //         $total_merchants        = Merchant::whereDate('created_at', Carbon::now())->count();
    //         $total_drivers          = User::whereDate('created_at', Carbon::now())->count();
    //         $total_dispatchers      = Administrator::where('role', 'dispatcher')->whereDate('created_at', Carbon::now())->count();
    //         $total_tasks            = Task::whereDate('created_at', Carbon::now())->count();
    //         $total_active_tasks     = Task::where('status', 'active')->whereDate('created_at', Carbon::now())->count();
    //         $total_completed_tasks  = Task::where('status', 'completed')->whereDate('created_at', Carbon::now())->count();
    //         $total_failed_tasks     = Task::where('status', 'failed')->whereDate('created_at', Carbon::now())->count();
    //         $total_cancelled_tasks  = Task::where('status', 'cancelled')->whereDate('created_at', Carbon::now())->count();
    //         $total_unassigned_tasks = Task::whereNull('driver_id')->whereDate('created_at', Carbon::now())->count();
    //         $total_assigned_tasks   = Task::whereNotNull('driver_id')->whereDate('created_at', Carbon::now())->count();

    //         return view('administrator.dashboard.dashboard', compact('filter', 'total_merchants', 'total_drivers', 'total_dispatchers', 'total_tasks', 'total_active_tasks', 'total_completed_tasks', 'total_failed_tasks', 'total_cancelled_tasks', 'total_unassigned_tasks', 'total_assigned_tasks', 'user'));
    //     }

    //     if ($request->filter == 'yesterday') {
    //         $total_merchants        = Merchant::whereDate('created_at', Carbon::yesterday())->count();
    //         $total_drivers          = User::whereDate('created_at', Carbon::yesterday())->count();
    //         $total_dispatchers      = Administrator::where('role', 'dispatcher')->whereDate('created_at', Carbon::yesterday())->count();
    //         $total_tasks            = Task::whereDate('created_at', Carbon::yesterday())->count();
    //         $total_active_tasks     = Task::where('status', 'active')->whereDate('created_at', Carbon::yesterday())->count();
    //         $total_completed_tasks  = Task::where('status', 'completed')->whereDate('created_at', Carbon::yesterday())->count();
    //         $total_failed_tasks     = Task::where('status', 'failed')->whereDate('created_at', Carbon::yesterday())->count();
    //         $total_cancelled_tasks  = Task::where('status', 'cancelled')->whereDate('created_at', Carbon::yesterday())->count();
    //         $total_unassigned_tasks = Task::whereNull('driver_id')->whereDate('created_at', Carbon::yesterday())->count();
    //         $total_assigned_tasks   = Task::whereNotNull('driver_id')->whereDate('created_at', Carbon::yesterday())->count();

    //         return view('administrator.dashboard.dashboard', compact('filter', 'total_merchants', 'total_drivers', 'total_dispatchers', 'total_tasks', 'total_active_tasks', 'total_completed_tasks', 'total_failed_tasks', 'total_cancelled_tasks', 'total_unassigned_tasks', 'total_assigned_tasks', 'user'));
    //     }

    //     if ($request->filter == "week") {
    //         $total_merchants        = Merchant::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    //         $total_drivers          = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    //         $total_dispatchers      = Administrator::where('role', 'dispatcher')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    //         $total_tasks            = Task::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    //         $total_active_tasks     = Task::where('status', 'active')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    //         $total_completed_tasks  = Task::where('status', 'completed')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    //         $total_failed_tasks     = Task::where('status', 'failed')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    //         $total_cancelled_tasks  = Task::where('status', 'cancelled')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    //         $total_unassigned_tasks = Task::whereNull('driver_id')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    //         $total_assigned_tasks   = Task::whereNotNull('driver_id')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

    //         return view('administrator.dashboard.dashboard', compact('filter', 'total_merchants', 'total_drivers', 'total_dispatchers', 'total_tasks', 'total_active_tasks', 'total_completed_tasks', 'total_failed_tasks', 'total_cancelled_tasks', 'total_unassigned_tasks', 'total_assigned_tasks', 'user'));
    //     }

    //     if ($request->filter == "month") {
    //         $total_merchants        = Merchant::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
    //         $total_drivers          = User::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
    //         $total_dispatchers      = Administrator::where('role', 'dispatcher')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
    //         $total_tasks            = Task::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
    //         $total_active_tasks     = Task::where('status', 'active')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
    //         $total_completed_tasks  = Task::where('status', 'completed')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
    //         $total_failed_tasks     = Task::where('status', 'failed')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
    //         $total_cancelled_tasks  = Task::where('status', 'cancelled')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
    //         $total_unassigned_tasks = Task::whereNull('driver_id')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
    //         $total_assigned_tasks   = Task::whereNotNull('driver_id')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

    //         return view('administrator.dashboard.dashboard', compact('filter', 'total_merchants', 'total_drivers', 'total_dispatchers', 'total_tasks', 'total_active_tasks', 'total_completed_tasks', 'total_failed_tasks', 'total_cancelled_tasks', 'total_unassigned_tasks', 'total_assigned_tasks', 'user'));
    //     }

    //     if ($request->filter == "year") {
    //         $total_merchants        = Merchant::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
    //         $total_drivers          = User::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
    //         $total_dispatchers      = Administrator::where('role', 'dispatcher')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
    //         $total_tasks            = Task::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
    //         $total_active_tasks     = Task::where('status', 'active')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
    //         $total_completed_tasks  = Task::where('status', 'completed')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
    //         $total_failed_tasks     = Task::where('status', 'failed')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
    //         $total_cancelled_tasks  = Task::where('status', 'cancelled')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
    //         $total_unassigned_tasks = Task::whereNull('driver_id')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
    //         $total_assigned_tasks   = Task::whereNotNull('driver_id')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();

    //         return view('administrator.dashboard.dashboard', compact('filter', 'total_merchants', 'total_drivers', 'total_dispatchers', 'total_tasks', 'total_active_tasks', 'total_completed_tasks', 'total_failed_tasks', 'total_cancelled_tasks', 'total_unassigned_tasks', 'total_assigned_tasks', 'user'));
    //     }

    //     $total_merchants        = Merchant::count();
    //     $total_drivers          = User::count();
    //     $total_dispatchers      = Administrator::where('role', 'dispatcher')->count();
    //     $total_tasks            = Task::count();
    //     $total_active_tasks     = Task::where('status', 'active')->count();
    //     $total_completed_tasks  = Task::where('status', 'completed')->count();
    //     $total_failed_tasks     = Task::where('status', 'failed')->count();
    //     $total_cancelled_tasks  = Task::where('status', 'cancelled')->count();
    //     $total_unassigned_tasks = Task::whereNull('driver_id')->count();
    //     $total_assigned_tasks   = Task::whereNotNull('driver_id')->count();


    //     return view('administrator.dashboard.dashboard', compact('filter', 'total_merchants', 'total_drivers', 'total_dispatchers', 'total_tasks', 'total_active_tasks', 'total_completed_tasks', 'total_failed_tasks', 'total_cancelled_tasks', 'total_unassigned_tasks', 'total_assigned_tasks', 'user'));

    // }

    public function index(Request $request){
        $filter                 = [];
        $user                   = Auth::guard('administrator')->user();

        $total_active_tasks     = Task::where('status', 'active')->whereMonth('created_at', Carbon::now()->format('m'))->count();
        $total_completed_tasks  = Task::where('status', 'completed')->whereNotNull('driver_id')->whereMonth('created_at', Carbon::now()->format('m'))->count();
        $total_new_tasks        = Task::where('status', 'in-transist')->whereNotNull('driver_id')->whereMonth('created_at', Carbon::now()->format('m'))->count();
        $today_due_tasks        = Task::where('status', 'active')->whereDate('due_time', Carbon::now()->format('Y-m-d'))->count();

        $total_tasks            = Task::whereMonth('created_at', Carbon::now()->format('m'))->count();
        $total_intransit_tasks  = Task::where('status', 'in-transist')->whereMonth('created_at', Carbon::now()->format('m'))->count();
        $total_arrived_tasks    = Task::where('status', 'arrived')->whereMonth('created_at', Carbon::now()->format('m'))->count();
        $total_failed_tasks     = Task::where('status', 'failed')->whereMonth('created_at', Carbon::now()->format('m'))->count();
        $total_cancelled_tasks  = Task::where('status', 'cancelled')->whereMonth('created_at', Carbon::now()->format('m'))->count();
        $total_unassigned_tasks = Task::whereNull('driver_id')->whereMonth('created_at', Carbon::now()->format('m'))->count();
        $total_assigned_tasks   = Task::whereNotNull('driver_id')->whereMonth('created_at', Carbon::now()->format('m'))->count();

        $drivers                = User::whereHas('activeJobs')->get();
        $drivers                = $drivers->map(function ($driver) {
            return [
                'id'                    => $driver->id,
                'firstname'             => $driver->firstname,
                'lastname'              => $driver->lastname,
                'avatar'                => isset($driver->avatar) ? asset('storage/uploads/drivers/' . $driver->slug . '/' . $driver->avatar) : "https://placehold.co/150x150/D82D36/FFF?text=" . $driver->firstname[0] . '' .( isset( $driver->lastname ) ? $driver->lastname[0]  : ''),
                'total_assigned_jobs'   => Task::where('driver_id', $driver->id)->whereIn('status',['active','in-transist','arrived'])->count(),
                'total_completed_jobs'  => Task::where('driver_id', $driver->id)->where('status', 'completed')->count()
            ];
        });

        return view('administrator.dashboard.dashboard', compact(
            'filter',
            'user',
            'total_active_tasks',
            'total_completed_tasks',
            'total_new_tasks',
            'today_due_tasks',
            'total_tasks',
            'total_arrived_tasks',
            'total_intransit_tasks',
            'total_failed_tasks',
            'total_cancelled_tasks',
            'total_unassigned_tasks',
            'total_assigned_tasks',
            'drivers'
        ));
    }
}

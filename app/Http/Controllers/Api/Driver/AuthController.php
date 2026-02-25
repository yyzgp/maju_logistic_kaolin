<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Registers a new driver account.
     *
     * @bodyParam firstname string required The drivers firstname.
     * @bodyParam email string required The drivers email address.
     * @bodyParam password string required The drivers password.
     *
     * @response scenario=success {
     *  "message": "Driver registered successfully!",
     * }
     */
    public function register(Request $request)
    {
        $data                   = $request->validate([
            'firstname'         => 'required|string',
            'email'             => 'required|string|email|unique:users',
            'password'          => 'required|min:8'
        ]);

        $user                   = User::create([
            'firstname'         => $data['firstname'],
            'email'             => $data['email'],
            'email_verified_at' => now(),
            'password'          => Hash::make($data['password']),
            'remember_token'    => Str::random(10),
        ]);

        return response()->json([
            'message'           => 'Driver registered successfully!',
        ], 200);
    }

    /**
     * Authenticates a driver with the given credentials and returns an access token.
     *
     * @bodyParam email string required The drivers email address.
     * @bodyParam password string required The drivers password.
     *
     * @responseFile responses/login.json
     */
    public function login(Request $request)
    {
        $data                   = $request->validate([
            'email'             => 'required|string|email',
            'password'          => 'required|min:8'
        ]);

        $user                   = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message'       => 'Invalid Credentials'
            ], 401);
        }

        $token                  = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        return response()->json([
            'access_token'      => $token,
        ], 200);
    }

    /**
     * Logout a driver and remove their access token.
     *
     * @responseFile responses/logout.json
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            "message" => "logged out"
        ], 200);
    }

    /**
     * Retrieves the profile of the authenticated driver.
     *
     * @param Request $request The incoming request instance.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $id              = $request->user()->id;
        $driver          = User::find($id);
        $driver->avatar  = isset($driver->avatar) ? asset('storage/uploads/drivers/' . $driver->slug . '/' . $driver->avatar) : "https://placehold.co/150x150/D82D36/FFF?text=" . $driver->firstname[0] . '' .( isset( $driver->lastname ) ? $driver->lastname[0]  : '');
        $driver->lastname =  !is_null( $driver->lastname ) ? '' : $driver->lastname; 
          
        $country = Country::where('code', $driver->iso2)->first();
        $driver->country = is_null($country) ? 'NA' : $country;

        $driver->address = is_null($driver->address) ? 'NA' : $driver->address;
        $driver->latitude = is_null($driver->latitude) ? 'NA' : $driver->latitude;
        $driver->longitude = is_null($driver->longitude) ? 'NA' : $driver->longitude;
        $driver->city = is_null($driver->city) ? 'NA' : $driver->city;
        $driver->state = is_null($driver->state) ? 'NA' : $driver->state;
        $driver->zipcode = is_null($driver->zipcode) ? 'NA' : $driver->zipcode;

        return response()->json([
            "profile" => $driver
        ], 200);
    }

    public function updatePushToken(Request $request)
    {
        User::find($request->user()->id)->update(['app_push_token' => $request->token]);
        return response()->json(['success' => 'Token Updated']);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }

        if (!Hash::check($request->current_password, $request->user()?->password)) {
            return response()->json(['errors' => ['Current password not matched']]);
        }

        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['success' => 'Password has been reset successfully!'], 200);
    }

    public function dashboard(Request $request)
    {

        $filter['date_range']       = $request->filter;
        $filter['start_date']       = $request->start_date;
        $filter['end_date']         = $request->end_date;
        $user                       = $request->user();
        
       

        if ($request->start_date) {

            $all = Task::whereDriverId($user->id)->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
            $total_assigned_tasks   = Task::whereDriverId($user->id)->where('status', 'active')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
            $in_transist_tasks      = Task::whereDriverId($user->id)->where('status', 'in-transist')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
            $total_completed_tasks  = Task::whereDriverId($user->id)->where('status', 'completed')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();
            $total_failed_tasks     = Task::whereDriverId($user->id)->where('status', 'failed')->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])->count();

            $paynow_tasks = 0; $online_pay_task = 0;
            
            $cash_collected = Task::whereDriverId($user->id)
                ->where(function ($q) {
                    $q->whereRaw('JSON_CONTAINS(requirements, \'\"cash-on-delivery\"\')');
                })
                ->whereStatus('completed')
                ->whereBetween('created_at', [$filter['start_date'], $filter['end_date']])
                ->sum('towing_fee');

              return response()->json(compact('filter', 'all', 'total_assigned_tasks', 'in_transist_tasks', 'total_completed_tasks', 'total_failed_tasks', 'paynow_tasks', 'online_pay_task','cash_collected'));
        }

        if ($request->filter == 'today') {

            $all = Task::whereDriverId($user->id)->whereDate('created_at', Carbon::now())->count();
            $total_assigned_tasks   = Task::whereDriverId($user->id)->where('status', 'active')->whereDate('created_at', Carbon::now())->count();
            $in_transist_tasks      = Task::whereDriverId($user->id)->where('status', 'in-transist')->whereDate('created_at', Carbon::now())->count();
            $total_completed_tasks  = Task::whereDriverId($user->id)->where('status', 'completed')->whereDate('created_at', Carbon::now())->count();
            $total_failed_tasks     = Task::whereDriverId($user->id)->where('status', 'failed')->whereDate('created_at', Carbon::now())->count();

            $paynow_tasks = 0; $online_pay_task = 0;
           
            $cash_collected = Task::whereDriverId($user->id)
                ->where(function ($q) {
                    $q->whereRaw('JSON_CONTAINS(requirements, \'\"cash-on-delivery\"\')');
                })
                ->whereStatus('completed')
                ->whereDate('created_at', Carbon::now())
                ->sum('towing_fee');

              return response()->json(compact('filter', 'all', 'total_assigned_tasks', 'in_transist_tasks', 'total_completed_tasks', 'total_failed_tasks', 'paynow_tasks', 'online_pay_task','cash_collected'));
        }

        if ($request->filter == 'yesterday') {
           
            $all = Task::whereDriverId($user->id)->whereDate('created_at', Carbon::yesterday())->count();
            $total_assigned_tasks   = Task::whereDriverId($user->id)->where('status', 'active')->whereDate('created_at', Carbon::yesterday())->count();
            $in_transist_tasks      = Task::whereDriverId($user->id)->where('status', 'in-transist')->whereDate('created_at', Carbon::yesterday())->count();
            $total_completed_tasks  = Task::whereDriverId($user->id)->where('status', 'completed')->whereDate('created_at', Carbon::yesterday())->count();
            $total_failed_tasks     = Task::whereDriverId($user->id)->where('status', 'failed')->whereDate('created_at', Carbon::yesterday())->count();

            $paynow_tasks = 0; $online_pay_task = 0;
            
            $cash_collected = Task::whereDriverId($user->id)
                ->where(function ($q) {
                    $q->whereRaw('JSON_CONTAINS(requirements, \'\"cash-on-delivery\"\')');
                })
                ->whereStatus('completed')
                ->whereDate('created_at', Carbon::yesterday())
                ->sum('towing_fee');


              return response()->json(compact('filter','all', 'total_assigned_tasks', 'in_transist_tasks', 'total_completed_tasks', 'total_failed_tasks', 'paynow_tasks', 'online_pay_task','cash_collected'));
        }

        if ($request->filter == "week") {
           
            $all = Task::whereDriverId($user->id)->where('status', 'active')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $total_assigned_tasks   = Task::whereDriverId($user->id)->where('status', 'active')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $in_transist_tasks      = Task::whereDriverId($user->id)->where('status', 'in-transist')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $total_completed_tasks  = Task::whereDriverId($user->id)->where('status', 'completed')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $total_failed_tasks     = Task::whereDriverId($user->id)->where('status', 'failed')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

            $paynow_tasks = 0; $online_pay_task = 0;
            
            $cash_collected = Task::whereDriverId($user->id)
                ->where(function ($q) {
                    $q->whereRaw('JSON_CONTAINS(requirements, \'\"cash-on-delivery\"\')');
                })
                ->whereStatus('completed')
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->sum('towing_fee');

              return response()->json(compact('filter','all', 'total_assigned_tasks', 'in_transist_tasks', 'total_completed_tasks', 'total_failed_tasks', 'paynow_tasks', 'online_pay_task','cash_collected'));
        }

        if ($request->filter == "month") {

            $all = Task::whereDriverId($user->id)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
            $total_assigned_tasks   = Task::whereDriverId($user->id)->where('status', 'active')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
            $in_transist_tasks      = Task::whereDriverId($user->id)->where('status', 'in-transist')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
            $total_completed_tasks  = Task::whereDriverId($user->id)->where('status', 'completed')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
            $total_failed_tasks     = Task::whereDriverId($user->id)->where('status', 'failed')->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

            $paynow_tasks = 0; $online_pay_task = 0;
            
            $cash_collected = Task::whereDriverId($user->id)
                ->where(function ($q) {
                    $q->whereRaw('JSON_CONTAINS(requirements, \'\"cash-on-delivery\"\')');
                })
                ->whereStatus('completed')
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                ->sum('towing_fee');

              return response()->json(compact('filter', 'all', 'total_assigned_tasks', 'in_transist_tasks', 'total_completed_tasks', 'total_failed_tasks', 'paynow_tasks', 'online_pay_task','cash_collected'));
        }

        if ($request->filter == "year") {
            
            $all = Task::whereDriverId($user->id)->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
            $total_assigned_tasks   = Task::whereDriverId($user->id)->where('status', 'active')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
            $in_transist_tasks      = Task::whereDriverId($user->id)->where('status', 'in-transist')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
            $total_completed_tasks  = Task::whereDriverId($user->id)->where('status', 'completed')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
            $total_failed_tasks     = Task::whereDriverId($user->id)->where('status', 'failed')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();

            $paynow_tasks = 0; $online_pay_task = 0;

            $cash_collected = Task::whereDriverId($user->id)
                ->where(function ($q) {
                    $q->whereRaw('JSON_CONTAINS(requirements, \'\"cash-on-delivery\"\')');
                })
                ->whereStatus('completed')
                ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                ->sum('towing_fee');

              return response()->json(compact('filter','all', 'total_assigned_tasks', 'in_transist_tasks', 'total_completed_tasks', 'total_failed_tasks', 'paynow_tasks', 'online_pay_task','cash_collected'));

        }

            $all = Task::whereDriverId($user->id)->count();
            $total_assigned_tasks   = Task::whereDriverId($user->id)->where('status', 'active')->count();
            $in_transist_tasks      = Task::whereDriverId($user->id)->where('status', 'in-transist')->count();
            $total_completed_tasks  = Task::whereDriverId($user->id)->where('status', 'completed')->count();
            $total_failed_tasks     = Task::whereDriverId($user->id)->where('status', 'failed')->count();

            
                $cash_collected =  Task::whereDriverId($user->id)
                ->where(function ($q) {
                    $q->where(DB::raw('JSON_CONTAINS(requirements, \'"cash-on-delivery"\' )'), 1);
                })
                ->count();
            $paynow_tasks = 0; $online_pay_task = 0;

            $cash_collected = Task::whereDriverId($user->id)
                ->where(function ($q) {
                    $q->whereRaw('JSON_CONTAINS(requirements, \'\"cash-on-delivery\"\')');
                })
                ->whereStatus('completed')
                ->sum('towing_fee');

            return response()->json(compact('filter','all', 'total_assigned_tasks', 'in_transist_tasks', 'total_completed_tasks', 'total_failed_tasks', 'paynow_tasks', 'online_pay_task','cash_collected'));
    }
}

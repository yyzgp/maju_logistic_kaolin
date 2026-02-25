<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\CompanySetting;
use App\Models\ContactUs;
use App\Models\Country;
use App\Models\DeliveryOrder;
use App\Models\DriverDoc;
use App\Models\DriverTask;
use App\Models\Service;
use App\Models\Task;
use App\Models\TaskPhoto;
use App\Models\User;
use App\Notifications\SendDONotification;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Http\Client\Exception\HttpException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function taskList(Request $request)
    {

        $uid = $request->user()->id;
        $status = $request->status;

        $filter['date_range']       = $request->filter;
        $filter['start_date']       = $request->start_date;
        $filter['end_date']         = $request->end_date;

        switch ($status) {
            case 'completed':
                $tasks = Task::whereDriverId($uid)->whereStatus('completed')->with('merchant', 'merchant.storeDetail');
                break;
            case 'rejected':
                $tasks = Task::whereDriverId($uid)->whereStatus('failed')->with('merchant', 'merchant.storeDetail');
                break;
            case 'active':
                $tasks = Task::whereDriverId($uid)->whereStatus('active')->with('merchant', 'merchant.storeDetail');
                break;
            default:
                $tasks = Task::whereDriverId($uid)->with('merchant', 'merchant.storeDetail');
        }
        if ($request->start_date) {

            $tasks->whereBetween('created_at', [$filter['start_date'], $filter['end_date']]);
        }
        if ($request->filter == 'today') {

            $tasks->whereDate('created_at', Carbon::now());
        }
        if ($request->filter == 'yesterday') {

            $tasks->whereDate('created_at', Carbon::yesterday());
        }
        if ($request->filter == "week") {

            $tasks->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        }
        if ($request->filter == "month") {

            $tasks->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        }
        if ($request->filter == "year") {

            $tasks->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
        }

        $tasks = $tasks->orderBy('id', 'desc')->paginate(10);


        $tasks->through(function ($t) {

            $ini = explode(' ', $t->name);
            $ini = $ini[0][0] . '' . (isset($ini[1]) ? $ini[1][0] : '');

            //Child job Battery/Tyre
            if (!is_null($t->parent_task_id)) {
                //$pickup = $t->merchant->storeDetail?->address ?? 'NA';
                $pickup = $t->destination_address ?? 'NA';
                $drop = $t->address;
            } else if ($t->type == 'Battery/Tyre') {
                $pickup = $t->merchant->storeDetail?->address ?? 'NA';
                $drop = $t->address ?? 'NA';
                //$drop = $t->merchant->storeDetail?->address ?? 'NA';{

            } else {
                $pickup = $t->address;
                $drop = $t->destination_address ?? 'NA';
                //$drop = $t->merchant->storeDetail?->address ?? 'NA';
            }

            $parent = Task::whereParentTaskId($t->id)->first();
            $is_double = !is_null($parent)  || !is_null($t->parent_task_id)  ? true : false;


            if ($t->merchant?->name == 'PAYNOW') {
                $payment = 'Cash/Paynow Payment';
            } elseif (!is_null($t->requirements) && in_array("cash-on-delivery", $t->requirements)) {
                $payment = 'Cash Payment';
            } else {
                $payment = 'Credit Term';
            }

            return [
                'id' => $t->id,
                'date' => Carbon::parse($t->created_at)->format('D M d, Y'),
                'time' => Carbon::parse($t->created_at)->format('h:m A'),
                'name' => $t->name,
                'initial' => $ini,
                'phone' => $t->phone,
                'fee'  => $t->towing_fee == 0  ? Task::find($t->parent_task_id)?->towing_fee : $t->towing_fee,
                'vehicle_type' => $t->vehicle_type,
                'timeout' => !is_null($t) ? env('ACTIVE_TASK_TIMEOUT') : null,
                'status' => $t->status,
                'distance' => (!is_null($t)) ? $t->distance() : 'NA',
                'payment' => $payment,
                'paynow_task' => $t->merchant?->name == 'PAYNOW' ? true : false,
                'priority' => ucfirst($t->priority),
                'type' => ucfirst($t->type),
                'pickup' => $pickup,
                'pid' => $t->parent_task_id,
                'drop' => $drop,
                'is_double' => $is_double,
                'subtask' => $parent ? true : false,
            ];
        });
        return response()->json(['tasks' => $tasks]);
    }

    public function taskDetail(Request $request, $id)
    {
        $task_detail = Task::with('merchant', 'merchant.storeDetail')->find($id);
        if (!is_null($task_detail)) {
            $task_detail->distance = $task_detail->distance();
            $task_detail->timeout = env('ACTIVE_TASK_TIMEOUT');

            if (!is_null($task_detail->parent_task_id)) {
                $address = $task_detail->address;
                //$merchant_address = $task_detail->merchant?->storeDetail?->address;
                $merchant_address = $task_detail->destination_address ?? 'NA';

                $task_detail->address = $merchant_address;
                if (!is_null($task_detail->destination_address))
                    $task_detail->destination_address = $address;

                // if (!is_null($task_detail->merchant?->storeDetail?->address))
                //     $task_detail->merchant->storeDetail->address = $address;

                $parent = Task::find($task_detail->parent_task_id);
                $task_detail->towing_fee = $parent->towing_fee;
            }

            if ($task_detail->type == 'Battery/Tyre') {
                $task_detail->pickup = $task_detail->merchant?->storeDetail?->address ?? 'NA';
                $task_detail->destination_address = $task_detail?->address ?? 'NA';
            }
        }

        return response()->json(['task_detail' => $task_detail]);
    }

    public function activeTask(Request $request, $id)
    {
        $active_task = Task::with('merchant', 'merchant.storeDetail')->find($id);

        if (!is_null($active_task)) {
            $active_task->distance = $active_task->distance();
            $active_task->timeout = env('ACTIVE_TASK_TIMEOUT');

            if (!is_null($active_task->parent_task_id)) {

                $address = $active_task->address;
                $merchant_address = $active_task->merchant?->storeDetail?->address;
                $active_task->address = $merchant_address;
                if (!is_null($active_task->merchant?->storeDetail?->address))
                    $active_task->merchant->storeDetail->address = $address;
            }
        }

        return response()->json(['active' => $active_task]);
    }
    public function driverLocation(Request $request)
    {
        $driver = $request->user();
        if (isset($request->latitude)) {
            $driver->latitude = $request->latitude;
        }
        if (isset($request->longitude)) {
            $driver->longitude = $request->longitude;
        }
        if (isset($request->status)) {
            $driver->is_online = $request->status;
        }
        $driver->save();
        return response()->json(['success' => 'Location updated']);
    }

    public function goOffline(Request $request)
    {
        $driver = $request->user();
        $driver->latitude = null;
        $driver->longitude = null;
        $driver->is_online = '0';
        $driver->save();
        return response()->json(['success' => 'Offline successfull']);
    }

    public function driverTask(Request $request)
    {
        $task =  Task::find($request->task_id);

        if ($request->status == 'failed') {
            Task::whereId($task->parent_task_id)->update(['status' => 'failed']);
        }

        $task->status = $request->status;
        $task->save();

        DriverTask::updateOrCreate(
            [
                'task_id' => $request->task_id,
                'user_id' => $request->user()->id,
            ],
            [
                'task_id' => $request->task_id,
                'user_id' => $request->user()->id,
                'status'  => $request->status,
                'decline_reason' => $request->decline_reason ?? null
            ]
        );
        $drivername = $request->user()->firstname . ' ' . $request->user()->lastname;

        $admins = Administrator::whereStatus('1')->whereNotNull('app_push_token')->get('app_push_token');
        if (count($admins) > 0) {
            foreach ($admins as $admin) {
                $this->appNotify($admin->app_push_token, 'Task ' . ucfirst($request->status), 'Actioned by driver ' . $drivername);
            }
        }

        return response()->json(['success' => 'Task updated']);
    }

    public function getDriverTask(Request $request)
    {
        $task = DriverTask::where('user_id', $request->user()->id)
            ->where(function ($query) {
                $query->where('status', '!=', 'failed')
                    ->Where('status', '!=', 'completed');
            })
            ->latest()
            ->first();
        if (!is_null($task)) {
            $task->timeout = env('ACTIVE_TASK_TIMEOUT');
        }
        return response()->json(['task' => $task]);
    }

    public function arriveDistance(Request $request)
    {
        $task = Task::find($request->task_id);

        $lat1 = $request->latitude;
        $lon1 = $request->longitude;
        $lat2 = $task->latitude;
        $lon2 = $task->longitude;

        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return response()->json(['distance' => 0]);
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $distance = round(($miles * 1.609344), 1);

            return response()->json(['distance' => $distance]);
        }
    }

    public function dropDistance(Request $request)
    {

        $task = Task::with('merchant', 'merchant.storeDetail')->find($request->task_id);

        $lat1 = $request->latitude;
        $lon1 = $request->longitude;
        $lat2 = $task->merchant?->storeDetail?->latitude;
        $lon2 = $task->merchant?->storeDetail?->longitude;

        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return response()->json(['distance' => 0]);
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $distance = round(($miles * 1.609344), 1);

            return response()->json(['distance' => $distance]);
        }
    }


    protected function deleteExistingFile($name, $type, $task_id)
    {
        $disk = Storage::disk('public');
        
        if ($type == 'pickup' || $type == 'complete') {
            $directory = "uploads/task-photos/{$task_id}";
        } elseif ($type == 'doc') {
            $directory = "uploads/driver-docs/{$task_id}";
        } else {
            return false;
        }

        if (!$disk->exists($directory)) {
            return false;
        }

        $files = $disk->files($directory);

        foreach ($files as $file) {
            if (str_contains($file, $name)) {
                $disk->delete($file);
                return true;
            }
        }

        return false;
    }

    public function uploadDocCamera(Request $request, $task_id, $type, $name)
    {
        ini_set('upload_max_filesize', '500M');  
        ini_set('post_max_size', '550M');        
        ini_set('memory_limit', '512M');       
        set_time_limit(600); 

        $base64 = $request->input($name);
        if (!$base64) {
            return response()->json(['status_code' => 400, 'message' => 'No file uploaded']);
        }
        try {
            $fileData = base64_decode($base64);
            if ($fileData === false) {
                throw new \Exception('Base64 decode failed');
            }
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Invalid base64 data'
            ]);
        }
    
         
        $fileData = base64_decode($base64);
        $fileName = ($type == 'complete' ? $type.'_'.Str::uuid() : $name) . '.jpg';
       // $this->deleteExistingFile($name,$type,$task_id);

        if ($type == "pickup" || $type == 'complete') {
            TaskPhoto::updateOrcreate(
                [
                    'task_id'  => $task_id,
                    'type'  => $type,
                    'photo' => $fileName
                ],
                [
                    'task_id'  => $task_id,
                    'type' => $type,
                    'photo' => $fileName
                ]
            );

            $path = "uploads/task-photos/{$task_id}/{$fileName}";
            Storage::disk('public')->makeDirectory("uploads/task-photos/{$task_id}");
            Storage::disk('public')->put($path, $fileData);

            return response()->json([
                'status_code' => 200,
                'name' => $fileName,
                'uri' => url('storage/'.$path),
                'message' => 'Camera upload task photo successful'
            ]);
        }

        if ($type == 'doc') {

            DriverDoc::updateOrcreate(
                [
                    'driver_id'  => $task_id,
                    'document' => $name
                ],
                [
                    'driver_id'  => $task_id,
                    'document' => $name,
                    'file' => $fileName
                ]
            );

            $path = "uploads/driver-docs/{$task_id}/{$fileName}";
            Storage::disk('public')->makeDirectory("uploads/driver-docs/{$task_id}");
            Storage::disk('public')->put($path, $fileData);


            return response()->json([
                'status_code' => 200,
                'message'     => 'Uploaded doc successfuly',
            ]);
        }
    }

    public function uploadDoc(Request $request, $task_id, $type, $name)
    {
        ini_set('post_max_size', '25M');
        ini_set('upload_max_filesize', '20M');
        ini_set('memory_limit', '128M');
        set_time_limit(300);

      //  $this->deleteExistingFile($name,$type,$task_id);
        if ($type == "pickup" || $type == 'complete') {
            
           
            $image       = $type == 'pickup' ? $request->file($name)  : $request->file('photo.0');
            $fname       = ($type == 'pickup' ? $name : $type.'_'.Str::uuid()) . "." . $image->getClientOriginalExtension();
            $image->storeAs('uploads/task-photos/' . $task_id . '/', $fname, 'public');

            TaskPhoto::updateOrcreate(
                [
                    'task_id'  => $task_id,
                    'type'  => $type,
                    'photo' => $fname
                ],
                [
                    'task_id'  => $task_id,
                    'type' => $type,
                    'photo' => $fname
                ]
            );

            return response()->json([
                'status_code' => 200,
                'message'     => 'Uploaded successfuly'
            ]);
        }

        if ($type == 'doc') {


            $image       = $request->file($name);
            $ext         = $image->getClientOriginalExtension();
            $fname       = $name . "." . $image->getClientOriginalExtension();

            $image->storeAs('uploads/driver-docs/' . $task_id . '/', $fname, 'public');

            DriverDoc::updateOrcreate(
                [
                    'driver_id'  => $task_id,
                    'document' => $name
                ],
                [
                    'driver_id'  => $task_id,
                    'document' => $name,
                    'file' => $fname
                ]
            );

            return response()->json([
                'status_code' => 200,
                'message'     => 'Uploaded doc successfuly',
            ]);
        }
    }

    public function pickupEpod($task_id)
    {

        $epod = TaskPhoto::whereTaskId($task_id)->get();
        $epod = $epod->map(function ($e) use ($task_id) {
            return [
                'name' => !is_null($e->photo) ? explode('.', $e->photo)[0] : null,
                'uri'  => asset('storage/uploads/task-photos' . '/' . $task_id . '/' . $e->photo)
            ];
        });

        return response()->json(['epod' => $epod]);
    }

    public function completeTask(Request $request, $task_id)
    {
        $task =  Task::find($task_id);
        $back = false;
        $ntask = null;
        $merchant = $task->merchant;

        if (!is_null($task->parent_task_id)) {
            Task::find($task->parent_task_id)->update(['status' => 'in-transist']);
            DriverTask::updateOrCreate(
                [
                    'task_id' => $task->parent_task_id,
                    'user_id' => $request->user()->id,
                ],
                [
                    'task_id' => $task->parent_task_id,
                    'user_id' => $request->user()->id,
                    'status'  => 'in-transist',
                    'decline_reason' => $request->decline_reason ?? null
                ]
            );
            $back = true;
            $ntask = $task->parent_task_id;
        }
        Task::find($task_id)->update([
            'signature' => $request->signature,
            'status' => 'completed',
            'completion_time' => Carbon::now(),
        ]);
        $filename       = 'Delivery Order-' . Carbon::now()->format("Y-m-d") . '.pdf';

        try {

            $data["email"] = $merchant->email;
            $data["title"] = "Delivery Order-" . Carbon::now()->format("Y-m-d") . "-(" .  $merchant->name . ")";
            $clientName = $merchant->name;
            $company                    = CompanySetting::first();
            $data['task']               = $task;
            $data['photos']             = $task->photos;
            $data['merchant']           = $merchant;
            $data['company']            = $company;
            $data['delivery_id']        = "F0000" . $task->id;
            $data['delivery_date']      = Carbon::now()->format("Y-m-d");
            $data['due_date']           = Carbon::parse(Carbon::now()->format("Y-m-d"))->subDay(1)->format('d M Y');


            //return view("administrator.delivery-orders.pdf", compact('tasks', 'merchant', 'company'));
            $pdf = FacadePdf::loadView('administrator.delivery-orders.pdf', $data);


            // $merchant->notify(new SendDONotification($task, $pdf->output(), $merchant));
        } catch (HttpException $ex) {
            return $ex;
        }
        DriverTask::whereTaskId($task_id)->update([
            'status' => 'completed'
        ]);
        return response()->json([
            'success' => 'Task completed successfully!',
            'tid'    => $task_id,
            'ntask'  => $ntask,
            'back'   => $back
        ]);
    }

    public function activity(Request $request, $type)
    {
        $uid = $request->user()->id;

        $earnings = 0;
        $job_completed = Task::select('towing_fee', 'completion_time')->where([
            'driver_id' => $uid,
            'status'  => 'completed'
        ]);
        $job_cancelled = DriverTask::select('status', 'created_at')->where([
            'user_id' => $uid,
            'status'  => 'rejected'
        ]);

        switch ($type) {

            case 'month':
                $job_completed = $job_completed->whereBetween('completion_time', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth(),
                ])->get();
                $job_cancelled = $job_cancelled->whereBetween('created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth(),
                ])->get();
                break;

            case 'week':

                $job_completed = $job_completed->whereBetween('completion_time', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek(),
                ])->get();
                $job_cancelled = $job_cancelled->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek(),
                ])->get();
                break;

            case 'today':
                $job_completed = $job_completed->whereDate('completion_time', Carbon::today())->get();
                $job_cancelled = $job_cancelled->whereDate('created_at', Carbon::today())->get();
                break;
            default:
                $job_completed = $job_completed->get();
                $job_cancelled = $job_cancelled->get();
        }

        if (count($job_completed)) {
            foreach ($job_completed as $job) {
                $earnings += $job->towing_fee;
            }
        }

        return response()->json([
            'job_completed' => count($job_completed),
            'earnings'      => $earnings,
            'rejected'      => count($job_cancelled)
        ]);
    }

    public function help(Request $request)
    {
        ContactUs::create([
            'user_id' => $request->user()->id,
            'user' => 'driver',
            'source' => 'driver-app',
            'name' => $request->user()->firstname . ' ' . $request->user()->lastname,
            'email' => $request->user()->email,
            'phone' => $request->user()->phone,
            'message' => $request->message
        ]);
        return response()->json(['success' => 'Query added successfully!']);
    }

    public function driverDocs(Request $request)
    {
        $docs = DriverDoc::select('document', 'status')->whereDriverId($request->user()?->id)->get();
        $result = [];
        if (count($docs) > 0) {
            foreach ($docs as $doc) {
                $result[] = [
                    'doc' => $doc->document,
                    'status' => $doc->status
                ];
            }
        }
        return response()->json(['docs' => $result]);
    }

    public function postNote(Request $request)
    {
        Task::find($request->id)->update([
            'driver_notes' => $request->note
        ]);
        return response()->json(['success' => 'Note added succesfully']);
    }

    public function appNotify($token, $title, $msg)
    {
        $response = Http::post('https://exp.host/--/api/v2/push/send', [
            'to' => $token,
            'title' => $title,
            'body' => $msg,
        ]);
    }

    public function calculateFee($id)
    {
        $task = Task::find($id);

        $range = env('NIGHT_FARE_TIME');

        if (is_null($range) || !isset($range) || is_null($task->service_id)) {
            return response()->json(['price' => $task->towing_fee]);
        }

        $service = Service::find($task->service_id);
        $exTime = explode('-', $range);

        $startHour = $exTime[0];
        $endHour = $exTime[1];

        $currentTime = Carbon::now();

        $start = $startHour >= 12
            ? Carbon::createFromTime($startHour, 0, 0)
            : Carbon::createFromTime($startHour, 0, 0)->addHours(12);

        $end = Carbon::createFromTime($endHour, 0, 0)->addDay();

        $price = $task->towing_fee ?? $service->price;
        $night_price = ($service->extra_night_price + $price);

        if ($currentTime->between($start, $end)) {
            return response()->json(['price' => number_format($night_price, 2)]);
        } else {
            return response()->json(['price' => number_format($price, 2)]);
        }
    }
}

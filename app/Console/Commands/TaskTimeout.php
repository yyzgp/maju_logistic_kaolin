<?php

namespace App\Console\Commands;

use App\Models\Administrator;
use App\Models\DriverTask;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TaskTimeout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:task-timeout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $activeTimeOut = env('ACTIVE_TASK_TIMEOUT');
        $transistTimeOut = env('TRANSIST_TASK_TIMEOUT');


        if ($activeTimeOut && is_numeric($activeTimeOut) && $activeTimeOut > 0) {
            $activeTasks = Task::whereStatus('active')->get();
            if (count($activeTasks) > 0) {
                foreach ($activeTasks as $active_task) {

                    $start = Carbon::parse($active_task->updated_at)->subMinutes($activeTimeOut);
                    $end = Carbon::now()->subMinutes($activeTimeOut);
                    $minutesDifference = $start->diffInMinutes($end);

                    if ($minutesDifference > $activeTimeOut) {

                        $active_task->status = 'failed';
                        $active_task->save();
                        DriverTask::whereTaskId($active_task->id)->update(['status' => 'failed']);

                        $driver = User::find($active_task->driver_id)->first();
                        $drivername = ($driver?->firstname . ' ' . $driver->lastname) ?? 'NA';

                        $admins = Administrator::whereStatus('1')->whereNotNull('app_push_token')->get('app_push_token');
                        if (count($admins) > 0) {
                            foreach ($admins as $admin) {
                                $this->appNotify($admin->app_push_token, 'Task failed because of timeout', 'Asigned driver ' . $drivername);
                            }
                        }
                    }
                }
            }
        }

        if ($transistTimeOut && is_numeric($transistTimeOut) && $transistTimeOut > 0) {
            $transistTasks = Task::select('id', 'driver_id','updated_at', 'status', 'created_at')->whereStatus('in-transist')->get();

            if (count($transistTasks) > 0) {
                foreach ($transistTasks as $transist_task) {
                    
                    $start = Carbon::parse($transist_task->updated_at)->subMinutes($transistTimeOut);
                    $end = Carbon::now()->subMinutes($transistTimeOut);
                    $minutesDifference = $start->diffInMinutes($end);

                    if ($minutesDifference > $transistTimeOut) {

                        $transist_task->status = 'failed';
                        $transist_task->save();
                        DriverTask::whereTaskId($transist_task->id)->update(['status' => 'failed']);


                        $driver = User::find($transist_task->driver_id)->first();
                        $drivername = ($driver?->firstname . ' ' . $driver->lastname) ?? 'NA';

                        $admins = Administrator::whereStatus('1')->whereNotNull('app_push_token')->get('app_push_token');
                        if (count($admins) > 0) {
                            foreach ($admins as $admin) {
                                $this->appNotify($admin->app_push_token, 'Task failed because of inactivity', 'Asigned driver ' . $drivername);
                            }
                        }
                    }
                }
            }
        }
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

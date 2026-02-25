<?php

namespace App\Console\Commands;

use App\Models\CompanySetting;
use App\Models\DeliveryOrder;
use App\Models\Merchant;
use App\Models\Task;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Http\Client\Exception\HttpException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-do';

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
        $merchants          = Merchant::get(['id']);
        foreach ($merchants as $key => $merchant) {
            $tasks          = Task::where('merchant_id', $merchant->id)->whereDate('created_at', Carbon::now()->format("Y-m-d"))->where('status', 'completed')->where('do_sent', 0)->get();
            $filename       = 'Delivery Order-' . Carbon::now()->format("Y-m-d") . '.pdf';
            $delivery_date =  DeliveryOrder::updateORCreate([
                'merchant_id' => $merchant->id,
            ], [
                'date' => Carbon::now()->format("Y-m-d")
            ]);
            $delivery_id = DeliveryOrder::find($delivery_date->id)->id;
            try {

                $data["email"] = $merchant->email;
                $data["title"] = "Delivery Order-" . Carbon::now()->format("Y-m-d") . "-(" .  $merchant->name . ")";
                $clientName = $merchant->name;
                $company                    = CompanySetting::first();
                $data['tasks']              = $tasks;
                $data['merchant']           = $merchant;
                $data['company']            = $company;
                $data['delivery_id']        = "F0000" . $delivery_id;
                $data['delivery_date']      = Carbon::now()->format("Y-m-d");
                $data['due_date']           = Carbon::parse(Carbon::now()->format("Y-m-d"))->subDay(1)->format('d M Y');


                //return view("administrator.delivery-orders.pdf", compact('tasks', 'merchant', 'company'));
                $pdf = Pdf::loadView('administrator.delivery-orders.pdf', $data);
                $results = Mail::send('delivery-orders.mail', ['name' => $clientName], function ($message) use ($data, $pdf, $filename) {
                    $message->from('kaolincar@gmail.com', 'Logisticss Pvt Ltd')
                        ->to($data["email"])
                        ->subject($data["title"])
                        ->attachData($pdf->output(), $filename);
                });
            } catch (HttpException $ex) {
                return $ex;
            }
        }
        foreach ($tasks as $task) {
            $task->do_sent = 1;
            $task->save();
        }
    }
}

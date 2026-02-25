<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Merchant;
use App\Models\Task;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merchants = Merchant::get();


        foreach ($merchants as $merchant) {
            $november_4th_week_tasks = Task::where("merchant_id", $merchant->id)
                ->where('status', 'completed')
                ->whereBetween('created_at', [Carbon::parse('2024-11-24')->format("Y-m-d"), Carbon::parse('2024-11-30')
                    ->format("Y-m-d")])->get();
            if (count($november_4th_week_tasks) > 0) {
                $invoice            =  Invoice::create([
                    'merchant_id'  => $merchant->id,
                    'invoice_no'   => "INV-2024-11-04-0".$merchant->id,
                    'invoice_from' => Carbon::parse('2024-11-24')->format("Y-m-d"),
                    'invoice_upto' => Carbon::parse('2024-11-30')->format("Y-m-d"),
                    'amount'       => $november_4th_week_tasks->sum('towing_fee'),
                    'status'       => "generated"
                ]);
                Task::where("merchant_id", $merchant->id)->where('status', 'completed')->whereBetween('created_at', [Carbon::parse('2024-11-24')->format("Y-m-d"), Carbon::parse('2024-11-30')->format("Y-m-d")])->update([
                    'invoice_generated' => true,
                    'invoice_no'        => "INV-2024-11-04-0" . $merchant->id
                ]);

                foreach ($november_4th_week_tasks as $november_4th_week_task) {
                    InvoiceItem::create([
                        "invoice_id" => $invoice->id,
                        "task_id"    => $november_4th_week_task->id
                    ]);
                }
            }


            // $december_1st_week_tasks = Task::where("merchant_id", $merchant->id)
            //     ->where('status', 'completed')
            //     ->whereBetween('created_at', [Carbon::parse('2024-12-01')->format("Y-m-d"), Carbon::parse('2024-12-07')
            //         ->format("Y-m-d")])->get();
            // if (count($december_1st_week_tasks) > 0) {
            //     $invoice            =  Invoice::create([
            //         'merchant_id'  => $merchant->id,
            //         'invoice_no'   => "INV-2024-12-04-01" . $merchant->id,
            //         'invoice_from' => Carbon::parse('2024-12-01')->format("Y-m-d"),
            //         'invoice_upto' => Carbon::parse('2024-12-07')->format("Y-m-d"),
            //         'amount'       => $december_1st_week_tasks->sum('towing_fee'),
            //         'status'       => "generated"
            //     ]);
            //     Task::where("merchant_id", $merchant->id)->where('status', 'completed')->whereBetween('created_at', [Carbon::parse('2024-12-01')->format("Y-m-d"), Carbon::parse('2024-12-07')->format("Y-m-d")])->update([
            //         'invoice_generated' => true,
            //         'invoice_no'        => "INV-2024-12-01-0" . $merchant->id
            //     ]);

            //     foreach ($december_1st_week_tasks as $december_1st_week_task) {
            //         InvoiceItem::create([
            //             "invoice_id" => $invoice->id,
            //             "task_id"    => $december_1st_week_task->id
            //         ]);
            //     }
            // }

            // $december_2nd_week_tasks = Task::where("merchant_id", $merchant->id)
            //     ->where('status', 'completed')
            //     ->whereBetween('created_at', [Carbon::parse('2024-12-08')->format("Y-m-d"), Carbon::parse('2024-12-14')
            //         ->format("Y-m-d")])->get();
            // if (count($december_2nd_week_tasks) > 0) {
            //     $invoice            =  Invoice::create([
            //         'merchant_id'  => $merchant->id,
            //         'invoice_no'   => "INV-2024-12-02-" . $merchant->id,
            //         'invoice_from' => Carbon::parse('2024-12-08')->format("Y-m-d"),
            //         'invoice_upto' => Carbon::parse('2024-12-14')->format("Y-m-d"),
            //         'amount'       => $december_2nd_week_tasks->sum('towing_fee'),
            //         'status'       => "generated"
            //     ]);
            //     Task::where("merchant_id", $merchant->id)->where('status', 'completed')->whereBetween('created_at', [Carbon::parse('2024-12-08')->format("Y-m-d"), Carbon::parse('2024-12-14')->format("Y-m-d")])->update([
            //         'invoice_generated' => true,
            //         'invoice_no'        => "INV-2024-12-02-" . $merchant->id
            //     ]);

            //     foreach ($december_2nd_week_tasks as $december_2nd_week_task) {
            //         InvoiceItem::create([
            //             "invoice_id" => $invoice->id,
            //             "task_id"    => $december_2nd_week_task->id
            //         ]);
            //     }
            // }
        }
    }
}

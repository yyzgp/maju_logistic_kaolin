<?php

namespace App\Console\Commands;

use App\Models\GeneralSetting;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Merchant;
use App\Models\Task;
use Carbon\Carbon;
use Dcblogdev\Xero\Facades\Xero;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate invoice for a cycle';

    /**
     * Execute the console command.
     */
    public function handle()
    {


        $merchants      = Merchant::whereNot('id', 30)->get();

        foreach ($merchants as $merchant) {
            $cycle          = $merchant->invoice_frequency;

            switch ($cycle) {
                case 'daily':
                    $invoice_from = Carbon::now()->format('Y-m-d 00:00:00');
                    $invoice_upto = Carbon::now()->format("Y-m-d 23:59:00");
                    $tasks        = Task::where("merchant_id", $merchant->id)->where('status', 'completed')->where("invoice_generated", false)->whereBetween('completion_time', [$invoice_from,  $invoice_upto])->get();
                    dd($tasks);
                    break;
                case 'weekly':
                    $invoice_from = Carbon::now()->startOfWeek()->format('Y-m-d 00:00:00');
                    $invoice_upto = Carbon::now()->endOfWeek()->format('Y-m-d 23:59:00');
                    $tasks        = Task::where("merchant_id", $merchant->id)->where('status', 'completed')->where("invoice_generated", false)->whereBetween('completion_time', [$invoice_from,  $invoice_upto])->get();

                    break;
                case 'monthly':
                    $invoice_from = Carbon::now()->startOfMonth()->format('Y-m-d 00:00:00');
                    $invoice_upto = Carbon::now()->endOfMonth()->format('Y-m-d 23:59:00');
                    $tasks        = Task::where("merchant_id", $merchant->id)->where('status', 'completed')->where("invoice_generated", false)->whereBetween('completion_time', [$invoice_from,  $invoice_upto])->get();
                    break;
                case 'quarterly':
                    $invoice_from = Carbon::now()->startOfQuarter()->format('Y-m-d 00:00:00');
                    $invoice_upto = Carbon::now()->endOfQuarter()->format('Y-m-d 23:59:00');
                    $tasks        = Task::where("merchant_id", $merchant->id)->where('status', 'completed')->where("invoice_generated", false)->whereBetween('completion_time', [$invoice_from,  $invoice_upto])->get();
                    break;
                case 'annually':
                    $invoice_from = Carbon::now()->startOfYear()->format('Y-m-d 00:00:00');
                    $invoice_upto = Carbon::now()->endOfYear()->format('Y-m-d 23:59:00');
                    $tasks        = Task::where("merchant_id", $merchant->id)->where('status', 'completed')->where("invoice_generated", false)->whereBetween('completion_time', [$invoice_from,  $invoice_upto])->get();
                    break;
                default:
                    $invoice_from = Carbon::now()->startOfWeek()->format('Y-m-d 00:00:00');
                    $invoice_upto = Carbon::now()->endOfWeek()->format('Y-m-d 23:59:00');
                    $tasks        = Task::where("merchant_id", $merchant->id)->where('status', 'completed')->where("invoice_generated", false)->whereBetween('completion_time', [$invoice_from,  $invoice_upto])->get();
                    break;
            }
            // dd($tasks);
            if (count($tasks) > 0) {
                $invoice           =  Invoice::create([
                    'merchant_id'  => $merchant->id,
                    'invoice_no'   => "INV-" . Carbon::now()->startOfWeek()->format('Y-m-d') . "-0" . $merchant->id,
                    'invoice_from' => $invoice_from,
                    'invoice_upto' => $invoice_upto,
                    'amount'       => $tasks->sum('towing_fee'),
                    'status'       => "generated"
                ]);

                Task::where("merchant_id", $merchant->id)->where('status', 'completed')->whereBetween('completion_time', [$invoice_from, $invoice_upto])->update([
                    'invoice_generated' => true,
                    'invoice_no'        => "INV-" . Carbon::now()->startOfWeek()->format('Y-m-d') . "-0" . $merchant->id
                ]);


                // Xero::invoices()->store($data);


                foreach ($tasks as $task) {
                    InvoiceItem::create([
                        "invoice_id" => $invoice->id,
                        "task_id"    => $task->id
                    ]);
                }

                try {
                    $line_items    = [];
                    $saved_invoice = Invoice::find($invoice->id);
                    foreach ($saved_invoice->items as $key => $item) {
                        $line_items[$key]['description'] = nl2br($saved_invoice->invoice_no . "<br>" . $item->task->created_at->format('d/m/Y') . "<br>" . $item->task->registration_number . "<br>" . $item->task->address . "<br>" . $item->task->location . "<br>" . $item->task->service?->name . "<br>" . $item->task->ticket_no . "<br>" . $item->task->notes . "<br>" . $item->task->remarks);
                        $line_items[$key]['quantity'] = 1;
                        $line_items[$key]['unit_amount'] = $item->task->towing_fee;
                    }
                    $taxRate = 9; // 9% tax
                    $totalTax = $saved_invoice->amount * ($taxRate / 100);
                    // Prepare invoice data
                    $invoiceData = [
                        'Type' => 'ACCREC', // Accounts Receivable (customer invoice)
                        'Contact' => [
                            'ContactID' => $merchant->xeroCredentials->contact_id
                        ],
                        'Date' => $invoice->created_at->toDateString(),
                        'DueDate' => Carbon::parse($invoice->created_at)->addMonth(1)->toDateString(),
                        'LineItems' => array_map(function ($lineItem) {

                            return [
                                'Description' => $lineItem['description'],
                                'Quantity' => $lineItem['quantity'],
                                'UnitAmount' => $lineItem['unit_amount'],
                                'AccountCode' => "200",
                                'TaxType' => "OUTPUTY24"
                            ];
                        }, $line_items),
                        'AccountID' => "821daf63-3909-4250-97e4-04a858f9768b", // Replace with a valid account code from Xero
                        'TaxType' => "OUTPUTY24",
                        'TotalTax' => $totalTax,
                        'Reference' => $saved_invoice->invoice_no ?? '',
                        'Status' => 'AUTHORISED', // Set the status to AUTHORIZED
                    ];
                    Log::info($invoiceData);
                    // Create invoice in Xero
                    $response = Xero::invoices()->store($invoiceData);

                    $saved_invoice->update(['xero_invoice_id' => $response['InvoiceID']]);

                    Log::info($response);
                } catch (\Exception $e) {
                    Log::info(response()->json([
                        'message' => 'Failed to create invoice',
                        'error' => $e->getMessage(),
                    ], 500));
                }
            }
        }


        $this->info(ucfirst($cycle) . " invoices generated successfully!");
    }
}

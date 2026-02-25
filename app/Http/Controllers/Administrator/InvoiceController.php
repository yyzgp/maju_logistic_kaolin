<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use App\Models\GeneralSetting;
use App\Models\Invoice;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Sabberworm\CSS\Settings;

class InvoiceController extends Controller
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
        $filter                         = [];
        $filter['invoice_no']           = $request->invoice_no;
        $filter['merchant']             = $request->merchant;
        $filter['invoice_from']         = $request->invoice_from;
        $filter['invoice_upto']         = $request->invoice_upto;
        $filter['created_at']           = $request->created_at;

        $invoices                       = Invoice::query();
        $invoices                       = isset($filter['invoice_no']) ? $invoices->where("invoice_no", 'LIKE', '%' . $filter['invoice_no'] . '%') : $invoices;
        $invoices                       = isset($filter['merchant']) ? $invoices->where('merchant_id', $filter['merchant']) : $invoices;
        $invoices                       = isset($filter['invoice_from']) ? $invoices->whereDate('invoice_from', '>=', $filter['invoice_from']) : $invoices;
        $invoices                       = isset($filter['invoice_upto']) ? $invoices->whereDate('invoice_upto', '<=', $filter['invoice_upto']) : $invoices;
        $invoices                       = isset($filter['created_at']) ? $invoices->whereDate('created_at', $filter['created_at']) : $invoices;
        $invoices                       = $invoices->orderBy('id', 'desc')->paginate(10);
        $merchants                      = Merchant::all();
        return view('administrator.invoices.list', compact('invoices', 'filter', 'merchants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::find($id);

        return view("administrator.invoices.show", compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoice = Invoice::find($id);
        $company = CompanySetting::first();
        $data['invoice'] = $invoice;
        $data['company'] = $company;
        //return view('administrator.invoices.pdf', compact("invoice", "company"));
        $pdf = Pdf::loadView('administrator.invoices.pdf', $data);
        return $pdf->download($invoice->invoice_no.'.pdf');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Invoice::find($id)->delete();
        return redirect()->back()->with('success', 'Invoice deleted sucessfully!');
    }

    public function bulkDelete(Request $request)
    {
        Invoice::whereIn('id', $request->invoices)->delete();
        return response()->json(['success' => 'Invoices deleted successfully!'], 200);
    }

    public function settings(){
        $frequency = GeneralSetting::where("type", "invoice_frequency")->first()->value;
        return view("administrator.invoices.settings", compact('frequency'));
    }

    public function saveSettings(Request $request){
        $request->validate([
            "invoice_frequency" => ["required"]
        ]);
        $frequency = GeneralSetting::where("type", "invoice_frequency")->update(['value' => $request->invoice_frequency]);
        return redirect()->back()->with('success', 'Invoice settings updated sucessfully!');
    }
}

<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use App\Models\Merchant;
use App\Models\Country;
use App\Models\DeliveryOrder;
use App\Models\MerchantBillingDetail;
use App\Models\MerchantStoreDetail;
use App\Models\MerchantXeroCredential;
use App\Models\Service;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dcblogdev\Xero\Facades\Xero;
use Illuminate\Support\Facades\Log;

class MerchantController extends Controller
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

        $filter                 = [];
        $filter['name']         = $request->name;
        $filter['email']        = $request->email;
        $filter['phone']        = $request->phone;
        $filter['status']       = $request->status;

        $merchants                 = Merchant::query();
        $merchants                 = isset($filter['name']) ? $merchants->where("name", 'LIKE', '%' . $filter['name'] . '%') : $merchants;
        $merchants                 = isset($filter['email']) ? $merchants->where('email', 'LIKE', '%' . $filter['email'] . '%') : $merchants;
        $merchants                 = isset($filter['phone']) ? $merchants->where('phone', 'LIKE', '%' . $filter['phone'] . '%') : $merchants;
        $merchants                 = isset($filter['status']) ? $merchants->where('status', 'LIKE', '%' . $filter['status'] . '%') : $merchants;


        $merchants                 = $merchants->orderBy('id', 'desc')->paginate(10);

        return view('administrator.merchants.list', compact('merchants', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::get();
        return view('administrator.merchants.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:merchants'],
            'password'              => ['required', 'string', 'min:8'],
            'status'                => ['required'],
            'store_contact_name'    => ['required'],
            'store_contact_email'   => ['required'],
            'address'               => ['required'],
            'building_floor_room'   => ['required'],
            'invoice_frequency'     => ['required']
        ]);

        // Add to Database

        $merchant                      = new Merchant();
        $merchant->name                = $request->name;
        $merchant->email               = $request->email;
        $merchant->password            = Hash::make($request->password);
        $merchant->status              = $request->status;
        $merchant->invoice_frequency   = $request->invoice_frequency;
        $merchant->email_verified_at   = now();
        $merchant->save();


        if (!empty($request->services) && is_array($request->services)) {
            $all_services = Service::get();
            foreach ($all_services as $key => $service) {

                if (in_array($service->id, $request->services)) {
                    if (!in_array($merchant->id, $service->merchants)) {
                        $service->merchants = array_merge($service->merchants, [$merchant->id]);
                        $service->save();
                    }
                } else {
                    $merchants = $service->merchants;
                    $service->merchants = array_map('intval', array_diff($merchants, [$merchant->id]));
                    $service->save();
                }
            }
        }

        if ($request->hasfile('avatar')) {

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/merchants/' . $merchant->slug . '/', $name, 'public');

            Merchant::find($merchant->id)->update(['avatar' => $name]);
        }

        MerchantStoreDetail::create([
            'merchant_id'         => $merchant->id,
            'name'                => $request->store_contact_name,
            'email'               => $request->store_contact_email,
            'dialcode'            => $request->dialcode,
            'phone'               => $request->phone ? $request->phone : null,
            'address'             => $request->address,
            'building_floor_room' => $request->building_floor_room,
            'latitude'            => $request->latitude,
            'longitude'           => $request->longitude,
            'notes'               => $request->notes,
            'iso2'                => $request->iso2,
        ]);

        MerchantBillingDetail::create([
            'merchant_id'         => $merchant->id,
            'name'                => $request->billing_name,
            'email'               => $request->billing_email,
            'dialcode'            => $request->billing_dialcode,
            'phone'               => $request->billing_phone,
            'address'             => $request->billing_address,
            'latitude'            => $request->billing_latitude,
            'longitude'           => $request->billing_longitude,
            'iso2'                => $request->billing_iso2,
        ]);

        // Add Contact to Xero

        $saved_merchant = Merchant::find($merchant->id);

        // $data = [
        //     'Name' => $saved_merchant->name,
        //     'EmailAddress' =>  $saved_merchant->billingDetail->email,
        //     'FirstName' => $saved_merchant->billingDetail->name,
        //     'Addresses' => [
        //         [
        //             'AddressType' => 'POBOX',
        //             'AddressLine1' => $saved_merchant->billingDetail->address,
        //             'Country' => "Singapore",
        //         ],
        //     ],
        //     'Phones' => [
        //         [
        //             'PhoneType' => 'DEFAULT',
        //             'PhoneNumber' => $saved_merchant->billingDetail->dialcode . '' . $saved_merchant->billingDetail->phone,
        //         ],
        //     ],
        // ];

        // $response = Xero::contacts()->store($data);

        // Log::info($response);

        // Save Xero Contact

        // MerchantXeroCredential::updateOrCreate([
        //     "merchant_id" => $merchant->id
        // ], [
        //     "contact_id"  => $response['ContactID'],
        //     "contact_number" => $merchant->id
        // ]);

        return redirect()->route('administrator.merchants.index')->with('success', 'Merchant created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $merchant          = Merchant::find($id);
        $services          = Service::whereJsonContains("merchants", [(int)$id])->get();
        $merchant->avatar  = isset($merchant->avatar) ? asset('storage/uploads/merchants/' . $merchant->slug . '/' . $merchant->avatar) : "https://placehold.co/150x150/D82D36/FFF?text=" . $merchant->name[0] . '' . $merchant->name[1];
        return view('administrator.merchants.show', compact('merchant', 'services'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $merchant          = Merchant::find($id);
        $services          = Service::get();
        $merchant->avatar  = isset($merchant->avatar) ? asset('storage/uploads/merchants/' . $merchant->slug . '/' . $merchant->avatar) : "https://placehold.co/150x150/D82D36/FFF?text=" . $merchant->name[0] . '' . $merchant->name[1];
        return view('administrator.merchants.edit', compact('merchant', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:merchants,email,' . $id],
            'status'                => ['required'],
            'store_contact_name'    => ['required'],
            'store_contact_email'   => ['required'],
            'address'               => ['required'],
            'building_floor_room'   => ['required'],
            'invoice_frequency'     => ['required']
        ]);

        $merchant                      = Merchant::find($id);
        $merchant->name                = $request->name;
        $merchant->email               = $request->email;
        if ($request->password) {
            $merchant->password        = Hash::make($request->password);
        }
        $merchant->status              = $request->status;
        $merchant->invoice_frequency   = $request->invoice_frequency;
        $merchant->email_verified_at   = now();
        $merchant->save();

        if (!empty($request->services) && is_array($request->services)) {
            $all_services = Service::get();
            foreach ($all_services as $key => $service) {

                if (in_array($service->id, $request->services)) {
                    if (!in_array($id, $service->merchants)) {
                        $service->merchants = array_merge($service->merchants, [$id]);
                        $service->save();
                    }
                } else {
                    $merchants = $service->merchants;
                    $service->merchants = array_diff($merchants, [$id]);
                    $service->save();
                }
            }
        }

        if ($request->hasfile('avatar')) {

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/merchants/' . $merchant->slug . '/', $name, 'public');

            Merchant::find($id)->update(['avatar' => $name]);
        }

        MerchantStoreDetail::updateOrCreate([
            'merchant_id'         => $id,
        ], [
            'name'                => $request->store_contact_name,
            'email'               => $request->store_contact_email,
            'dialcode'            => $request->dialcode ? $request->dialcode : "sg",
            'phone'               => $request->phone ? $request->phone : null,
            'address'             => $request->address,
            'building_floor_room' => $request->building_floor_room,
            'latitude'            => $request->latitude,
            'longitude'           => $request->longitude,
            'notes'               => $request->notes,
            'iso2'                => $request->iso2,
        ]);

        MerchantBillingDetail::updateOrCreate([
            'merchant_id'         => $id,
        ], [
            'name'                => $request->billing_name,
            'email'               => $request->billing_email,
            'dialcode'            => $request->billing_dialcode,
            'phone'               => $request->billing_phone,
            'address'             => $request->billing_address,
            'latitude'            => $request->billing_latitude,
            'longitude'           => $request->billing_longitude,
            'iso2'                => $request->billing_iso2,
        ]);

        // try {
        //     $saved_merchant = Merchant::find($id);
        //     if($saved_merchant->has('xeroCredentials')){
        //         $contactId = $saved_merchant->xeroCredentials->contact_id;
        //         $existingContact = Xero::get("Contacts/$contactId");
        //         if($existingContact){
        //             $data = [
        //                 'ContactID' => $contactId, // Required to identify the contact to update
        //                 'Name' => $saved_merchant->name,
        //                 'EmailAddress' =>  $saved_merchant->billingDetail->email,
        //                 'FirstName' => $saved_merchant->billingDetail->name,
        //                 'Addresses' => [
        //                     [
        //                         'AddressType' => 'POBOX',
        //                         'AddressLine1' => $saved_merchant->billingDetail->address,
        //                         'Country' => "Singapore",
        //                     ],
        //                 ],
        //                 'Phones' => [
        //                     [
        //                         'PhoneType' => 'DEFAULT',
        //                         'PhoneNumber' => $saved_merchant->billingDetail->dialcode . '' . $saved_merchant->billingDetail->phone,
        //                     ],
        //                 ],
        //             ];
        //         }
        //     }else{
        //         $data = [
        //             'Name' => $saved_merchant->name,
        //             'EmailAddress' =>  $saved_merchant->billingDetail->email,
        //             'FirstName' => $saved_merchant->billingDetail->name,
        //             'Addresses' => [
        //                 [
        //                     'AddressType' => 'POBOX',
        //                     'AddressLine1' => $saved_merchant->billingDetail->address,
        //                     'Country' => "Singapore",
        //                 ],
        //             ],
        //             'Phones' => [
        //                 [
        //                     'PhoneType' => 'DEFAULT',
        //                     'PhoneNumber' => $saved_merchant->billingDetail->dialcode . '' . $saved_merchant->billingDetail->phone,
        //                 ],
        //             ],
        //         ];
        //     }

        //     // Update the contact in Xero
        //     $response = Xero::contacts()->store($data);

        //     MerchantXeroCredential::updateOrCreate([
        //         "merchant_id" => $id
        //     ], [
        //         "contact_id"  => $response['ContactID'],
        //         "contact_number" => $id
        //     ]);

        //     Log::info($response);

        //     return redirect()->route('administrator.merchants.index')->with('success', 'Merchant updated successfully!');
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 500);
        // }

        return redirect()->route('administrator.merchants.index')->with('success', 'Merchant updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Merchant::find($id)->delete();
        return redirect()->route('administrator.merchants.index')->with('success', 'Merchant deleted successfully!');
    }

    public function changeStatus(Request $request)
    {
        $merchant = Merchant::find($request->merchant_id);
        Merchant::find($request->merchant_id)->update(['status' => $request->status]);
        return response()->json(['success' => 'Merchant status has been changed successfully!'], 200);
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'min:6', 'confirmed']
        ]);
        Merchant::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
        return redirect()->route('administrator.merchants.index')->with('success', 'Merchant password has been reset successfully!');
    }

    public function bulkDelete(Request $request)
    {
        Merchant::whereIn('id', $request->merchants)->delete();
        return response()->json(['success' => 'Merchants deleted successfully!'], 200);
    }

    public function deliveryOrders(Request $request, $slug)
    {
        $merchant = Merchant::findBySlug($slug);
        $filter                 = [];
        $filter['name']         = $request->name;
        $filter['email']        = $request->email;
        $filter['phone']        = $request->phone;
        $filter['merchant']     = $request->merchant;
        $filter['driver']       = $request->driver;
        $filter['priority']     = $request->priority;
        $filter['driver']       = $request->driver;
        $filter['completion_date']   = $request->completion_date;
        $filter['month']        = $request->month;
        $tasks                  = Task::where('status', 'completed')->where('merchant_id', $merchant->id);
        $tasks                  = isset($filter['name']) ? $tasks->where("name", 'LIKE', '%' . $filter['name'] . '%') : $tasks;
        $tasks                  = isset($filter['email']) ? $tasks->where('email', 'LIKE', '%' . $filter['email'] . '%') : $tasks;
        $tasks                  = isset($filter['phone']) ? $tasks->where('phone', 'LIKE', '%' . $filter['phone'] . '%') : $tasks;
        $tasks                  = isset($filter['driver']) ? $tasks->where('driver_id', $filter['driver']) : $tasks;

        $tasks                  = isset($filter['merchant']) ? $tasks->where('merchant_id', $filter['merchant']) : $tasks;
        $tasks                  = isset($filter['priority']) ? $tasks->where('priority', $filter['priority']) : $tasks;
        $tasks                  = isset($filter['completion_date']) ? $tasks->whereDate('completion_time', $filter['completion_date']) : $tasks;
        $tasks                  = isset($filter['month']) ? $tasks->whereMonth('created_at', $filter['month']) : $tasks;
        if (isset($filter['driver'])) {
            if ($filter['driver'] == "unassigned") {
                $tasks                  = $tasks->whereNull("driver_id");
            }
            if ($filter['driver'] == "assigned") {
                $tasks                  = $tasks->whereNotNull("driver_id");
            }
        }
        $tasks                  = $tasks->orderBy('id', 'desc');

        if (isset($request->current_month)) {
            $tasks->whereMonth('created_at', Carbon::now()->format('m'));
        }
        $tasks = $tasks->paginate(10);

        $merchants              = Merchant::get(['id', 'name']);
        $drivers                = User::get(['id', 'firstname', 'lastname', 'avatar']);

        $all_drivers            = $drivers->map(function ($driver) {
            return [
                'id'                    => $driver->id,
                'firstname'             => $driver->firstname,
                'lastname'              => $driver->lastname,
                'avatar'                => isset($driver->avatar) ? asset('storage/uploads/drivers/' . $driver->slug . '/' . $driver->avatar) : "https://placehold.co/150x150/D82D36/FFF?text=" . $driver->firstname[0] . '' . (isset($driver->lastname) ? $driver->lastname[0]  : ''),
                'total_assigned_jobs'   => Task::where('driver_id', $driver->id)->whereIn('status', ['active', 'in-transist', 'arrived'])->count(),
                'total_completed_jobs'  => Task::where('driver_id', $driver->id)->where('status', 'completed')->count()
            ];
        });
        return view('administrator.delivery-orders.list', compact('tasks', 'filter', 'merchants', 'merchant', 'drivers', 'all_drivers'));
    }


    public function downloadOrder($id)
    {

        $task                       = Task::find($id);
        $merchant                   = Merchant::find($task->merchant_id);

        $company                    = CompanySetting::first();
        $data['task']               = $task;
        $data['merchant']           = $merchant;
        $data['company']            = $company;
        $data['delivery_id']        = "F0000" . $task->id;
        $data['delivery_date']      = $task->completion_time;
        $data['due_date']           = Carbon::parse($task->completion_time)->subDay(1)->format('d M Y');

        $delivery_id = "F0000" . $task->id;
        //return view("administrator.delivery-orders.pdf", compact("task", "merchant", "company", "delivery_id"));
        $pdf = Pdf::loadView('administrator.delivery-orders.pdf', $data);
        $pdf->set_option('isRemoteEnabled', true);
        return $pdf->download("DO F0000" . $task->id . '.pdf');
    }
}

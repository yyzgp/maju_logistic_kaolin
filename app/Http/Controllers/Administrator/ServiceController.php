<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\MerchantStoreDetail;
use App\Models\Service;
use Deployer\Executor\Server;
use Illuminate\Http\Request;

class ServiceController extends Controller
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
        $filter['service']      = $request->service;
        $filter['type']         = $request->type;
        $filter['merchant']     = $request->merchant;
        $filter['status']       = $request->status;

        $services                 = Service::query();
        $services                 = isset($filter['service']) ? $services->where("id", $filter['service']) : $services;
        $services                 = isset($filter['type']) ? $services->whereJsonContains('type', $filter['type']) : $services;
        $services                 = isset($filter['merchant']) ? $services->whereJsonContains('merchants', [(int)$filter['merchant']]) : $services;
        $services                 = isset($filter['status']) ? $services->where('status',  $filter['status']) : $services;
        $merchants                = Merchant::get();
        $all_services             = Service::get();
        $services                 = $services->orderBy('id', 'desc')->paginate(10);

        return view('administrator.services.list', compact('services', 'filter', 'merchants', 'all_services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $merchants = Merchant::orderBy('name', 'asc')->get();
        return view('administrator.services.create', compact('merchants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name'                  => ['required', 'string', 'max:255'],
            'merchants'             => ['required', 'array', 'min:1'],
            'type'                  => ['required', 'array', 'min:1'],
            'price'                 => ['required'],
            'extra_night_price'     => ['required'],
            'status'                => ['required']
        ]);

        $service                      = new Service();
        $service->name                = $request->name;
        $service->merchants           = array_map('intval', (array) $request->merchants);
        $service->type                = $request->type;
        $service->price               = $request->price;
        $service->status              = $request->status;
        $service->extra_night_price   = $request->extra_night_price;
        $service->save();

        return redirect()->route('administrator.services.index')->with('success', 'Service created sucessfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $merchants  = Merchant::get();
        $service    = Service::find($id);
        $service->avatar  = "https://placehold.co/150x150/D82D36/FFF?text=".$service->name[0].''.$service->name[1];
        return view('administrator.services.show', compact('merchants', "service"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $merchants  = Merchant::get();
        $service    = Service::find($id);
        return view('administrator.services.edit', compact('merchants', "service"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request->all());
        $this->validate($request, [
            'name'                  => ['required', 'string', 'max:255'],
            'merchants'             => ['required', 'array', 'min:1'],
            'type'                  => ['required', 'array', 'min:1'],
            'price'                 => ['required'],
            'extra_night_price'     => ['required'],
            'status'                => ['required']
        ]);

        $service                      = Service::find($id);
        $service->name                = $request->name;
        $service->merchants           = array_map('intval', (array) $request->merchants);;
        $service->type                = $request->type;
        $service->price               = $request->price;
        $service->status              = $request->status;
        $service->extra_night_price   = $request->extra_night_price;
        $service->save();

        return redirect()->route('administrator.services.index')->with('success', 'Service updated sucessfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Service::find($id)->delete();
        return redirect()->route('administrator.services.index')->with('success', 'Service deleted sucessfully!');
    }

    public function bulkDelete(Request $request)
    {
        Service::whereIn('id', $request->services)->delete();
        return response()->json(['success' => 'Services deleted successfully!'], 200);
    }

    public function changeStatus(Request $request)
    {
        $service = Service::find($request->service_id);
        Service::find($request->service_id)->update(['status' => $request->status]);
        return response()->json(['success' => 'Service status has been changed successfully!'], 200);
    }

    public function getServices(Request $request){
        $filter['type']           = $request->type;
        $filter['merchant']       = $request->merchant;
        $services                 = Service::query();
        if(isset($filter['type'])){
            if($filter['type']       == "Towing & Battery/Tyre"){
                $services             = $services->whereJsonContains('type', ["Towing", "Battery/Tyre"]);
            }else{
                $services             = $services->whereJsonContains('type', [$filter['type']]);
            }

        }
        $services                 = isset($filter['merchant']) ? $services->whereJsonContains('merchants', [(int)$filter['merchant']]) : $services;
        $services                 = $services->get();
        $destination              = MerchantStoreDetail::where('merchant_id', $filter['merchant'] )->first();
        return response()->json(['services' => $services, 'destination' => $destination], 200);
    }

    public function getServicePrice(Request $request){
       $service = Service::find($request->service);
        return response()->json(['service' => $service], 200);
    }
}

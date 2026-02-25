<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use App\Models\DriverDoc;
use Illuminate\Contracts\Concurrency\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
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

        $drivers                 = User::query();
        $drivers                 = isset($filter['name']) ? $drivers->where(DB::raw("concat(firstname, ' ', lastname)"), 'LIKE', '%' . $filter['name'] . '%') : $drivers;
        $drivers                 = isset($filter['email']) ? $drivers->where('email', 'LIKE', '%' . $filter['email'] . '%') : $drivers;
        $drivers                 = isset($filter['phone']) ? $drivers->where('phone', 'LIKE', '%' . $filter['phone'] . '%') : $drivers;

        if (isset($filter['status'])) {
            if ($filter['status'] == 'Yes') {
                $drivers          = $drivers->where('status', true);
            }

            if ($filter['status'] == 'No') {
                $drivers          = $drivers->where('status', false);
            }
        }

        $drivers                 = $drivers->orderBy('id', 'desc')->paginate(10);

        return view('administrator.drivers.list', compact('drivers', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('administrator.drivers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname'                 => ['required', 'string', 'max:255'],
            'lastname'                 => ['required', 'string', 'max:255'],
            'email'                     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'                     => ['required', 'min:8', 'unique:users'],
            'password'                  => ['required', 'string', 'min:8', 'confirmed'],
            'gender'                    => ['required'],
            'status'                    => ['required'],
            'vehicle_type'              => ['required'],
            'vehicle_description'       => ['required'],
            'vehicle_registration_no'   => ['required']
        ]);

        $driver                             = new User();
        $driver->firstname                  = $request->firstname;
        $driver->lastname                   = $request->lastname;
        $driver->email                      = $request->email;
        $driver->password                   = Hash::make($request->password);
        $driver->dialcode                   = $request->dialcode;
        $driver->vehicle_type               = $request->vehicle_type;
        $driver->vehicle_description        = $request->vehicle_description;
        $driver->vehicle_registration_no    = $request->vehicle_registration_no;
        $driver->phone                      = $request->phone;
        $driver->gender                     = $request->gender;
        $driver->address                    = $request->address;
        $driver->city                       = $request->city;
        $driver->state                      = $request->state;
        $driver->zipcode                    = $request->zipcode;
        $driver->iso2                       = $request->iso2;
        $driver->email_verified_at          = now();
        $driver->save();

        if ($request->hasfile('avatar')) {

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/drivers/' . $driver->slug . '/', $name, 'public');

            User::find($driver->id)->update(['avatar' => $name]);
        }

        return redirect()->route('administrator.drivers.index')->with('success', 'Driver created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $driver          = User::find($id);
        $driver->avatar  = isset($driver->avatar) ? asset('storage/uploads/drivers/' . $driver->slug . '/' . $driver->avatar) : "https://placehold.co/150x150/D82D36/FFF?text=" . $driver->firstname[0] . '' . (isset($driver->lastname) ? $driver->lastname[0]  : '');
        $driver->country = Country::where('code', $driver->iso2)->first()->name;
        return view('administrator.drivers.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $driver          = User::find($id);
        $driver->avatar  = isset($driver->avatar) ? asset('storage/uploads/drivers/' . $driver->slug . '/' . $driver->avatar) : "https://placehold.co/150x150/D82D36/FFF?text=" . $driver->firstname[0] . '' . (isset($driver->lastname) ? $driver->lastname[0]  : '');
        return view('administrator.drivers.edit', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'firstname'                 => ['required', 'string', 'max:255'],
            'lastname'                 => ['required', 'string', 'max:255'],
            'email'                     => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'phone'                     => ['required', 'min:8', 'unique:users,phone,' . $id],
            'gender'                    => ['required'],
            'status'                    => ['required'],
            'vehicle_type'              => ['required'],
            'vehicle_description'       => ['required'],
            'vehicle_registration_no'   => ['required']
        ]);

        $driver                             = User::find($id);
        $driver->firstname                  = $request->firstname;
        $driver->lastname                   = $request->lastname;
        $driver->email                      = $request->email;
        $driver->dialcode                   = $request->dialcode;
        $driver->vehicle_type               = $request->vehicle_type;
        $driver->vehicle_description        = $request->vehicle_description;
        $driver->vehicle_registration_no    = $request->vehicle_registration_no;
        $driver->phone                      = $request->phone;
        $driver->gender                     = $request->gender;
        $driver->address                    = $request->address;
        $driver->city                       = $request->city;
        $driver->state                      = $request->state;
        $driver->zipcode                    = $request->zipcode;
        $driver->iso2                       = $request->iso2;
        $driver->status                     = $request->status;

        if ($request->hasfile('avatar')) {

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/drivers/' . $driver->slug . '/', $name, 'public');

            if (isset($driver->avatar)) {

                $path   = 'public/uploads/drivers/' . $driver->slug . '/' . $driver->avatar;

                Storage::delete($path);
            }

            $driver->avatar = $name;
        }

        $driver->save();

        return redirect()->route('administrator.drivers.index')->with('success', 'Driver updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
        return redirect()->route('administrator.drivers.index')->with('success', 'Driver deleted successfully!');
    }

    public function changeStatus($id)
    {
        $driver = User::find($id);
        if ($driver->status == true) {
            User::find($id)->update(['status' => false]);
            return redirect()->route('administrator.drivers.index')->with('warning', 'Driver has been disabled successfully!');
        } else {
            User::find($id)->update(['status' => true]);
            return redirect()->route('administrator.drivers.index')->with('success', 'Driver has been enabled successfully!');
        }
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'min:6', 'confirmed']
        ]);
        User::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
        return redirect()->route('administrator.drivers.index')->with('success', 'Driver password has been reset successfully!');
    }

    public function bulkDelete(Request $request)
    {
        User::whereIn('id', $request->drivers)->delete();
        return response()->json(['success' => 'Driver deleted successfully!'], 200);
    }
    public function documents($id)
    {
        $docs = DriverDoc::whereDriverId($id)->get();
        $driver_id = $id;
        return view('administrator.drivers.documents', compact('docs', 'driver_id'));
    }
    public function documentAdd(Request $request)
    {

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fname = $request->document . '.' . $file->getClientOriginalExtension();
            $file->storeAs('storage/uploads/driver-docs/', $fname, 'public');

            DriverDoc::updateOrCreate(
                [
                    'driver_id' => $request->driver_id,
                    'document' => $request->document
                ],
                [
                    'driver_id' => $request->driver_id,
                    'document' => $request->document,
                    'file' => $fname
                ]
            );
            return redirect()->back()->with(['success' => 'Document uploaded successfully.']);
        } else {
            return redirect()->back()->with(['error' => 'Please upload file. No file found.']);
        }
    }

    public function documentStatus(Request $request)
    {
        DriverDoc::find($request->id)->update(['status' => $request->status]);
        return redirect()->back()->with(['success' => 'Document updated successfully.']);
    }
    public function documentDelete(Request $request, $id)
    {
        DriverDoc::find($id)->delete();
        return redirect()->back()->with(['success' => 'Document deleted successfully.']);
    }

    public function notifyAppON(Request $request)
    {
        $driver = User::find($request->id);
        $msg =  "Please make yourself " . ($request->prop == 1 ? 'online' : 'offline') . " in app";
        $response = Http::post('https://exp.host/--/api/v2/push/send', [
            'to' => $driver->app_push_token,
            'title' => "Alert Notification",
            'body' => $msg,
        ]);
        $result = "Driver app has been notified for this user to make status " . ($request->prop == 1 ? 'online' : 'offline');
        return response()->json([
            'success' => $result
        ]);
    }
}

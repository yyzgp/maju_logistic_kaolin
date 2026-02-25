<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DispatcherController extends Controller
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

        $dispatchers                 = Administrator::where('role', 'dispatcher');
        $dispatchers                 = isset($filter['name']) ? $dispatchers->where(DB::raw("concat(firstname, ' ', lastname)"), 'LIKE', '%' . $filter['name'] . '%') : $dispatchers;
        $dispatchers                 = isset($filter['email']) ? $dispatchers->where('email', 'LIKE', '%' . $filter['email'] . '%') : $dispatchers;
        $dispatchers                 = isset($filter['phone']) ? $dispatchers->where('phone', 'LIKE', '%' . $filter['phone'] . '%') : $dispatchers;

        if(isset($filter['status'])){
            if($filter['status'] == 'Yes'){
                $dispatchers          = $dispatchers->where('status', true);
            }

            if($filter['status'] == 'No'){
                $dispatchers          = $dispatchers->where('status', false);
            }
        }

        $dispatchers                 = $dispatchers->orderBy('id', 'desc')->paginate(10);

        return view('administrator.dispatchers.list', compact('dispatchers', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('administrator.dispatchers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:administrators'],
            'phone'     => ['required', 'min:8', 'unique:administrators'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'gender'    => ['required'],
            'status'    => ['required']
        ]);

        $dispatcher                      = new Administrator();
        $dispatcher->firstname           = $request->firstname;
        $dispatcher->lastname            = $request->lastname;
        $dispatcher->email               = $request->email;
        $dispatcher->password            = Hash::make($request->password);
        $dispatcher->dialcode            = $request->dialcode;
        $dispatcher->role                = 'dispatcher';
        $dispatcher->phone               = $request->phone;
        $dispatcher->gender              = $request->gender;
        $dispatcher->address             = $request->address;
        $dispatcher->city                = $request->city;
        $dispatcher->state               = $request->state;
        $dispatcher->zipcode             = $request->zipcode;
        $dispatcher->iso2                = $request->iso2;
        $dispatcher->email_verified_at   = now();
        $dispatcher->save();

        if ($request->hasfile('avatar')) {

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/administrators/'.$dispatcher->slug.'/', $name, 'public');

            Administrator::find($dispatcher->id)->update(['avatar' => $name]);

        }

        return redirect()->route('administrator.dispatchers.index')->with('success', 'Dispatcher created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dispatcher          = Administrator::find($id);
        $disp                = $dispatcher->lastname ? $dispatcher->lastname[0] : $dispatcher->firstname[1];
        $dispatcher->avatar  = isset($dispatcher->avatar) ? asset('storage/uploads/administrators/'.$dispatcher->slug.'/'.$dispatcher->avatar) : "https://placehold.co/150x150/D82D36/FFF?text=".$dispatcher->firstname[0].''.$disp;
        $dispatcher->country = Country::where('code', $dispatcher->iso2)->first()->name;
        return view('administrator.dispatchers.show', compact('dispatcher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dispatcher          = Administrator::find($id);
        $disp                = $dispatcher->lastname ? $dispatcher->lastname[0] : $dispatcher->firstname[1];
        $dispatcher->avatar  = isset($dispatcher->avatar) ? asset('storage/uploads/administrators/'.$dispatcher->slug.'/'.$dispatcher->avatar) : "https://placehold.co/150x150/D82D36/FFF?text=".$dispatcher->firstname[0].''.$disp;
        return view('administrator.dispatchers.edit', compact('dispatcher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:administrators,email,' . $id],
            'phone'     => ['required', 'min:8', 'unique:administrators,phone,' . $id],
            'gender'    => ['required'],
            'status'    => ['required']
        ]);

        $dispatcher                  = Administrator::find($id);
        $dispatcher->firstname       = $request->firstname;
        $dispatcher->lastname        = $request->lastname;
        $dispatcher->email           = $request->email;
        $dispatcher->dialcode        = $request->dialcode;
        $dispatcher->phone           = $request->phone;
        $dispatcher->gender          = $request->gender;
        $dispatcher->address         = $request->address;
        $dispatcher->city            = $request->city;
        $dispatcher->state           = $request->state;
        $dispatcher->zipcode         = $request->zipcode;
        $dispatcher->iso2            = $request->iso2;
        $dispatcher->status          = $request->status;

        if($request->hasfile('avatar')){

            $image      = $request->file('avatar');

            $name       = $image->getClientOriginalName();

            $image->storeAs('uploads/administrators/'.$dispatcher->slug.'/', $name, 'public');

            if(isset($dispatcher->avatar)){

                $path   = 'public/uploads/administrators/'.$dispatcher->slug.'/'.$dispatcher->avatar;

                Storage::delete($path);

            }

            $dispatcher->avatar = $name;

        }

        $dispatcher->save();

        return redirect()->route('administrator.dispatchers.index')->with('success', 'Dispatcher updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Administrator::find($id)->delete();
        return redirect()->route('administrator.dispatchers.index')->with('success', 'Admin deleted successfully!');
    }

    public function changeStatus($id){
        $admin = Administrator::find($id);
        if($admin->status == true){
            Administrator::find($id)->update(['status' => false]);
            return redirect()->route('administrator.dispatchers.index')->with('warning', 'Dispatcher has been disabled successfully!');
        }else{
            Administrator::find($id)->update(['status' => true]);
            return redirect()->route('administrator.dispatchers.index')->with('success', 'Dispatcher has been enabled successfully!');
        }
    }

    public function resetPassword(Request $request){
        $this->validate($request, [
            'password' => ['required', 'min:6', 'confirmed']
        ]);
        Administrator::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
        return redirect()->route('administrator.dispatchers.index')->with('success', 'Dispatcher password has been reset successfully!');
    }

    public function bulkDelete(Request $request)
    {
        Administrator::whereIn('id', $request->dispatchers)->delete();
        return response()->json(['success' => 'Dispatcher deleted successfully!'], 200);
    }
}

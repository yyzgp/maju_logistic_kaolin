<?php

namespace App\Http\Controllers\Api\Dispatcher;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Authenticates a driver with the given credentials and returns an access token.
     *
     * @bodyParam email string required The drivers email address.
     * @bodyParam password string required The drivers password.
     *
     * @responseFile responses/login.json
     */
    public function login(Request $request)
    {
      
        $data                   = $request->validate([
            'email'             => 'required|string|email',
            'password'          => 'required|min:8'
        ]);

        $user                   = Administrator::where('email', $data['email'])->where('role','dispatcher')->first();
      
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message'       => 'Invalid Credentials'
            ], 401);
        }

        $token                  = $user->createToken($user->name . '-AuthToken-Dispatcher')->plainTextToken;

        return response()->json([
            'access_token'      => $token,
        ], 200);
    }

    /**
     * Logout a driver and remove their access token.
     *
     * @responseFile responses/logout.json
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            "message" => "logged out"
        ], 200);
    }

    /**
     * Retrieves the profile of the authenticated driver.
     *
     * @param Request $request The incoming request instance.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $id                  = $request->user()->id;
        $dispatcher          = Administrator::find($id);
        $dispatcher->initials = $dispatcher->firstname[0] . '' . ((isset($dispatcher->lastname[0]))?$dispatcher->lastname[0]:'');
        $dispatcher->avatar  = isset($dispatcher->avatar) ? asset('storage/uploads/administrators/' . $dispatcher->slug . '/' . $dispatcher->avatar) : "";
        $dispatcher->country = Country::where('code', $dispatcher->iso2)->first()->name;
    
        return response()->json([
            "profile" => $dispatcher
        ], 200);
    }

    public function updateProfile(Request $request, $id){

        $rules = [
            'name'                            => ['required'],
            'gender'                          => ['required'],
            'address'                         => ['required']
        ];

        $messages = [
            'name.required'                     => 'Please enter Name',
            'gender.required'                   => 'Please choose Gender',
            'address.required'                  => 'Please enter Address',
        ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if( $validator->fails() ){
           return response()->json(['errors'=>$validator->messages()]);
        }

        $name = explode(' ',$request->name);

        $dispatcher                       = Administrator::find($id);
        $dispatcher->firstname            = $name[0];
        $dispatcher->lastname             = ((isset($name[1])?$name[1]:'')).''.((isset($name[2])?' '.$name[2]:''));
        $dispatcher->phone                = $request->phone;
        $dispatcher->gender               = $request->gender;
        $dispatcher->address              = $request->address;
        $dispatcher->state                = $request->state;
        $dispatcher->city                 = $request->city;
        $dispatcher->iso2                 = Country::where('name', $request->country)->first()->code;
        $dispatcher->zipcode              = $request->zipcode;
        $dispatcher->save();


        return response()->json([
            'status_code' => 200,
            'user'    => $dispatcher,
            'message' => "profile updated successfully"
        ]);

    }

    public function updateProfileAvatar(Request $request, $id){

        $dispatcher = Administrator::find($id);

        if ($request->hasFile('avatar')) {

            $avatar = $request->file('avatar');

            $avatar_name = time() . '_' . $avatar->getClientOriginalName();
            $path = 'uploads/administrators/' . $dispatcher->slug . '/';
            $avatar->storeAs($path, $avatar_name, 'public');

            if ($dispatcher->avatar) {
                $old_avatar_path = 'public/' . $path . '/' . $dispatcher->avatar;
                Storage::delete($old_avatar_path);
            }
            Administrator::where('id',$dispatcher->id)->update(['avatar' => $avatar_name]);

        }

        return response()->json([
            'status_code' => 200,
            'message' => "profile image updated successfully"
        ]);

    }

    public function updatePushToken(Request $request)
    {
        Administrator::find($request->user()->id)->update(['app_push_token' => $request->token]);
        return response()->json(['success' => 'Token Updated']);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' =>['required'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }

        if ( !Hash::check($request->current_password, $request->user()?->password ) ) {
            return response()->json(['errors' => ['Current password not matched']]);
        }

        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['success' => 'Password has been reset successfully!'], 200);
    }
    public function countries(){
        $countries =Country::get(['code as key','name as value']);

        return response()->json([
            "countries" => $countries
        ], 200);
    }
}

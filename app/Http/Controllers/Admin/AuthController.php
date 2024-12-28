<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;
use Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function loginInsert(Request $request)
    {
        // VALIDATION START
            $rules = array(
                'email'     => 'required',
                'password'     => 'required',
                );

            $validatorMesssages = array(
                'email.required'=>'Please Enter Email.',
                'password.required'=>'Please Enter Password.',
                );

            $validator = Validator::make($request->all(), $rules, $validatorMesssages);

            if ($validator->fails()) {

                $error=json_decode($validator->errors());
                return response()->json(['status' => 401,'error1' => $error]);
            }
        // VALIDATION END

        $checkUser = User::where('email', '=', $request->email)->first();

        if(empty($checkUser))
        {
            $error = array('email'=>'Mail Not Match.');
            return response()->json(['status' => 401,'error1' => $error]);
        }

        $credentials = ['email'=>$request->email,'password'=>$request->password];
        // if(Auth::guard('admin')->attempt($credentials))
        if (Auth::attempt($credentials))
        {
            $redirect = route('admin.dashboard');
            return response()->json(['status' => 1,'data' => "", 'redirect' => $redirect]);
        }
        else
        {
            $error = array('password'=>'Password Not Match.');
            return response()->json(['status' => 401,'error1' => $error]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        // if (!auth()->user()->can('View All Roles')) {
        //     echo"no"; die;
        // }
        // echo"yes"; die;
        return view('admin.dashboard');
    }

    public function registration()
    {
        $data['roles'] =  Role::where('id', '<>', 1)->get();
        return view('admin.registration', $data);
    }

    public function registerInsert(Request $request)
    {
        // VALIDATION START
            $rules = array(
                'name'         => 'required|string|max:255',
                'email'        => 'required|email|unique:users,email|max:255',
                'password'     => 'required|min:8',
                'address'      => 'required|string|max:255',
                'mobile'       => 'required|numeric|digits:10|unique:users,phone',
                'role_id'      => 'required|numeric|exists:roles,id',
                'image'        => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                // Get the first validation error
                $error = $validator->errors()->first();

                // Return a JSON response with the error
                return response()->json(['status' => false, 'error' => $error]);
            }

        // VALIDATION END

        #save image
        $regiserImage = null;
        if ($request->image) {
            $path  = config('image.profile_image_path_view');
            $regiserImage = CommonController::saveImage($request->image, $path , 'registration');
        }

        $roleCheck = Role::where('id',$request->role_id)->first();

        // Create a new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->mobile;
        $user->address = $request->address;
        $user->role = $roleCheck->id;
        $user->image = $regiserImage;
        $user->status = 1;
        $user->save();

        // Assign role to the user
        $user->assignRole($roleCheck->id);
        Auth::login($user);

        $redirect = route('admin.dashboard');
        return response()->json(['status' => true,'data' => "", 'redirect' => $redirect]);
    }
}

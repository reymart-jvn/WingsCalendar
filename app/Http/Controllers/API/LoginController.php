<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use JWTAuth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\VehicleHasDriver;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Laravel\Passport\PersonalAccessTokenFactory;
class LoginController extends Controller
{

    public function login(Request $request)
    {
        // $input = $request->only('code', 'password');

        // $password = Hash::make($input['password']);

        $token = null;

        $user = Driver::where('code', $request->code)
            ->first();

        $user_device = VehicleHasDriver::with('vehicleDevice')->where('driver_id', $user->id)->where('status','1')->first();
        $device_code =  $user_device->vehicleDevice->firebase_key;

        // dd($user);
        if (!is_null($user)) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => true,
                    'message'   => 'User logged in Successfully !',
                    'token' => $token,
                    // 'user' => $user,
                    'data' => $user,
                    'device_code' =>  $device_code
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Username and password do not match. Please try again. If username and password do not work, your account may have been disabled or not exist.',
                ], 401);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Username and password do not match. Please try again. If username and password do not work, your account may have been disabled or not exist.',
            ], 401);
        }
        // if(!is_null($user)){
        // return response()->json([
        //     'success' => true,
        //     'message'   => 'User logged in Successfully !',
        //     'token' => $token,
        //     // 'user' => $user,
        //     'data' => $user,
        // ]);
        // }else{
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Invalid driver code or password. Please try again!',
        //     ], 401);
        // }

        // $user = Auth::user();
        // $user->farmer = Farmer::where('user_id', $user->id)->with(['family_members', 'bank_information'])->first();

        // return response()->json([
        //     'success' => true,
        //     'message'   => 'User logged in Successfully !',
        //     'token' => $token,
        //     // 'user' => $user,
        //     'data' => $user,
        // ]);
    }
    // public function login(Request $request)
    // {
    //     $input = $request->only('email', 'password');

    //     $token = null;

    //     $user = User::select(
    //         'id',
    //         'email',
    //         'password',
    //         'status'
    //     )->where('email', $input['email'])
    //         ->first();

    //     if (!is_null($user)) {
    //         // if (Hash::check($request->password, $user->password)) {
    //         //     if (!$token = JWTAuth::attempt($input, ['exp' => Carbon::now()->addYears(3)->timestamp])) {
    //         //         return response()->json([
    //         //             'success' => false,
    //         //             'message' => 'Invalid Username or Password',
    //         //         ], 401);
    //         //     }
    //         // } else {
    //         //     return response()->json([
    //         //         'success' => false,
    //         //         'message' => 'Invalid Username or Password',
    //         //     ], 401);
    //         // }
    //         // $user = Auth::user();
    //         // $user->farmer = Farmer::where('user_id', $user->id)->with(['family_members', 'bank_information'])->first();

    //         return response()->json([
    //             'success' => true,
    //             'message'   => 'User logged in Successfully !',
    //             'token' => $token,
    //             // 'user' => $user,
    //             'data' => $user,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No existing account',
    //         ], 401);
    //     }
    // }

}

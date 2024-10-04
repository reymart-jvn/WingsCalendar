<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\PersonHasCompanyDepartment;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\VehicleHasDriver;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;


class LoginController extends Controller
{

    // public function login(Request $request)
    // {
    //     // $input = $request->only('code', 'password');

    //     // $password = Hash::make($input['password']);

    //     $token = null;

    //     $user = User::where('email', $request->email)
    //         ->first();

    //     // dd($user);
    //     if (!is_null($user)) {
    //         if (Hash::check($request->password, $user->password)) {
    //             return response()->json([
    //                 'success' => true,
    //                 'message'   => 'User logged in Successfully !',
    //                 'token' => $token,
    //                 // 'user' => $user,
    //                 'data' => $user,
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Username and password do not match. Please try again. If username and password do not work, your account may have been disabled or not exist.',
    //             ], 401);
    //         }
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Username and password do not match. Please try again. If username and password do not work, your account may have been disabled or not exist.',
    //         ], 401);
    //     }

    // }
    public function login(Request $request)
    {
        // $input = $request->only('email', 'password');

        // $token = null;

        // $user = User::where('email', $input['email'])
        //     ->first();

        // if ($user) {
        //     if (Hash::check($request->password, $user->password)) {
        //         if (!$token = JWTAuth::attempt($input)) {
        //             return response()->json([
        //                 'success' => false,
        //                 'message' => 'Invalid Username or Password',
        //             ], 401);
        //         }
        //     } else {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'Invalid Username or Password',
        //         ], 401);
        //     }
        //     $user = Auth::user();

        //     return response()->json([
        //         'success' => true,
        //         'message'   => 'User logged in Successfully !',
        //         'token' => $token,
        //         // 'user' => $user,
        //         'data' => $user,
        //     ]);
        // } 
        // else {
            // return response()->json([
            //     'success' => false,
            //     'message' => 'No existing account',
            // ], 401);
        // }

        $input = $request->only([
            'email',
            'password'
        ]);

        $validator = Validator::make($input ,[
            'email'=>'required',
            'password'=>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Error',
            ], 401);
        }
        // if(!$token=auth()->attempt($validator->validated())){
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Unauthoried',
        //     ], 401);
        // }

        if (!$token = JWTAuth::attempt($validator->validated(),['exp' => Carbon::now()->addYears(3)->timestamp])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }
        
        return $this->createnewToken($token);

    }

    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'mobile_number' => 'required',
    //         'password' => ['required', Rules\Password::defaults()],
    //         // 'location' => 'required',
    //         // 'mac_address' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->sendError('Validation Error.', $validator->errors());
    //     }

    //     if(Auth::attempt(['email' => $request->email, 'password' => $request->password]) ||
    //         Auth::attempt(['mobile_no' => $request->mobile_number, 'password' => $request->password])){
    //         $user = Auth::user();
    //         $tokenIdentifier = $user->id . ':MyApp';
    //         $success['token'] =  $user->createToken($tokenIdentifier)->plainTextToken;
    //         $success['first_name'] =  $user->first_name;
    //         $success['middle_name'] =  $user->middle_name;
    //         $success['last_name'] =  $user->last_name;
    //         $success['mobile_no'] =  $user->mobile_no;
    //         $success['email'] =  $user->email;
    //         return $this->sendResponse($success, 'User login successfully.');
    //     } else {
    //         return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    //     }
    // }

    

    public function createnewToken($token){
        $user = auth()->user();
        $personHasCompanyDepartment = PersonHasCompanyDepartment::with('companyProfile')->where('person_id',$user->person_id)->where('status','1')->first();
        $employee = Employee::with('employeeHasPosition.employeePositionHasPermissionAccess')->where('user_id', $user->id)->first();

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'data' => auth()->user(),
            'company' => $personHasCompanyDepartment->company_id,
            'company_code' => $personHasCompanyDepartment->companyProfile->company_code,
            'is_admin' => $user->is_admin,
            'is_super_admin' => $employee->employeeHasPosition->employeePositionHasPermissionAccess->permission_has_access_id == 1 ? 1 : 0,
            'message' => 'Successfully Login'
        ]);
    }

}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Employee;
use App\Models\EmployeeHasPosition;
use App\Models\PersonHasCompanyDepartment;
use App\Models\ComDepHasEmpPos;
use App\Models\CompanyProfile;
use App\Models\EmpPosHasPermissionAccess;
use App\Models\PeoplePersonInCharge;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\PersonInCharge;
use Kreait\Firebase\Database\Transaction;
use Illuminate\Support\Facades\Validator;



class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->only([
            'email',
            'passcode',
            'fullname',
            'password',
            'availability'
        ]);

        // Validate input
        $validator = Validator::make($input, [
            'email' => 'required',
            'passcode' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'availability' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation error!',
                'messages' => $validator->errors()
            ]);
        }


        try {
            DB::beginTransaction();
            $checkEmailExist = User::where('email',  convertData($request['email']))->count();
            $company = CompanyProfile::where('company_code', convertData($request['passcode']))->where('status', '1')->first();
            $email_exist = false;
            $company_exist = true;

            // dd($request['availability']);
            if ($checkEmailExist == 0) {
                if ($company) {
                    $company_exist = true;

                    $person = new Person();
                    $person->fullname = strtoupper(convertData($request['fullname']));
                    $person->status = "1";
                    $person->created_at = Carbon::now();
                    $person->updated_at = Carbon::now();
                    $person->save();


                    $personHasCompanyDepartment = new PersonHasCompanyDepartment();
                    $personHasCompanyDepartment->status = "1";
                    $personHasCompanyDepartment->person_id = $person->id;
                    $personHasCompanyDepartment->company_id = $company->id;
                    $personHasCompanyDepartment->department_id = 3;
                    $personHasCompanyDepartment->created_at = Carbon::now();
                    $personHasCompanyDepartment->updated_at = Carbon::now();
                    $personHasCompanyDepartment->save();


                    $user  = new User();
                    $user->name = strtoupper(convertData($request['fullname']));
                    $user->email = convertData($request['email']);
                    $user->person_id = $person->id;
                    $user->user_code = code_generator(8);
                    $user->is_admin = "0";
                    $user->status = "1";
                    $user->password = Hash::make($request['password']);
                    $user->created_at = Carbon::now();
                    $user->updated_at = Carbon::now();
                    $user->save();



                    $employee = new Employee();
                    $employee->employee_code = "";
                    $employee->user_id = $user->id;
                    $employee->person_has_company_department_id = $personHasCompanyDepartment->id;
                    $employee->status = "1";
                    $employee->created_at = Carbon::now();
                    $employee->updated_at = Carbon::now();
                    $employee->save();



                    $employeeHasPositions = new EmployeeHasPosition();
                    $employeeHasPositions->employee_id = $employee->id;
                    $employeeHasPositions->position_id = 3;
                    $employeeHasPositions->status = "1";
                    $employeeHasPositions->created_at = Carbon::now();
                    $employeeHasPositions->updated_at = Carbon::now();
                    $employeeHasPositions->save();



                    $companyDepartmentHasEmployeePosition = new ComDepHasEmpPos();
                    $companyDepartmentHasEmployeePosition->person_has_company_department_id = $personHasCompanyDepartment->id;
                    $companyDepartmentHasEmployeePosition->employee_has_position_id = $employeeHasPositions->id;
                    $companyDepartmentHasEmployeePosition->status = "1";
                    $companyDepartmentHasEmployeePosition->created_at = Carbon::now();
                    $companyDepartmentHasEmployeePosition->updated_at = Carbon::now();
                    $companyDepartmentHasEmployeePosition->save();

                    $employeePositionHasPermissionAccess = new EmpPosHasPermissionAccess();
                    $employeePositionHasPermissionAccess->employee_has_position_id = $employeeHasPositions->id;
                    $employeePositionHasPermissionAccess->permission_has_access_id = 3;
                    $employeePositionHasPermissionAccess->status = "1";
                    $employeePositionHasPermissionAccess->created_at = Carbon::now();
                    $employeePositionHasPermissionAccess->updated_at = Carbon::now();
                    $employeePositionHasPermissionAccess->save();

                    

                    $personincharge = new PersonInCharge;
                    $personincharge->company_id = $company->id;
                    $personincharge->code = '';
                    $personincharge->fullname = strtoupper(convertData($request['fullname']));
                    $personincharge->availability = convertData($request['availability']);
                    $personincharge->status = "1";
                    $personincharge->save();
                    $personincharge->code = $personincharge->id;
                    $personincharge->save();

                    $peoplepersonincharge = new PeoplePersonInCharge();
                    $peoplepersonincharge->company_id = $company->id;
                    $peoplepersonincharge->person_id = $person->id;
                    $peoplepersonincharge->personincharge_id = $personincharge->id;
                    $peoplepersonincharge->fullname = strtoupper(convertData($request['fullname']));
                    $peoplepersonincharge->status = "1";
                    $peoplepersonincharge->save();

                    // dd("here");

                    $message = '追加場所を保存しました';
                } else {
                    $company_exist = false;
                    $message = 'Your passcode is not exist. Please put a valid passcode ko continue to register or ask the admin to check. Thank you!';
                }
            } else {
                $email_exist = true;
                $message = 'Email is already exist. Please try again. Thank you!';
            }


            DB::commit();
            return response()->json(array('success' => true, 'email_exist' => $email_exist, 'company_exist' => $company_exist, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error hereeeeeee!', 'messages' => 'エラー'));
        }
        // try {
        //     $person = new Person();
        //     $person->status = "1";
        //     $person->created_at = Carbon::now();
        //     $person->updated_at = Carbon::now();
        //     $person->save();

        //     $company = CompanyProfile::where('commpany_code', convertData($request['passcode']))->where('status', '1')->first();

        //     if ($company) {
        //         $personHasCompanyDepartment = new PersonHasCompanyDepartment();
        //         $personHasCompanyDepartment->status = "1";
        //         $personHasCompanyDepartment->person_id = $person->id;
        //         $personHasCompanyDepartment->company_id = $company->id;
        //         $personHasCompanyDepartment->department_id = 3;
        //         $personHasCompanyDepartment->created_at = Carbon::now();
        //         $personHasCompanyDepartment->updated_at = Carbon::now();
        //         $personHasCompanyDepartment->save();

        //         $user  = new User();
        //         $user->name = $request['fullname'];
        //         $user->email = $request['email'];
        //         $user->person_id = $person->id;
        //         $user->status = "1";
        //         $user->password = Hash::make($request['password']);
        //         $user->created_at = Carbon::now();
        //         $user->updated_at = Carbon::now();
        //         $user->save();

        //         $employee = new Employee();
        //         $employee->employee_code = "";
        //         $employee->user_id = $user->id;
        //         $employee->person_has_company_department_id = $personHasCompanyDepartment->id;
        //         $employee->status = "1";
        //         $employee->created_at = Carbon::now();
        //         $employee->updated_at = Carbon::now();
        //         $employee->save();

        //         $employeeHasPositions = new EmployeeHasPosition();
        //         $employeeHasPositions->employee_id = $employee->id;
        //         $employeeHasPositions->position_id = 3;
        //         $employeeHasPositions->status = "1";
        //         $employeeHasPositions->created_at = Carbon::now();
        //         $employeeHasPositions->updated_at = Carbon::now();
        //         $employeeHasPositions->save();

        //         $companyDepartmentHasEmployeePosition = new ComDepHasEmpPos();
        //         $companyDepartmentHasEmployeePosition->person_has_company_department_id = $personHasCompanyDepartment->id;
        //         $companyDepartmentHasEmployeePosition->employee_has_position_id = $employeeHasPositions->id;
        //         $companyDepartmentHasEmployeePosition->status = "1";
        //         $companyDepartmentHasEmployeePosition->created_at = Carbon::now();
        //         $companyDepartmentHasEmployeePosition->updated_at = Carbon::now();
        //         $companyDepartmentHasEmployeePosition->save();

        //         $employeePositionHasPermissionAccess = new EmpPosHasPermissionAccess();
        //         $employeePositionHasPermissionAccess->employee_has_position_id = $employeeHasPositions->id;
        //         $employeePositionHasPermissionAccess->permission_has_access_id = 2;
        //         $employeePositionHasPermissionAccess->status = "1";
        //         $employeePositionHasPermissionAccess->created_at = Carbon::now();
        //         $employeePositionHasPermissionAccess->updated_at = Carbon::now();
        //         $employeePositionHasPermissionAccess->save();

        //         $personincharge = new PersonInCharge;
        //         $personincharge->company_id = $company->id;
        //         $personincharge->code = '';
        //         $personincharge->fullname = strtoupper(convertData($request['fullname']));
        //         $personincharge->availability = convertData($request['availability']);
        //         $personincharge->status = "1";
        //         $personincharge->save();
        //         $personincharge->code = $personincharge->id;
        //         $personincharge->save();

        //         $peoplepersonincharge = new PeoplePersonInCharge();
        //         $peoplepersonincharge->company_id = $company->id;
        //         $peoplepersonincharge->person_id = $person->id;
        //         $peoplepersonincharge->personincharge_id = $personincharge->id;
        //         $peoplepersonincharge->fullname = strtoupper(convertData($request['fullname']));
        //         $peoplepersonincharge->status = "1";
        //         $peoplepersonincharge->save();

        //         $message = '追加場所を保存しました';
        //     } else {
        //         $message = 'No passcode detected. Please put a valid passcode ko continue register. Thank you!';
        //     }

        //     return response()->json(array('success' => true, 'messages' => $message));
        // } catch (\PDOException $e) {
        //     DB::rollBack();
        //     return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
        // }
    }

    public function checkcompanypasscode(Request $request)
    {
        try {
            DB::beginTransaction();

            $company = CompanyProfile::where('company_code', convertData($request['passcode']))->where('status', '1')->first();
            $company_exist = true;
            if ($company) {
                $company_exist = true;

                $message = '追加場所を保存しました';
            } else {
                $company_exist = false;
                $message = 'Your passcode is not exist. Please put a valid passcode ko continue to register or ask the admin to check. Thank you!';
            }
            DB::commit();
            return response()->json(array('success' => $company_exist, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error hereeeeeee!', 'messages' => 'エラー'));
        }
    }


    public function checkemail(Request $request)
    {

        try {
            DB::beginTransaction();
            $checkIfEmailNotExist = User::where('email', $request['email'])->count();

            if ($checkIfEmailNotExist != 0) {
                $email_exist = false;
            } else {
                $email_exist = true;
                $message = 'Email is already exist. Please try again. Thank you!';
            }

            DB::commit();
            return response()->json(array('success' => $email_exist, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error here!', 'messages' => 'エラー'));
        }
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

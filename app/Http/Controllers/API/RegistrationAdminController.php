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
use App\Models\Department;
use App\Models\CompanyHasDepartment;
use App\Models\CompanyHasPersonIncharge;
use Illuminate\Support\Facades\Gate;
use App\Models\Access;
use App\Models\Permission;
use App\Models\PermissionHasAccess;


class RegistrationAdminController extends Controller
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
            'groupname',
            'acronym'
        ]);

        // Validate input
        $validator = Validator::make($input, [
            'email' => 'required',
            'passcode' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'groupname' => 'required|string|max:255',
            'acronym' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation error!',
                'messages' => $validator->errors()
            ]);
        }

        $current_date = Carbon::today();
        $year = $current_date->year;
        $day = $current_date->day;
        $month = $current_date->month;

        try {
            DB::beginTransaction();
            $checkEmailExist = User::where('email',  convertData($request['email']))->count();
            $company = CompanyProfile::where('company_name', convertData($request['groupname']))->where('status', '1')->first();
            $email_exist = false;
            $company_exist = false;
            if ($checkEmailExist == 0) {
                if (!$company) {
                    $company_exist = false;
                    $company = new CompanyProfile();
                    $company->company_code = convertData($request['passcode']);
                    $company->company_name = convertData($request['groupname']);
                    $company->acronym = convertData($request['acronym']);
                    $company->vat_no = '-';
                    $company->email = convertData($request['email']);
                    $company->address = '-';
                    $company->contact_number = '-';
                    $company->tel_number = '-';
                    // $company->department_id =  serialize($request['add_department_multiselect']);
                    $company->status = "1";
                    $company->save();


                    $companyHasDepartments = new CompanyHasDepartment();
                    $companyHasDepartments->company_id = $company->id;
                    $companyHasDepartments->department_id = 3;
                    $companyHasDepartments->status = '1';
                    $companyHasDepartments->save();


                    $personIncharge = new CompanyHasPersonIncharge();
                    $personIncharge->employee_no = '-';
                    $personIncharge->company_id =  $company->id;
                    $personIncharge->first_name = '-';
                    $personIncharge->middle_name = '-';
                    $personIncharge->last_name = '-';
                    $personIncharge->home_address = '-';
                    $personIncharge->contact_number = '-';
                    $personIncharge->email = convertData($request['email']);
                    $personIncharge->status = '1';
                    $personIncharge->save();

                    $person = new Person();
                    $person->fullname = strtoupper(convertData($request['fullname']));
                    $person->status = "1";
                    $person->save();

                    $personHasCompanyDepartment = new PersonHasCompanyDepartment();
                    $personHasCompanyDepartment->status = "1";
                    $personHasCompanyDepartment->person_id = $person->id;
                    $personHasCompanyDepartment->company_id = $company->id;
                    $personHasCompanyDepartment->department_id = 3;
                    $personHasCompanyDepartment->save();


                    $current_date = Carbon::today();
                    $year = $current_date->year;
                    $day = $current_date->day;
                    $month = $current_date->month;


                    $permission = new Permission();
                    $permission->permission_code = "";
                    $permission->permission_description = convertData($request['acronym']) . "_ADMIN";
                    $permission->status = "1";
                    $permission->save();

                    $generate_permission_code = 'PER' . str_pad($day . substr($year, -2) . $month .  $permission->id, 6, '0', STR_PAD_LEFT);
                    $permission->permission_code = $generate_permission_code;
                    $permission->save();

                    $access = new Access();
                    $access->access_code = "";
                    $access->access_list = 'a:37:{i:0;s:20:"viewMainSystemHeader";i:1;s:13:"viewDashboard";i:2;s:13:"createAccount";i:3;s:13:"updateAccount";i:4;s:11:"viewAccount";i:5;s:13:"deleteAccount";i:6;s:14:"restoreAccount";i:7;s:12:"resetAccount";i:8;s:16:"createPermission";i:9;s:16:"updatePermission";i:10;s:14:"viewPermission";i:11;s:16:"deletePermission";i:12;s:17:"restorePermission";i:13;s:15:"resetPermission";i:14;s:15:"viewEventHeader";i:15;s:17:"viewGuestCalendar";i:16;s:11:"createEvent";i:17;s:11:"updateEvent";i:18;s:9:"viewEvent";i:19;s:11:"deleteEvent";i:20;s:12:"restoreEvent";i:21;s:23:"viewEventSettingsHeader";i:22;s:14:"createLocation";i:23;s:14:"updateLocation";i:24;s:12:"viewLocation";i:25;s:14:"deleteLocation";i:26;s:15:"restoreLocation";i:27;s:16:"createActivities";i:28;s:16:"updateActivities";i:29;s:14:"viewActivities";i:30;s:16:"deleteActivities";i:31;s:17:"restoreActivities";i:32;s:20:"createPersonInCharge";i:33;s:20:"updatePersonInCharge";i:34;s:18:"viewPersonInCharge";i:35;s:20:"deletePersonInCharge";i:36;s:21:"restorePersonInCharge";}';
                    $access->status = "1";
                    $access->save();

                    // $generate_access_code = 'ACS' . str_pad($day . substr($year, -2) . $month .  $access->id, 6, '0', STR_PAD_LEFT);
                    $access->access_code = generateCode('ACS', $access->id);
                    $access->save();

                    $permissionHasAccess = new PermissionHasAccess();
                    $permissionHasAccess->permission_id = $permission->id;
                    $permissionHasAccess->company_id = $company->id;
                    $permissionHasAccess->department_id = 3;
                    $permissionHasAccess->position_id = 3;
                    $permissionHasAccess->access_id = $access->id;
                    $permissionHasAccess->status = "1";
                    $permissionHasAccess->save();

                    $user  = new User();
                    $user->name = strtoupper(convertData($request['fullname']));
                    $user->email = convertData($request['email']);
                    $user->person_id = $person->id;
                    $user->user_code = code_generator(8);
                    $user->is_admin = "1";
                    $user->status = "1";
                    $user->password = Hash::make($request['password']);
                    $user->save();

                    $employee = new Employee();
                    $employee->employee_code = "";
                    $employee->user_id = $user->id;
                    $employee->person_has_company_department_id = $personHasCompanyDepartment->id;
                    $employee->status = "1";
                    $employee->save();

                    $employeeHasPositions = new EmployeeHasPosition();
                    $employeeHasPositions->employee_id = $employee->id;
                    $employeeHasPositions->position_id = 3;
                    $employeeHasPositions->status = "1";
                    $employeeHasPositions->save();

                    $companyDepartmentHasEmployeePosition = new ComDepHasEmpPos();
                    $companyDepartmentHasEmployeePosition->person_has_company_department_id = $personHasCompanyDepartment->id;
                    $companyDepartmentHasEmployeePosition->employee_has_position_id = $employeeHasPositions->id;
                    $companyDepartmentHasEmployeePosition->status = "1";
                    $companyDepartmentHasEmployeePosition->save();

                    $employeePositionHasPermissionAccess = new EmpPosHasPermissionAccess();
                    $employeePositionHasPermissionAccess->employee_has_position_id = $employeeHasPositions->id;
                    $employeePositionHasPermissionAccess->permission_has_access_id = $permissionHasAccess->id;
                    $employeePositionHasPermissionAccess->status = "1";
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
                    $company_exist = true;
                    $message = 'The group name is already exist. Please try again!';
                }
            } else {
                $email_exist = true;
                $message = 'Email is already exist. Please try again. Thank you!';
            }



            DB::commit();

            return response()->json(array('success' => true, 'email_exist' => $email_exist, 'company_exist' => $company_exist, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
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

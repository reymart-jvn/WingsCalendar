<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Person;
use App\Models\Employee;
use App\Models\EmployeeHasPosition;
use App\Models\PersonHasCompanyDepartment;
use App\Models\ComDepHasEmpPos;
use App\Models\EmpPosHasPermissionAccess;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Carbon\Carbon;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\DB;
use App\Models\PersonInCharge;
use App\Models\PeoplePersonInCharge;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Models\Access;
use App\Models\Permission;
use App\Models\PermissionHasAccess;
use App\Models\CompanyHasDepartment;
use App\Models\CompanyHasPersonIncharge;


class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {




        if ($input['question'] == "1") {
           $validator = Validator::make($input, [
                'question' => ['required', 'string', 'max:1'],
                'passcode' => ['required', 'string', 'max:255'],
                'fullname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                // 'availability' => ['required', 'string', 'max:255'],
                'availability' => ['required', 'array'], // Ensures availability is present and is an array
                'availability.*' => ['string', 'in:月曜日,火曜日,水曜日,木曜日,金曜日,土曜日,日曜日'],
                'groupname' => ['required', 'string', 'max:255'],
                'groupname_acronym' => ['required', 'string', 'max:255'],
                'password' => $this->passwordRules(),
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            ])->validate();
        } else {
            $validator = Validator::make($input, [
                'question' => ['required', 'string', 'max:1'],
                // 'passcode' => ['required', 'string', 'max:255'],
                'fullname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'availability' => ['required', 'array'], // Ensures availability is present and is an array
                'availability.*' => ['string', 'in:月曜日,火曜日,水曜日,木曜日,金曜日,土曜日,日曜日'],
                'groupname' => ['required', 'string', 'max:255'],
                'groupname_acronym' => ['required', 'string', 'max:255'],
                'password' => $this->passwordRules(),
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            ])->validate();

            // dd($input['passcode']);
        }
        $availabilityString = implode(',', $validator['availability']);
        // dd( $availabilityString);

        try {

            DB::beginTransaction();
            $checkEmailExist = User::where('email',   convertData($input['email']))->count();

            if ($checkEmailExist == 0) {
                if ($input['question'] == "1") {
                    $company = CompanyProfile::where('company_code', convertData($input['passcode']))->where('status', '1')->first();
                    if ($company) {

                        $person = new Person();
                        $person->fullname =  convertData($input['fullname']);
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
                        $user->name =  convertData($input['fullname']);
                        $user->email =  convertData($input['email']);
                        $user->person_id = $person->id;
                        $user->user_code = code_generator(8);
                        $user->is_admin = "0";
                        $user->status = "1";
                        $user->password = Hash::make($input['password']);
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
                        $personincharge->fullname = strtoupper(convertData($input['fullname']));
                        $personincharge->availability =convertData($availabilityString);
                        $personincharge->status = "1";
                        $personincharge->save();
                        $personincharge->code = $personincharge->id;
                        $personincharge->save();
                        // dd("here");

                        $peoplepersonincharge = new PeoplePersonInCharge();
                        $peoplepersonincharge->company_id = $company->id;
                        $peoplepersonincharge->person_id = $person->id;
                        $peoplepersonincharge->personincharge_id = $personincharge->id;
                        $peoplepersonincharge->fullname = strtoupper(convertData($input['fullname']));
                        $peoplepersonincharge->status = "1";
                        $peoplepersonincharge->save();

                        DB::commit();
                        // Auth::login($user);
                        // Auth::guard('web')->login($user);
                        // Auth::login($user);
                        // dd($user);

                        return $user;
                    } else {
                        DB::rollBack();
                        return redirect()->back()->withErrors(['passcode' => 'Invalid passcode.']);
                    }
                } else {
                    // $company = CompanyProfile::where('company_code', convertData($input['passcode']))->where('status', '1')->first();
                    // if (!$company) {

                    $current_date = Carbon::today();
                    $year = $current_date->year;
                    $day = $current_date->day;
                    $month = $current_date->month;

                    $company_exist = false;
                    $company = new CompanyProfile();
                    // $company->company_code = convertData($input['passcode']);
                    $company->company_name = convertData($input['groupname']);
                    $company->acronym = convertData($input['groupname_acronym']);
                    $company->vat_no = '-';
                    $company->email = convertData($input['email']);
                    $company->address = '-';
                    $company->contact_number = '-';
                    $company->tel_number = '-';
                    // $company->department_id =  serialize($input['add_department_multiselect']);
                    $company->status = "1";
                    $company->save();

                    $company->company_code = 'COMP' . str_pad($day . substr($year, -2) . $month .  $company->id, 6, '0', STR_PAD_LEFT);
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
                    $personIncharge->email = convertData($input['email']);
                    $personIncharge->status = '1';
                    $personIncharge->save();

                    $person = new Person();
                    $person->fullname = strtoupper(convertData($input['fullname']));
                    $person->status = "1";
                    $person->save();

                    $personHasCompanyDepartment = new PersonHasCompanyDepartment();
                    $personHasCompanyDepartment->status = "1";
                    $personHasCompanyDepartment->person_id = $person->id;
                    $personHasCompanyDepartment->company_id = $company->id;
                    $personHasCompanyDepartment->department_id = 3;
                    $personHasCompanyDepartment->save();

                    $permission = new Permission();
                    $permission->permission_code = "";
                    $permission->permission_description = convertData($input['groupname_acronym']) . "_ADMIN";
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
                    $user->name = strtoupper(convertData($input['fullname']));
                    $user->email = convertData($input['email']);
                    $user->person_id = $person->id;
                    $user->user_code = code_generator(8);
                    $user->is_admin = "1";
                    $user->status = "1";
                    $user->password = Hash::make($input['password']);
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
                    $personincharge->fullname = strtoupper(convertData($input['fullname']));
                    $personincharge->availability = convertData($availabilityString);
                    $personincharge->status = "1";
                    $personincharge->save();
                    $personincharge->code = $personincharge->id;
                    $personincharge->save();


                    $peoplepersonincharge = new PeoplePersonInCharge();
                    $peoplepersonincharge->company_id = $company->id;
                    $peoplepersonincharge->person_id = $person->id;
                    $peoplepersonincharge->personincharge_id = $personincharge->id;
                    $peoplepersonincharge->fullname = strtoupper(convertData($input['fullname']));
                    $peoplepersonincharge->status = "1";
                    $peoplepersonincharge->save();
                    DB::commit();
                    return $user;
                    $message = '追加場所を保存しました';
                    // } else {
                    //     DB::rollBack();
                    //     return redirect()->back()->withErrors(['error' => 'The group name is already exist. Please try again!']);
                    // }
                }
            } else {
                DB::rollBack();
                return redirect()->back()->withErrors(['email' => 'Email already exists.']);
            }
        } catch (\PDOException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'An error occurred. Please try again.']);
        }
    }
}

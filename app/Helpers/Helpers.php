<?php

use App\Models\Employee;
use App\Models\EmployeeHasPosition;
use App\Models\EmpPosHasPermissionAccess;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\PersonHasCompanyDepartment;
use Illuminate\Support\Facades\Hash;

function convertData($data)
{
    return htmlspecialchars(mb_strtoupper($data));
}

function generateCode($identifier, $id)
{
    $current_date = Carbon::today();
    $year = $current_date->year;
    $day = $current_date->day;
    $month = $current_date->month;

    $generate_access_code = $identifier . str_pad($day . substr($year, -2) . $month .  $id, 6, '0', STR_PAD_LEFT);
    return $generate_access_code;
}
//Code Generator
function code_generator(
    int $length = 64,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces[] = $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

function generateCodeRandom(
    int $length,
    $identifier,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces[] = $keyspace[random_int(0, $max)];
    }
    $random = strtoupper(implode('', $pieces));
    return $identifier . $random;
}

function company()
{
    $user = Auth::user();
    // $employee = Cache::remember('employee_helpers', 60*60*60, function () use ($user) {
    //     return Employee::with('employeeHasPosition.employeePositionHasPermissionAccess')->where('user_id', $user->id)->first();
    // });
    $employee = Employee::with('employeeHasPosition.employeePositionHasPermissionAccess')->where('user_id', $user->id)->first();
    // $employee_position = EmployeeHasPosition::where('employee_id',$employee->id)->first();
    // $emp_pos_has_permission_access = EmpPosHasPermissionAccess::where('employee_has_position_id',$employee_position->id)->first();
    // $permission_has_accesses = EmpPosHasPermissionAccess::where('employee_has_position_id',$employee_position->id)->first();

    if ($employee->employeeHasPosition->employeePositionHasPermissionAccess->permission_has_access_id == 1) {
        return 1;
    } else {
        $getCompany = PersonHasCompanyDepartment::select('company_id')->where('person_id', $user->person_id)->first();
        return $getCompany->company_id;
    }
}

function access_level()
{
    $user = Auth::user();
    $employee = Employee::with('employeeHasPosition.employeePositionHasPermissionAccess')->where('user_id', $user->id)->first();
    if ($employee->employeeHasPosition->employeePositionHasPermissionAccess->permission_has_access_id == 1) {
        return 1;
    } else {
        return 0;
    }
}


function getCompanyName()
{
    $user = Auth::user();
    // $getCompany = Cache::remember('get_company_helpers', 60*60*60, function () use ($user) {
    //     return PersonHasCompanyDepartment::with('companyProfile')->where('person_id', $user->person_id)->first();
    // });
    $getCompany = PersonHasCompanyDepartment::with('companyProfile')->where('person_id', $user->person_id)->first();
    return $getCompany->companyProfile->company_name;
}

function checkPassword($password)
{
    $user = Auth::user();
    if (!is_null($user)) {
        if (Hash::check($password, $user->password)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}


function getTimeStatus()
{
    $currentDateTime = Carbon::now();
    $hour = $currentDateTime->format('H');

    if ($hour >= 12) {
        return "Good Afternoon,";
    } else {
        return "Good Morning,";
    }
}

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
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $person = new Person();
        $person->status = "1";
        $person->created_at = Carbon::now();
        $person->updated_at = Carbon::now();
        $person->save();
        $personId = $person->id;

        $status = "1";

        $personHasCompanyDepartment = new PersonHasCompanyDepartment();
        $personHasCompanyDepartment->status = "1";
        $personHasCompanyDepartment->person_id = $person->id;
        $personHasCompanyDepartment->company_id = 1;
        $personHasCompanyDepartment->department_id = 1;
        $personHasCompanyDepartment->created_at = Carbon::now();
        $personHasCompanyDepartment->updated_at = Carbon::now();
        $personHasCompanyDepartment->save();

        $user  = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->person_id = $personId;
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
        $employeeHasPositions->position_id = 1;
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
        $employeePositionHasPermissionAccess->permission_has_access_id = 2;
        $employeePositionHasPermissionAccess->status = "1";
        $employeePositionHasPermissionAccess->created_at = Carbon::now();
        $employeePositionHasPermissionAccess->updated_at = Carbon::now();
        $employeePositionHasPermissionAccess->save();


        // return User::create([
        //     'name' => $input['name'],
        //     'email' => $input['email'],
        //     'person_id' => $personId,
        //     'status' =>  $status,
        //     'password' => Hash::make($input['password']),
        // ]);

        return $user;
    }
}

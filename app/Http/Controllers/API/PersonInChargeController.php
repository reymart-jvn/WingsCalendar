<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EventActivityInCharge;
use App\Models\PersonInCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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


class PersonInChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($isSuperAdmin, $companyId)
    {
        // Get the current date and the end of the current month
        $today = now();
        $startOfMonth = now()->startOfMonth();
        $customEndTime = now()->endOfDay()->setTime(23, 59, 59); 
        $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d H:i:s');

        if($isSuperAdmin == 1)
        {
            $personincharge = PersonInCharge::where('status', '1')->get();
      
            $geteventactivityofincahrgethismonth = EventActivityInCharge::with('eventsActivity2')
            ->whereHas('eventsActivity2', function ($query) use ($startOfMonth, $today) {
                // $query->whereBetween('date_time', [$startOfMonth,$today])
                //       ->where('status', '1');
                $query->where('status', '1');
            })
            ->where('status', '1')
            ->get();
        }
        else
        {
            $personincharge = PersonInCharge::where('company_id',$companyId)->where('status', '1')->get();
      
            $geteventactivityofincahrgethismonth = EventActivityInCharge::with('eventsActivity2')
            ->whereHas('eventsActivity2', function ($query) use ($startOfMonth, $today) {
                // $query->whereBetween('date_time', [$startOfMonth,$today])
                //       ->where('status', '1');
                      $query->where('status', '1');
            })
            ->where('company_id',$companyId)
            ->where('status', '1')
            ->get();
        }

       

        $data = [];
        foreach ($personincharge as $person) {
            // $personActivities = $geteventactivityofincahrgethismonth->filter(function ($activity) use ($person) {
            //     return $activity->personincharge_id == $person->id;
            // });

            
                // $resetCounterStartDate = CompanyProfile::where('company_id', $person->company_id)->first();

                $companyProfile = CompanyProfile::where('id', $person->company_id)->first();
                $resetCounterStartDate = $companyProfile->reset_counter_start_date != null
                    ? Carbon::createFromFormat('m/d/Y',  $companyProfile->reset_counter_start_date)->format('Y-m-d H:i:s')
                    : $startOfYear;

                // Filter activities for the specific person in charge based on reset_counter_start_date
                $personActivities = $geteventactivityofincahrgethismonth->filter(function ($activity) use ($person, $resetCounterStartDate, $today) {
                    // Ensure eventsActivity2 is loaded and available

                    return $activity->personincharge_id == $person->id && $activity->eventsActivity2->date_time >= $resetCounterStartDate &&
                        $activity->eventsActivity2->date_time <= $today;
                    // Return false if eventsActivity2 is not present
                });

            $data[] = [
                'id' => $person->id,
                'code' => $person->code,
                'fullname' => $person->fullname,
                'availability' => $person->availability,
                'status' => $person->status,
                'created_at' => $person->created_at,
                'updated_at' => $person->updated_at,
                'activities' => $personActivities->count()
            ];
        }


        return response()->json([
            'success'   => true,
            'data'      =>  $data,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function getLatestPersonInChargeData($isSuperAdmin, $companyId)
    {

        if($isSuperAdmin == 1)
        {
            $personincharge = PersonInCharge::where('status', '1')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        }
        else
        {
            $personincharge = PersonInCharge::where('company_id',$companyId)->where('status', '1')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        }

        if ($personincharge->isEmpty()) {
            return response()->json([
                'success'   => false,
                'data'      => [],
                'message'   => 'No Person In Charge Found'
            ], 200);
        }

        if ($personincharge->count() < 5) {
            return response()->json([
                'success'   => true,
                'data'      => $personincharge,
                'message'   => 'Retrieved successfully, but less than 5 person in charge found'
            ], 200);
        }

        return response()->json([
            'success'   => true,
            'data'      => $personincharge,
            'message'   => 'Retrieved successfully'
        ], 200);
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
        try {
            DB::beginTransaction();
            $checkEmailExist = User::where('email',  $request['email'])->count();
       
            if ($checkEmailExist == 0) {
    
                    $person = new Person();
                    $person->fullname = $request['fullname'];
                    $person->status = "1";
                    $person->created_at = Carbon::now();
                    $person->updated_at = Carbon::now();
                    $person->save();
              
                   
                    $personHasCompanyDepartment = new PersonHasCompanyDepartment();
                    $personHasCompanyDepartment->status = "1";
                    $personHasCompanyDepartment->person_id = $person->id;
                    $personHasCompanyDepartment->company_id = $request['company'];
                    $personHasCompanyDepartment->department_id = 3;
                    $personHasCompanyDepartment->created_at = Carbon::now();
                    $personHasCompanyDepartment->updated_at = Carbon::now();
                    $personHasCompanyDepartment->save();
                 

                    $user  = new User();
                    $user->name = strtoupper(convertData($request['fullname']));
                    $user->email = $request['email'];
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
                    $employeePositionHasPermissionAccess->permission_has_access_id = 2;
                    $employeePositionHasPermissionAccess->status = "1";
                    $employeePositionHasPermissionAccess->created_at = Carbon::now();
                    $employeePositionHasPermissionAccess->updated_at = Carbon::now();
                    $employeePositionHasPermissionAccess->save();

                    $personincharge = new PersonInCharge;
                    $personincharge->company_id = $request['company'];
                    $personincharge->code = '';
                    $personincharge->fullname = strtoupper(convertData($request['fullname']));
                    $personincharge->availability = convertData($request['availability']);
                    $personincharge->status = "1";
                    $personincharge->save();
                    $personincharge->code = $personincharge->id;
                    $personincharge->save();

                    $peoplepersonincharge = new PeoplePersonInCharge();
                    $peoplepersonincharge->company_id = $request['company'];
                    $peoplepersonincharge->person_id = $person->id;
                    $peoplepersonincharge->personincharge_id = $personincharge->id;
                    $peoplepersonincharge->fullname = strtoupper(convertData($request['fullname']));
                    $peoplepersonincharge->status = "1";
                    $peoplepersonincharge->save();

                    // dd("here");

                    $message = '追加場所を保存しました';
             
            } else {
                $message = 'Email is already exist. Please try again. Thank you!';
            }


            DB::commit();
            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error hereeeeeee!', 'messages' => 'エラー' ));
        }
        // $personincharge = new PersonInCharge;
        // try {
        //     DB::beginTransaction();
        //     $personincharge->code = '';
        //     $personincharge->company_id = $request['company'];
        //     $personincharge->fullname = strtoupper(convertData($request['fullname']));
        //     $personincharge->availability = convertData($request['availability']);
        //     $personincharge->status = "1";
        //     $personincharge->save();
        //     $personincharge->code = $personincharge->id;
        //     $personincharge->save();
        //     $message = '追加場所を保存しました';
        //     DB::commit();

        //     return response()->json(array('success' => true, 'messages' => $message));
        // } catch (\PDOException $e) {
        //     DB::rollBack();
        //     return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
        // }
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
    public function update(Request $request)
    {
        $personincharge = PersonInCharge::findOrFail(intval($request['id']));

        try {
            DB::beginTransaction();
            $personincharge->fullname = strtoupper(convertData($request['fullname']));
            $personincharge->availability = convertData($request['availability']);
            $personincharge->save();
            $message = 'Record successfully updated!';
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $personincharge = PersonInCharge::findOrFail(intval($request['id']));

        try {
            DB::beginTransaction();
            $personincharge->status = "0";
            $personincharge->save();
            $message = 'Record successfully deleted!';
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
        }
    }
}

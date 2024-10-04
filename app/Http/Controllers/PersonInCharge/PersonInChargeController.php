<?php

namespace App\Http\Controllers\PersonInCharge;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PersonInCharge;
use Illuminate\Support\Facades\DB;
use App\Models\EventActivityInCharge;
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
use Kreait\Firebase\Database\Transaction;
use Illuminate\Support\Facades\Validator;

class PersonInChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'person_in_charge.manage-person-in-charge',
            [
                'title' => "Person Incharge Management",
                'subtitle' => "Person Incharge Management",
                'table_title' => "担当者一覧",
                'module' => "",
                'label' => "A comprehensive document outlining key individuals responsible for various aspects of an event. It details roles such as event coordinators, logistics managers, technical support leads, and communication officers, ensuring clear accountability and smooth execution throughout the event's lifecycle."
            ]
        );
    }

    public function view(Request $request)
    {
        $columns = array(
            0 => 'code',
            1 => 'company',
            2 => 'fullname',
        );


        $today = now()->format('Y-m-d H:i:s');
        $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d H:i:s');

        // dd($startOfYear);



        if (access_level() == 1) {
            $geteventactivityofincahrgethismonth = EventActivityInCharge::with('eventsActivity2')
                // ->whereHas('eventsActivity2', function ($query) use ($startOfMonth, $today) {
                //     $query->whereBetween('date_time', [$startOfMonth, $today])->where('status', '1');
                // })
                ->where('status', '1')
                ->get();
        } else {
            $geteventactivityofincahrgethismonth = EventActivityInCharge::with('eventsActivity2')
                // ->whereHas('eventsActivity2', function ($query) use ($startOfMonth, $today) {
                //     $query->whereBetween('date_time', [$startOfMonth, $today])
                //         ->where('status', '1');
                // })
                ->where('company_id', company())
                ->where('status', '1')
                ->get();
        }


        if (is_super_admin()) {
            $totalData = PersonInCharge::with('company')->where('status', '1')->count();
            $query = PersonInCharge::with('company')->where('status', '1');
        } else {
            $totalData = PersonInCharge::with('company')->where('company_id', company())->where('status', '1')->count();
            $query = PersonInCharge::with('company')->where('company_id', company())->where('status', '1');
        }

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $person = with(clone $query)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $person = with(clone $query)->where('fullname', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = with(clone $query)->count();
        }
        $btnDelete = "";
        $btnUpdate = "";
        $data = array();
        if (!empty($person)) {
            foreach ($person as $person) {
                if (Gate::allows('permission', 'deletePersonInCharge')) {
                    $btnDelete = '<button onclick="remove(' . $person->id . ')" type="button" class="btn btn-danger btn-icon-text p-2" fdprocessedid="613cnk">
                                                                             
                           消去
                         </button>';
                }

                if (Gate::allows('permission', 'updatePersonInCharge')) {
                    $btnUpdate = '<button type="button" onclick="update(' . $person->id . ')" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">
                                                                                
                             アップデート
                         </button>';
                }

                if ($person->status == '1') {
                    $status = '<span class="badge badge-success">アクティブ</span>';
                } else {
                    $status = '<span class="badge badge-danger">非アクティブ</span>';
                }


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

                // dd($startOfMonth);

                $buttons = $btnUpdate . " " . $btnDelete;
                $nestedData['code'] = $person->code;
                $nestedData['fullname'] = $person->fullname;
                $nestedData['company'] = $person->company->acronym;
                $nestedData['availability'] = $person->availability;
                $nestedData['total_incharge_this_month'] = $personActivities->count();
                $nestedData['status'] = $status;
                $nestedData['actions'] = $buttons;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return json_encode($json_data);
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

        if (is_super_admin() == true) {
            $input = $request->only([
                'add_email',
                'add_fullname',
                'add_company',
                'add_availability'
            ]);

            // Validate inputs
            $validator = Validator::make($input, [
                'add_email' => 'required|email|unique:users,email',
                'add_fullname' => 'required|string|max:255',
                'add_company' => 'required|integer|exists:company_profiles,id',
                // 'add_availability' => 'required|string|max:255',
                'add_availability' => ['required', 'array'], // Ensures availability is present and is an array
                'add_availability.*' => ['string', 'in:月曜日,火曜日,水曜日,木曜日,金曜日,土曜日,日曜日'],
            ]);
        } else {
            $input = $request->only([
                'add_email',
                'add_fullname',
                'add_availability'
            ]);

            // Validate inputs
            $validator = Validator::make($input, [
                'add_email' => 'required|email|unique:users,email',
                'add_fullname' => 'required|string|max:255',
                // 'add_availability' => 'required|string|max:255',
                'add_availability' => ['required', 'array'], // Ensures availability is present and is an array
                'add_availability.*' => ['string', 'in:月曜日,火曜日,水曜日,木曜日,金曜日,土曜日,日曜日'],
            ]);
        }


        $availabilityString = implode(',', $input['add_availability']);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation error!',
                'messages' => $validator->errors()
            ]);
        }

        DB::beginTransaction();
        try {
            $company_id = is_super_admin() == true ? convertData($request['add_company']) : company();
            $checkEmailExist = User::where('email',  convertData($request['add_email']))->count();
            $email_exist = false;
            if ($checkEmailExist == 0) {


                $person = new Person();
                $person->fullname = strtoupper(convertData($request['add_fullname']));
                $person->status = "1";
                $person->save();


                $personHasCompanyDepartment = new PersonHasCompanyDepartment();
                $personHasCompanyDepartment->status = "1";
                $personHasCompanyDepartment->person_id = $person->id;
                $personHasCompanyDepartment->company_id =   $company_id;
                $personHasCompanyDepartment->department_id = 3;
                $personHasCompanyDepartment->save();


                $user  = new User();
                $user->name = strtoupper(convertData($request['add_fullname']));
                $user->email = $request['add_email'];
                $user->person_id = $person->id;
                $user->user_code = code_generator(8);
                $user->is_admin = "0";
                $user->status = "1";
                $user->password = Hash::make('secret123');
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
                $employeePositionHasPermissionAccess->permission_has_access_id = 3;
                $employeePositionHasPermissionAccess->status = "1";
                $employeePositionHasPermissionAccess->save();

                $personincharge = new PersonInCharge;
                $personincharge->company_id = $company_id;
                $personincharge->code = '';
                $personincharge->fullname = strtoupper(convertData($request['add_fullname']));
                $personincharge->availability = convertData($availabilityString);
                $personincharge->status = "1";
                $personincharge->save();
                $personincharge->code = $personincharge->id;
                $personincharge->save();

                $peoplepersonincharge = new PeoplePersonInCharge();
                $peoplepersonincharge->company_id = $company_id;
                $peoplepersonincharge->person_id = $person->id;
                $peoplepersonincharge->personincharge_id = $personincharge->id;
                $peoplepersonincharge->fullname = strtoupper(convertData($request['add_fullname']));
                $peoplepersonincharge->status = "1";
                $peoplepersonincharge->save();

                $company = CompanyProfile::findOrFail($company_id);
                $company->reset_counter_start_date = Carbon::now();
                $company->save();

                // dd("here");

                $message = '追加場所を保存しました';
            } else {
                $email_exist = true;
                $message = '電子メールはすでに存在します。もう一度試してください。ありがとう！';
            }


            DB::commit();
            return response()->json(array('success' => true, 'email_exist' => $email_exist, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error hereeeeeee!', 'messages' => 'エラー'));
        }
    }

    public function filterByCompany(Request $request)
    {
        $columns = array(
            0 => 'code',
            1 => 'company',
            2 => 'fullname',
        );


        $today = now()->format('Y-m-d H:i:s');
        $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d H:i:s');
        $customEndTime = now()->endOfDay()->setTime(23, 59, 59);

        if (access_level() == 1) {
            $geteventactivityofincahrgethismonth = EventActivityInCharge::with('eventsActivity2')
                // ->whereHas('eventsActivity2', function ($query) use ($startOfMonth, $today) {
                //     $query->whereBetween('date_time', [$startOfMonth, $today])
                //         ->where('status', '1');
                // })
                ->where('company_id', convertData($request['filter_company_id']))
                ->where('status', '1')
                ->get();
        } else {
            $geteventactivityofincahrgethismonth = EventActivityInCharge::with('eventsActivity2')
                // ->whereHas('eventsActivity2', function ($query) use ($startOfMonth, $today) {
                //     $query->whereBetween('date_time', [$startOfMonth, $today])
                //         ->where('status', '1');
                // })
                ->where('company_id', company())
                ->where('status', '1')
                ->get();
        }



        if (is_super_admin()) {
            $totalData = PersonInCharge::with('company')->where('company_id', convertData($request['filter_company_id']))->where('status', '1')->count();
            $query = PersonInCharge::with('company')->where('company_id', convertData($request['filter_company_id']))->where('status', '1');
        } else {
            $totalData = PersonInCharge::with('company')->where('company_id', company())->where('status', '1')->count();
            $query = PersonInCharge::with('company')->where('company_id', company())->where('status', '1');
        }
        // dd($query->get());

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $person = with(clone $query)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $person = with(clone $query)->where('fullname', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = with(clone $query)->count();
        }
        $btnDelete = "";
        $btnUpdate = "";
        $data = array();
        if (!empty($person)) {
            foreach ($person as $person) {
                if (Gate::allows('permission', 'deletePersonInCharge')) {
                    $btnDelete = '<button onclick="remove(' . $person->id . ')" type="button" class="btn btn-danger btn-icon-text p-2" fdprocessedid="613cnk">
                                                                             
                           消去
                         </button>';
                }

                if (Gate::allows('permission', 'updatePersonInCharge')) {
                    $btnUpdate = '<button type="button" onclick="update(' . $person->id . ')" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">
                                                                                
                             アップデート
                         </button>';
                }

                if ($person->status == '1') {
                    $status = '<span class="badge badge-success">アクティブ</span>';
                } else {
                    $status = '<span class="badge badge-danger">非アクティブ</span>';
                }

                // $personActivities = $geteventactivityofincahrgethismonth->filter(function ($activity) use ($person) {
                //     return $activity->personincharge_id == $person->id;
                // });


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

                $buttons = $btnUpdate . " " . $btnDelete;
                $nestedData['code'] = $person->code;
                $nestedData['fullname'] = $person->fullname;
                $nestedData['company'] = $person->company->acronym;
                $nestedData['availability'] = $person->availability;
                $nestedData['total_incharge_this_month'] = $personActivities->count();
                $nestedData['status'] = $status;
                $nestedData['actions'] = $buttons;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return json_encode($json_data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $person = PersonInCharge::where('status', '1')->findOrFail($id);
        return response()->json(array('success' => true, 'messages' => 'Record successfully retrieved!', 'data' => $person));
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

        $input = $request->only([

            'update_fullname',
            'update_availability'
        ]);

        // Validate inputs
        $validator = Validator::make($input, [
            'update_fullname' => 'required|string|max:255',
            // 'update_availability' => 'required|string|max:255',
            'update_availability' => ['required', 'array'], // Ensures availability is present and is an array
            'update_availability.*' => ['string', 'in:月曜日,火曜日,水曜日,木曜日,金曜日,土曜日,日曜日'],
        ]);

        $availabilityString = implode(',', $input['update_availability']);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation error!',
                'messages' => $validator->errors()
            ]);
        }

        $person = PersonInCharge::findOrFail($request['update_id']);
        $check_if_exist = PersonInCharge::whereNot('id', $person->id)->where('fullname', strtoupper(convertData($request['update_fullname'])))->where('status', '1')->first();

        try {
            if (!$check_if_exist) {
                DB::beginTransaction();
                $person->company_id = is_super_admin() == true ? $request['update_company'] : company();
                $person->fullname = strtoupper(convertData($request['update_fullname']));
                $person->availability = convertData($availabilityString);
                $person->save();
                $message = 'Record successfully updated!';
                DB::commit();

                return response()->json(array('success' => true, 'messages' => $message));
            } else {
                DB::rollBack();
                return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => '担当者はすでに存在します！'));
            }
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
    public function destroy($id)
    {
        $person = PersonInCharge::findOrFail($id);

        try {
            DB::beginTransaction();
            $person->status = "0";
            $person->save();
            $message = 'Record successfully deleted!';
            DB::commit();
            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
        }
    }
}

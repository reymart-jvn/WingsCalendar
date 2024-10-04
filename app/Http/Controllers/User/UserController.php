<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ComDepHasEmpPos;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\CompanyProfile;
use App\Models\CompanyHasDepartment;
use App\Models\DepartmentHasPosition;
use App\Models\Employee;
use App\Models\EmployeeHasPosition;
use App\Models\EmpPosHasPermissionAccess;
use App\Models\PermissionHasAccess;
use App\Models\Person;
use App\Models\User;
use App\Models\PersonHasCompanyDepartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserController extends Controller
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
    public function passwordChange()
    {
        return view(
            'user.password-change',
            [
                'title' => "Account Management",
                'subtitle' => "Account Management",
                'table_title' => "List of Users",
                'module' => "",
                'label' => "アカウント パスワードの変更は、アカウントのセキュリティを強化し、権限のない第三者が個人情報や機密情報にアクセスするのを防ぐための予防策です。定期的なパスワード更新は、サイバーセキュリティの要素に不可欠であり、ユーザーと組織の両方にとってより安全な環境を促進します。"
            ]
        );
    }
 

    public function  shuttlewiser_privacy()
    {
        return view(
            'shuttlewiser-privacy-policy.privacy'
        );
    }


    public function manage_users()
    {
        return view(
            'user.manage-users',
            [
                'title' => "アカウントマネジメント",
                'subtitle' => "アカウントマネジメント",
                'table_title' => "ユーザーリスト",
                'module' => "",
                'label' => ""
            ]
        );
    }

    public function manage_restore_account()
    {
        return view(
            'user.manage-restore-account',
            [
                'title' => "アカウントの初期化",
                'subtitle' => "アカウントの初期化",
                'table_title' => "アカウントの初期化",
                'module' => "",
                'label' => ""
            ]
        );
    }

    public function manage_reset_password()
    {
        return view(
            'user.manage-reset-password',
            [
                'title' => "ユーザーパスワードリセット",
                'subtitle' => "ユーザーパスワードリセット",
                'table_title' => "ユーザーパスワードリセット",
                'module' => "",
                'label' => ""
            ]
        );
    }

    public function add_new_user()
    {
        return view(
            'user.add-new-user',
            [
                'title' => "新しいユーザーを追加",
                'subtitle' => "新しいユーザーを追加",
                'table_title' => "新しいユーザーを追加",
                'module' => "",
                'label' => ""
            ]
        );
    }
    public function getAllCompany(Request $request)
    {
        if (company() == 1) {
            $company = CompanyProfile::where('status', '1')->get();
        } else {
            $company = CompanyProfile::where('id', company())->where('status', '1')->get();
        }

        return response()->json($company);
    }
    public function getDepartment(Request $request)
    {
        $department_list = CompanyHasDepartment::with(['departmentsInfo', 'departmentsInfo.departmentHasPosition.position'])->where('status', '1')->where('company_id', $request['company_id'])->get();
        // $position_list = DepartmentHasPosition::with(['position'])->where('status', '1')->where('department_id', $department_list->department_id)->get();
        //    dd( $department_list);
        return response()->json($department_list);
    }

    public function getPosition(Request $request)
    {
        
        $position_list = DepartmentHasPosition::with('position', 'department')->where('status', '1')->where('department_id', $request['department_id'])->get();
        // dd($position_list);
        return response()->json($position_list);
    }


    public function getAccess(Request $request)
    {
        $access_list = PermissionHasAccess::with('permission', 'access')->where('status', '1')->where('position_id', $request['position_id'])->where('company_id', $request['company_id'])->where('department_id', $request['department_id'])->get();
        // dd($access_list);
        return response()->json($access_list);
    }

    public function findAllAccount(Request $request)
    {
        $btnDelete = "";
        $btnUpdate = "";

        $columns = array(
            0 => 'people.fullname',
        );
        if (company() == 1) {
            $totalData = Person::where('status', '1')->count();
            $query = Person::with(
                'personCompanyDepartment.companyProfile',
                'personCompanyDepartment.departmentsInfo',
                'user',
                'user.employee',
                'user.employee.employeeHasPosition.position',
                'user.employee.employeeHasPosition.employeePositionHasPermissionAccess.permissionHasAccess.permission',
                'user.employee.employeeHasPosition.employeePositionHasPermissionAccess.permissionHasAccess.access'
            )
                ->where('status', '1')->whereHas('user', function ($query) {
                    $query->where(DB::raw("id"), "!=", Auth::user()->id);
                });
        } else {
            $totalData = Person::where('status', '1')->count();
            $query = Person::with(
                'personCompanyDepartment.companyProfile',
                'personCompanyDepartment.departmentsInfo',
                'user',
                'user.employee',
                'user.employee.employeeHasPosition.position',
                'user.employee.employeeHasPosition.employeePositionHasPermissionAccess.permissionHasAccess.permission',
                'user.employee.employeeHasPosition.employeePositionHasPermissionAccess.permissionHasAccess.access'
            )
                ->where('status', '1')->whereHas('personCompanyDepartment.companyProfile', function ($query) {
                    $query->where(DB::raw("id"), company());
                })->whereHas('user', function ($query) {
                    $query->where(DB::raw("id"), "!=", Auth::user()->id);
                });
        }

        // dd($query);
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $user = with(clone $query)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $user = with(clone $query)->where('people.fullname', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = with(clone $query)->count();
        }

        $data = array();
        if (!empty($user)) {
            foreach ($user as $user) {

                if (Gate::allows('permission', 'deleteAccount'))
                {
                $btnDelete = '<button onclick="removeUserRecord(' . $user->id . ')" type="button" class="btn btn-danger btn-icon-text p-2" fdprocessedid="613cnk">                                                 
                         削除
                        </button>';
                }
                if (Gate::allows('permission', 'updateAccount'))
                {
                    $btnUpdate = '<button type="button" onclick="update(' . $user->id . ')" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">                                                 
                    アップデート
                </button>';
                }
               

                $btnView = '<button type="button" onclick="view(' . $user->id . ')" class="btn btn-warning btn-icon-text p-2" fdprocessedid="613cnk">
                                                                         
                表示
                    </button>';


                if ($user->status == '1') {
                    $status = '<span class="badge badge-success">アクティブ</span>';
                } else {
                    $status = '<span class="badge badge-danger">休止</span>';
                }

         

            

             


                $buttons = $btnView . " " . $btnUpdate . " " . $btnDelete;

                // $nestedData['arr'] =  unserialize($user->user->employee->employeeHasPosition->employeePositionHasPermissionAccess->permissionHasAccess->access->access_list);
                $nestedData['fullname'] = $user->fullname;
                // $nestedData['dob'] = $user->date_of_birth == null ? "-" : $user->date_of_birth;
                // $nestedData['address'] = $user->home_address == null ? "-" : $user->home_address;
                $nestedData['email'] = $user->user->email;
             
                $nestedData['level_access'] =  $user->user->employee->employeeHasPosition->employeePositionHasPermissionAccess->permissionHasAccess->permission->permission_description;
          
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

    public function findAllAccountResetPassword(Request $request)
    {
        $columns = array(
            0 => 'people.fullname',
        );

        if (company() == 1) {
            $totalData = Person::where('status', '1')->count();
            $query = Person::with('personCompanyDepartment.companyProfile', 'personCompanyDepartment.departmentsInfo', 'user',)->where('status', '1');
        } else {
            $totalData = Person::with('personCompanyDepartment.companyProfile', 'personCompanyDepartment.departmentsInfo', 'user',)->where('status', '1')->whereHas('personCompanyDepartment.companyProfile', function ($query) {
                $query->where(DB::raw("id"), company());
            })->count();

            $query = Person::with('personCompanyDepartment.companyProfile', 'personCompanyDepartment.departmentsInfo', 'user',)->where('status', '1')->whereHas('personCompanyDepartment.companyProfile', function ($query) {
                $query->where(DB::raw("id"), company());
            });
        }


        // $totalData = Person::where('status', '1')->count();
        // $query = Person::with('personCompanyDepartment.companyProfile', 'personCompanyDepartment.departmentsInfo', 'user',)->where('status', '1');
        // dd($query);
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $user = with(clone $query)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $user = with(clone $query)->where('people.fullname', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = with(clone $query)->count();
        }

        $data = array();
        if (!empty($user)) {
            foreach ($user as $user) {

                $btnReset = '<button onclick="resetPassword(' . $user->id . ')" type="button" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">
                                                                        
                パスワードリセット
                        </button>';


                $btnView = '<button type="button" onclick="view(' . $user->id . ')" class="btn btn-warning btn-icon-text p-2" fdprocessedid="613cnk">
                                                        
                表示
                    </button>';


                if ($user->status == '1') {
                    $status = '<span class="badge badge-success">アクティブ</span>';
                } else {
                    $status = '<span class="badge badge-danger">休止</span>';
                }

                $buttons = $btnView . " " . $btnReset;
                // $buttons = '<button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" type="button">Update</button> <button class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded" type="button">Delete</button>';
                $nestedData['fullname'] = $user->fullname;
                $nestedData['email'] = $user->user == null ? "-" : $user->user->email;
                $nestedData['company'] = $user->personCompanyDepartment == null ? "-" : $user->personCompanyDepartment->companyProfile->company_name;
                $nestedData['department'] =  $user->personCompanyDepartment == null ? "-" : $user->personCompanyDepartment->departmentsInfo->name;
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

    // public function findAllRestoreAccount(Request $request)
    // {
    //     $columns = array(
    //         0 => 'people.first_name',
    //     );

    //     if (company() == 1) {
    //         // $totalData = Person::where('status', '0')->count();
    //         // $query = Person::with('personCompanyDepartment.companyProfile', 'personCompanyDepartment.departmentsInfo', 'user',)->where('status', '0');
    //         $totalData = User::withTrashed()->where('status', '0')->count();
    //         $query = User::withTrashed()->where('status', '0');
    //     } else {
    //         $totalData = Person::where('status', '0')->count();
    //         $query = Person::with('personCompanyDepartment.companyProfile', 'personCompanyDepartment.departmentsInfo', 'user',)->where('status', '0');
    //     }

    //     // $totalData = Person::with('personCompanyDepartment.companyProfile', 'personCompanyDepartment.departmentsInfo', 'user',)->where('status', '0')
    //     //     ->whereHas('personCompanyDepartment.companyProfile', function ($query) {
    //     //         $query->where(DB::raw("id"), company());
    //     //     })->count();
    //     // $query = Person::with('personCompanyDepartment.companyProfile', 'personCompanyDepartment.departmentsInfo', 'user',)->where('status', '0')
    //     //     ->whereHas('personCompanyDepartment.companyProfile', function ($query) {
    //     //         $query->where(DB::raw("id"), company());
    //     //     });
    //     // dd($query);
    //     $totalFiltered = $totalData;

    //     $limit = $request->input('length');
    //     $start = $request->input('start');
    //     $order = $columns[$request->input('order.0.column')];
    //     $dir = $request->input('order.0.dir');

    //     if (empty($request->input('search.value'))) {
    //         $user = with(clone $query)->offset($start)
    //             ->limit($limit)
    //             ->orderBy($order, $dir)
    //             ->get();
    //     } else {
    //         $search = $request->input('search.value');

    //         $user = with(clone $query)->where('people.first_name', 'LIKE', "%{$search}%")
    //             ->offset($start)
    //             ->limit($limit)
    //             ->orderBy($order, $dir)
    //             ->get();
    //         $totalFiltered = with(clone $query)->count();
    //     }

    //     $data = array();
    //     if (!empty($user)) {
    //         foreach ($user as $user) {

    //             $btnRestore = '<button onclick="restoreAccount(' . $user->id . ')" type="button" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">
                                                                            
    //                      Restore
    //                     </button>';


    //             // $btnView = '<button type="button" onclick="view(' . $user->id . ')" class="btn btn-outline-warning btn-icon-text" fdprocessedid="613cnk">
    //             //         <i class="mdi mdi-eye"></i>                                                    
    //             //         View
    //             //     </button>';


    //             if ($user->status == '1') {
    //                 $status = '<span class="badge badge-success">Active</span>';
    //             } else {
    //                 $status = '<span class="badge badge-danger">Inactive</span>';
    //             }

    //             $buttons = $btnRestore;
    //             // $buttons = '<button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" type="button">Update</button> <button class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded" type="button">Delete</button>';
    //             $nestedData['fullname'] = $user->name;
    //             $nestedData['email'] = $user->email;
    //             $nestedData['status'] = $status;
    //             $nestedData['actions'] = $buttons;
    //             $data[] = $nestedData;
    //         }
    //     }

    //     $json_data = array(
    //         "draw"            => intval($request->input('draw')),
    //         "recordsTotal"    => intval($totalData),
    //         "recordsFiltered" => intval($totalFiltered),
    //         "data"            => $data
    //     );

    //     return json_encode($json_data);
    // }


    public function findAllRestoreAccount(Request $request)
    {
        $columns = array(
            0 => 'fullname',
        );
        if (company() == 1) {
            $totalData = Person::where('status', '0')->count();
            $query = Person::with('personCompanyDepartment.companyProfile', 'personCompanyDepartment.departmentsInfo', 'user',)->where('status', '0');
        } else {
            $totalData = Person::with('personCompanyDepartment.companyProfile', 'personCompanyDepartment.departmentsInfo', 'user',)->where('status', '0')->whereHas('personCompanyDepartment.companyProfile', function ($query) {
                $query->where(DB::raw("id"), company());
            })->count();

            $query = Person::with('personCompanyDepartment.companyProfile', 'personCompanyDepartment.departmentsInfo', 'user',)->where('status', '0')->whereHas('personCompanyDepartment.companyProfile', function ($query) {
                $query->where(DB::raw("id"), company());
            });
        }
        // $totalData = User::withTrashed()->where('status', '0')->count();
        // $query = User::withTrashed()->where('status', '0');
        // dd($query->get());
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $user = with(clone $query)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $user = with(clone $query)->where('fullname', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = with(clone $query)->count();
        }

        $data = array();
        if (!empty($user)) {
            foreach ($user as $user) {

                $btnRestore = '<button onclick="restoreAccount(' . $user->user->id . ')" type="button" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">
                                                                            
                戻る
                        </button>';


                // $btnView = '<button type="button" onclick="view(' . $user->id . ')" class="btn btn-outline-warning btn-icon-text" fdprocessedid="613cnk">
                //         <i class="mdi mdi-eye"></i>                                                    
                //         View
                //     </button>';


                if ($user->status == '1') {
                    $status = '<span class="badge badge-success">アクティブ</span>';
                } else {
                    $status = '<span class="badge badge-danger">休止</span>';
                }

                $buttons = $btnRestore;
                // $buttons = '<button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" type="button">Update</button> <button class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded" type="button">Delete</button>';
                $nestedData['fullname'] = $user->name;
                $nestedData['email'] = $user->user->email;
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

    public function saveNewUser(Request $request)
    {

        $current_date = Carbon::today();
        $year = $current_date->year;
        $day = $current_date->day;
        $month = $current_date->month;

        $person = new Person;
        $user = new User;
        $personHasCompanyDepartment = new PersonHasCompanyDepartment;
        $employee = new Employee;
        $employeeHasPosition = new EmployeeHasPosition;
        $comDeptHasEmpPos = new ComDepHasEmpPos;

        $empPositionHasPermissionAccess = new EmpPosHasPermissionAccess;

        $checkEmailExist = User::where('email', $request['email'])->count();

        if ($checkEmailExist == 0) {
            try {
                DB::beginTransaction();
                $person->fullname = convertData($request['fullname']);
                $person->home_address = convertData($request['home_address']);
                $person->gender = convertData($request['sex']);
                $person->date_of_birth = convertData($request['date_of_birth']);
                $person->status = "1";
                $person->save();

                $personHasCompanyDepartment->person_id =  $person->id;
                $personHasCompanyDepartment->company_id =  $request['company_name'];
                $personHasCompanyDepartment->department_id =  $request['department'];
                $personHasCompanyDepartment->status = "1";
                $personHasCompanyDepartment->save();

                $user->name = $request['fullname']; // NEW
                $user->email = $request['email'];
                $user->user_code = code_generator(8);
                $user->person_id =  $person->id;
                $user->is_admin ="1"; // NEW
                $user->status = "1";
                $user->password =  $request['access'] == "1" ? Hash::make('admin123') : Hash::make('secret123'); // NEW
                $user->save();

                // $employee->employee_code = $request['employee_code'];
                $employee->user_id =  $user->id;
                $employee->person_has_company_department_id =  $personHasCompanyDepartment->id;
                $employee->status = "1";
                $employee->save();

                $employeeHasPosition->employee_id = $employee->id;
                $employeeHasPosition->position_id = $request['position'];
                $employeeHasPosition->status = "1";
                $employeeHasPosition->save();

                $comDeptHasEmpPos->person_has_company_department_id = $personHasCompanyDepartment->id;
                $comDeptHasEmpPos->employee_has_position_id = $employeeHasPosition->id;
                $comDeptHasEmpPos->status = "1";
                $comDeptHasEmpPos->save();

                $empPositionHasPermissionAccess->employee_has_position_id =  $employeeHasPosition->id;
                $empPositionHasPermissionAccess->permission_has_access_id =  $request['access'];
                $empPositionHasPermissionAccess->status =  "1";
                $empPositionHasPermissionAccess->save();


                $message = '追加場所を保存しました';

                DB::commit();

                return response()->json(array('success' => true, 'messages' => $message));
            } catch (\PDOException $e) {
                DB::rollBack();
                return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' =>"エラー"));
            }
        } else {
            
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => "Email is already exists. Please try again!"));
        }
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The 旧パスワード
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "旧パスワード Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }

    public function changePassword(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail(Auth::user()->id);
            $user->password = Hash::make($request['new_password']);
            $user->save();

            $message = 'Record successfully Updated!';
            DB::commit();
            //action_log('Department mngt', $action, array_merge(['id' => $department->id], $changes));

            Auth::logout();

            return redirect()->route('login')->with('success', 'Password changed successfully. Please log in again.');

            // return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            $message = 'Something went wrong!';
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => $message));
        }
    }

    public function updateUserRecord(Request $request)
    {

        $person = Person::findOrFail($request['update_id']);
        $user =  User::where('person_id', $person->id)->first();
        $personHasCompanyDepartment = PersonHasCompanyDepartment::where('person_id', $person->id)->first();
        $employee = Employee::where('user_id', $user->id)->first();
        $employeeHasPosition = EmployeeHasPosition::where('employee_id', $employee->id)->first();
        $empPositionHasPermissionAccess = EmpPosHasPermissionAccess::where('employee_has_position_id', $employeeHasPosition->id)->first();
        $checkEmailExist = User::where('email', $request['email'])->first();

        try {
            DB::beginTransaction();
            // $person->first_name = convertData($request['firstname']);
            // $person->last_name = convertData($request['lastname']);
            // $person->middle_name = convertData($request['middlename']);
            // $person->affiliation = convertData($request['suffix']);
            // $person->region_id = $request['region'];
            // $person->region = $request['txtRegion'];
            // $person->province = $request['province'];
            // $person->city_mun = $request['city'];
            // $person->barangay = $request['barangay'];
            // $person->zip_code = "";
            // $person->home_address = convertData($request['home_address']);
            // $person->gender = convertData($request['sex']);
            // $person->date_of_birth = convertData($request['date_of_birth']);
            // $person->civil_status = convertData($request['civil_status']);
            // $person->telephone_number = convertData($request['contact']);
            // $person->religion = convertData($request['religion']);
            // $person->save();

            $person->fullname = convertData($request['fullname']);
            $person->region_id = $request['region'];
            $person->region = $request['txtRegion'];
            $person->province = $request['province'];
            $person->city_mun = $request['city'];
            $person->barangay = $request['barangay'];
            $person->zip_code = "";
            $person->home_address = convertData($request['home_address']);
            $person->gender = convertData($request['sex']);
            $person->date_of_birth = convertData($request['date_of_birth']);
            $person->save();

            $personHasCompanyDepartment->company_id =  $request['company_name'];
            $personHasCompanyDepartment->department_id =  $request['department'];
            $personHasCompanyDepartment->save();

            $employee->employee_code = $request['employee_code'];
            $employee->save();

            $employeeHasPosition->position_id =   $request['position'];
            $employeeHasPosition->save();

            $empPositionHasPermissionAccess->permission_has_access_id =  $request['access'];
            $empPositionHasPermissionAccess->save();


            // if ($user->email != $request['email']) {
            //     $user->name = $request['firstname'] . " " . $request['lastname'];
            //     $user->save();
            // } else {
            //     if ($checkEmailExist) {
            //         DB::rollBack();
            //         return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => "Email is already exists. Please try again!"));
            //     } else {
            //         $user->name = $request['firstname'] . " " . $request['lastname'];
            //         $user->name = $request['email'];
            //         $user->save();
            //     }
            // }

            if ($user->email != $request['email']) {
                if ($checkEmailExist == 0) {
                    $user->name = convertData($request['fullname']);
                    $user->email = $request['email'];
                    $user->save();
                } else {
                    DB::rollBack();
                    return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => "Email is already exists. Please try again!"));
                }
            }

            $message = 'Record successfully Updated!';
            DB::commit();
            //action_log('Department mngt', $action, array_merge(['id' => $department->id], $changes));

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => "エラー"));
        }
    }

    public function removeUserRecord(Request $request, $id)
    {
        $person = Person::where('status', '1')->findOrFail($id);
        $user =  User::where('person_id', $person->id)->first();
        $personHasCompanyDepartment = PersonHasCompanyDepartment::where('person_id', $person->id)->first();
        $employee = Employee::where('user_id', $user->id)->first();
        $employeeHasPosition = EmployeeHasPosition::where('employee_id', $employee->id)->first();
        $empPositionHasPermissionAccess = EmpPosHasPermissionAccess::where('employee_has_position_id', $employeeHasPosition->id)->first();

        $message = '';

        try {
            DB::beginTransaction();
            if ($person->status == '1') {
                $person->status = '0';
                $user->status = '0';
                $personHasCompanyDepartment->status = '0';
                $employee->status = '0';
                $employeeHasPosition->status = '0';
                $empPositionHasPermissionAccess->status = '0';
                $message = 'Record successfully Deleted!';
                $action = 'DELETED';
            }

            $person->save();
            $user->save();
            $personHasCompanyDepartment->save();
            $employee->save();
            $employeeHasPosition->save();
            $empPositionHasPermissionAccess->save();
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
        }
    }


    public function resetPasswordUserRecord(Request $request, $id)
    {
        $user =  User::where('person_id', $id)->first();
        $message = '';

        try {
            DB::beginTransaction();
            $user->password = Hash::make('secret123');
            $user->save();
            DB::commit();
            $message = 'Successfully Reset Password';
            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
        }
    }

    // public function removeRestoreUserRecord(Request $request, $id)
    // {
    //     $person = Person::where('status', '0')->findOrFail($id);
    //     $user =  User::where('person_id', $id)->first();
    //     $personHasCompanyDepartment = PersonHasCompanyDepartment::where('person_id', $person->id)->first();
    //     $employee = Employee::where('user_id', $user->id)->first();
    //     $employeeHasPosition = EmployeeHasPosition::where('employee_id', $employee->id)->first();
    //     $empPositionHasPermissionAccess = EmpPosHasPermissionAccess::where('employee_has_position_id', $employeeHasPosition->id)->first();

    //     $message = '';

    //     try {
    //         DB::beginTransaction();
    //         if ($person->status == '0') {
    //             $person->status = '1';
    //             $user->status = '1';
    //             $personHasCompanyDepartment->status = '1';
    //             $employee->status = '1';
    //             $employeeHasPosition->status = '1';
    //             $empPositionHasPermissionAccess->status = '1';
    //             $message = 'Record Successfully Restored!';
    //         }

    //         $person->save();
    //         $user->save();
    //         $personHasCompanyDepartment->save();
    //         $employee->save();
    //         $employeeHasPosition->save();
    //         $empPositionHasPermissionAccess->save();
    //         DB::commit();

    //         return response()->json(array('success' => true, 'messages' => $message));
    //     } catch (\PDOException $e) {
    //         DB::rollBack();
    //         return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
    //     }
    // }

    public function removeRestoreUserRecord(Request $request, $id)
    {
        $person = Person::where('status', '0')->findOrFail($id);
        $user =  User::withTrashed()->where('person_id', $id)->first();
        $personHasCompanyDepartment = PersonHasCompanyDepartment::where('person_id', $person->id)->first();
        $employee = Employee::where('user_id', $user->id)->first();
        $employeeHasPosition = EmployeeHasPosition::where('employee_id', $employee->id)->first();
        $empPositionHasPermissionAccess = EmpPosHasPermissionAccess::where('employee_has_position_id', $employeeHasPosition->id)->first();

        $message = '';

        try {
            DB::beginTransaction();
            if ($person->status == '0') {
                $person->status = '1';
                $user->status = '1';
                $user->restore();
                $personHasCompanyDepartment->status = '1';
                $employee->status = '1';
                $employeeHasPosition ->status = '1';
                $empPositionHasPermissionAccess ->status = '1';
                $message = 'Record Successfully Restored!';
            }

            $person->save();
            $user->save();
            $personHasCompanyDepartment->save();
            $employee->save();
            $employeeHasPosition ->save();
            $empPositionHasPermissionAccess->save();
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'ページを更新し再度実行をお願い致します。'));
        }
    }

    public function checkPassword($password)
    {
        $user = Auth::user();
        if($password != null || $password != "")
        {
            if (!is_null($user)) {
                if (Hash::check($password, $user->password)) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => false]);
                }
            } else {
                return response()->json(['success' => false]);
            }
        }
        else
        {
            return response()->json(['success' => false]);
        }
        
    }

    public function logoutUser($id)
    {
        // Check if the logged-in user has admin privileges.
        // if (access_level() == 1) {
        //     // Log out the specified user.
        //     Auth::setUser($id);
        //     Auth::logout();
        //     // Optionally, broadcast an event to log out the user's other sessions in real-time.

        //     return redirect()->route('login')->with('success', 'Refresh. Please log in again.');
        // } 
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // $employee = User::with('person','employee.employeeHasPosition.employeePositionHasPermissionAccess.permissionHasAccess.access')->where('person_id',1)->first();
        // dd( $employee->employee->employeeHasPosition->employeePositionHasPermissionAccess->permissionHasAccess->access);

        $users_details = Person::with(
            'personCompanyDepartment.companyProfile',
            'personCompanyDepartment.departmentsInfo',
            'user',
            'user.employee',
            'user.employee.employeeHasPosition.position',
            'user.employee.employeeHasPosition.employeePositionHasPermissionAccess.permissionHasAccess.permission',
            'user.employee.employeeHasPosition.employeePositionHasPermissionAccess.permissionHasAccess.access'
        )->where('status', '1')->findOrFail($id);

        // $users_details = PersonHasCompanyDepartment::with('personsInfo', 'usersInfo', 'companyProfile')->where('status', '1')->where('person_id', $id)->first();
        return response()->json(array('success' => true, $users_details, unserialize($users_details->user->employee->employeeHasPosition->employeePositionHasPermissionAccess->permissionHasAccess->access->access_list)));
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

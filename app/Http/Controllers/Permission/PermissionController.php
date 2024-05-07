<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Models\Access;
use App\Models\Permission;
use App\Models\PermissionHasAccess;
use App\Models\EmpPosHasPermissionAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
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
    public function manage_permission()
    {
        return view(
            'permission.manage-permission',
            [
                'title' => "Permission Management",
                'subtitle' => "Permission Management",
                'table_title' => "List of Permissions",
                'module' => "",
                'label' => "A collection of specific access rights or privileges that can be assigned to users or user groups within the system. It outlines the actions, operations, or functionalities that users are allowed or restricted to perform."
            ]
        );
    }


    public function create_permission()
    {
        return view(
            'permission.create-permission',
            [
                'title' => "Create Permissions",
                'subtitle' => "Create Permissions",
                'table_title' => "Create Permissions",
                'module' => "document_categories_mngt",
                'label' => "A process of defining and assigning access rights or privileges to different users or user groups within the system. Permissions are used to control what actions or functionalities a user can perform within the system and what data they can access."
            ]
        );
    }

    public function findAllPermission(Request $request)
    {
        $btnDeleteRestore = "";
        $btnUpdate = "";
        // $columns = array(
        //     0 => 'permission.permission_description',

        // );
        if(company() == 1)
        {
            $totalData = PermissionHasAccess::where('status','1')->count();
            $query = PermissionHasAccess::with(['permission','access', 'companyProfile', 'department', 'position'])->where('status','1');
        }
        else
        {
            $totalData = PermissionHasAccess::where('company_id',company())->where('status','1')->count();
            $query = PermissionHasAccess::with(['permission','access', 'companyProfile', 'department', 'position'])->where('company_id',company())->where('status','1');
        }
       
        //  dd($query); 
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        // $order = $columns[$request->input('order.0.column')];
        // $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $permission = with(clone $query)->offset($start)
                ->limit($limit)
                // ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $permission =  with(clone $query)->whereHas('permission', function ($query) use ($request) {
                $search = $request->input('search.value');
                $query->where(DB::raw("permission_code"), 'LIKE', "%$search%")
                    ->orWhere(DB::raw("permission_description"), 'LIKE', "%$search%");
                // $query->whereRaw("firstname", 'LIKE', "%{$search}%");
            })->offset($start)
                ->limit($limit)
                ->get();

            // $permission = with(clone $query)->where('permission_description', 'LIKE', "%{$search}%")
            //     ->offset($start)
            //     ->limit($limit)
            //     // ->orderBy($order, $dir)
            //     ->get();
            $totalFiltered = with(clone $query)->count();
        }

        $data = array();
        if (!empty($permission)) {
            foreach ($permission as $permission) {

                if ($permission->status == 1) {
                    if (Gate::allows('permission', 'deletePermission')) {
                        $btnDeleteRestore = '<button onclick="removePermissionRecord(' . $permission->permission_id . ')" type="button" class="btn btn-danger btn-icon-text p-2" fdprocessedid="613cnk">
                                                              
                    Delete
                  </button>';
                    }
                } else {
                    if (Gate::allows('permission', 'restorePermission')) {
                    $btnDeleteRestore = '<button onclick="restorePermissionRecord(' . $permission->permission_id . ')" type="button" class="btn btn-warning btn-icon-text p-2" fdprocessedid="613cnk">                           
                    Restore
                  </button>';
                    }
                }


                // $btnDelete = '<button onclick="removeRecord('.$driver->id.')" type="button" class="text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-xs p-1.5 text-center inline-flex items-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800">
                // <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                //     <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                // </svg></button>';

                if (Gate::allows('permission', 'updatePermission')) {
                $btnUpdate = '<button type="button" onclick="update(' . $permission->permission_id . ')" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">
                                                                      
                             Update
                         </button>';
                }


                if ($permission->status == '1') {
                    $status = '<span class="badge badge-success">Active</span>';
                } else {
                    $status = '<span class="badge badge-danger">Inactive</span>';
                }

                // $btnUpdate = '<button onclick="edit('.$driver->id.')"  type="button" class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-xs p-1.5 text-center inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800">
                // <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                //     <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                // </svg></button>';   

                //  $position_list = permissionHasPosition::with(['position'])->where('status', '1')->where('permission_id', $permission->id)->get();

                $buttons = $btnUpdate . " " . $btnDeleteRestore;
                // $buttons = '<button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" type="button">Update</button> <button class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded" type="button">Delete</button>';
                $nestedData['code'] = $permission->permission->permission_code;
                $nestedData['access_level'] = $permission->permission->permission_description;
                $nestedData['company'] = $permission->companyProfile->company_name;
                $nestedData['department'] = $permission->department->name;
                $nestedData['position'] = $permission->position->name;
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

    public function saveNewPermission(Request $request)
    {
        $current_date = Carbon::today();
        $year = $current_date->year;
        $day = $current_date->day;
        $month = $current_date->month;


        $permission = new Permission();

        try {
            DB::beginTransaction();

            $permission->permission_code = "";
            $permission->permission_description = convertData($request['position_level_access']);
            $permission->status = "1";
            $message = 'Record successfully Added!';
            $permission->save();

            $generate_permission_code = 'PER' . str_pad($day . substr($year, -2) . $month .  $permission->id, 6, '0', STR_PAD_LEFT);
            $permission->permission_code = $generate_permission_code;
            $permission->save();

            $access = new Access();
            $access->access_code = "";
            $access->access_list = serialize($request['permission']);
            $access->status = "1";
            $access->save();

            // $generate_access_code = 'ACS' . str_pad($day . substr($year, -2) . $month .  $access->id, 6, '0', STR_PAD_LEFT);
            $access->access_code = generateCode('ACS',$access->id);
            $access->save();

            $permissionHasAccess = new PermissionHasAccess();
            $permissionHasAccess->permission_id = $permission->id;
            $permissionHasAccess->company_id = convertData($request['company_name']);
            $permissionHasAccess->department_id = convertData($request['department']);
            $permissionHasAccess->position_id = convertData($request['position']);
            $permissionHasAccess->access_id = $access->id;
            $permissionHasAccess->status = "1";
            $permissionHasAccess->save();

            // $employeePositionHasPemissionAccess = new EmpPosHasPermissionAccess();


            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }

    public function updatePermissionRecord(Request $request)
    {
        $current_date = Carbon::today();
        $year = $current_date->year;
        $day = $current_date->day;
        $month = $current_date->month;
        $permission = Permission::findOrFail($request['update_id']);
        try {
            DB::beginTransaction();


            $permission->permission_description = convertData($request['position_level_access']);
            $permission->save();

            $permissionHasAccess = PermissionHasAccess::where('permission_id', $permission->id)->first();

            $access = Access::findOrFail($permissionHasAccess->access_id);
            $access->access_list = serialize($request['permission']);
            $access->save();


            $permissionHasAccess->company_id = convertData($request['company_name']);
            $permissionHasAccess->department_id = convertData($request['department']);
            $permissionHasAccess->position_id = convertData($request['position']);
            $permissionHasAccess->save();

            $message = 'Record successfully Updated!';

            // $employeePositionHasPemissionAccess = new EmpPosHasPermissionAccess();


            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }

    public function removePermissionRecord(Request $request, $id)
    {

        $permission = Permission::findOrFail($id);
        $permissionHasAccess = PermissionHasAccess::where('permission_id', $permission->id)->first();
        $access = Access::findOrFail($permissionHasAccess->access_id);
        $message = '';
        $action = '';

        try {
            DB::beginTransaction();
            if ($permission->status == '1') {
                // $driver->reason_for_deletion = convertData('NONE');
                $permission->status = '0';
                $permissionHasAccess->status = '0';
                $access->status = '0';

                $message = 'Record Successfully Deactivated!';


                $action = 'DELETED';
            }
            //$changes = $driver->getDirty();
            $permission->save();
            $permissionHasAccess->save();
            $access->save();
            DB::commit();
            //action_log('Department mngt', $action, array_merge(['id' => $department->id], $changes));

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }

    public function restorePermissionRecord(Request $request, $id)
    {

        $permission = Permission::findOrFail($id);
        $permissionHasAccess = PermissionHasAccess::where('permission_id', $permission->id)->first();
        $access = Access::findOrFail($permissionHasAccess->access_id);
        $message = '';
        $action = '';

        try {
            DB::beginTransaction();
            if ($permission->status == '0') {
                // $driver->reason_for_deletion = convertData('NONE');
                $permission->status = '1';
                $permissionHasAccess->status = '1';
                $access->status = '1';

                $message = 'Record Successfully Activated!';


                $action = 'DELETED';
            }
            //$changes = $driver->getDirty();
            $permission->save();
            $permissionHasAccess->save();
            $access->save();
            DB::commit();
            //action_log('Department mngt', $action, array_merge(['id' => $department->id], $changes));

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
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
        $query = Permission::with(['permissionHasAccess.access', 'permissionHasAccess.companyProfile', 'permissionHasAccess.department', 'permissionHasAccess.position'])->where('status', '1')->findOrFail($id);
        return response()->json(array('success' => true, 'permission' => $query, 'company_profile' => $query->permissionHasAccess->companyProfile, 'department' => $query->permissionHasAccess->department, 'position' => $query->permissionHasAccess->position, 'access' => unserialize($query->permissionHasAccess->access->access_list)));
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

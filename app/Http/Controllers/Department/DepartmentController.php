<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DepartmentHasPosition;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class DepartmentController extends Controller
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
    public function manage_department()
    {
        return view(
            'department.manage-department',
            [
                'title' => "Department Management",
                'subtitle' => "Department Management",
                'table_title' => "部門一覧",
                'module' => "",
                'label' => "システムとは、組織またはシステム内のさまざまな部門または機能領域の集合または分類を指します。このリストは、さまざまな部門の整理と管理に役立ち、コミュニケーション、コラボレーション、ワークフローの調整を促進します。リストに含まれる特定の部門は、システムの性質や組織の構造によって異なる場合があります。"
            ]
        );
    }

    //find all vehicle type list
    public function findAllDepartment(Request $request)
    {
        $columns = array(
            0 => 'name',
            1 => 'description',
        );

        $totalData = Department::count();
        $query = Department::with('departmentHasPosition.position');

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $department = with(clone $query)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $department = with(clone $query)->where('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = with(clone $query)->count();
        }
        $btnDeleteRestore = "";
        $btnUpdate = "";
        $data = array();
        if (!empty($department)) {
            foreach ($department as $department) {

                if ($department->status == 1) {
                    if (Gate::allows('permission', 'deleteDepartment')) {
                        $btnDeleteRestore = '<button onclick="removeDepartmentRecord(' . $department->id . ')" type="button" class="btn btn-danger btn-icon-text p-2" fdprocessedid="613cnk">                                                   
                    
                    消去
                  </button>';
                    }
                } else {
                    if (Gate::allows('permission', 'restoreDepartment')) {
                        $btnDeleteRestore = '<button onclick="restoreDepartmentRecord(' . $department->id . ')" type="button" class="btn btn-warning btn-icon-text p-2" fdprocessedid="613cnk">                                                  
                    復元する
                  </button>';
                    }
                }

                if (Gate::allows('permission', 'updateDepartment')) {
                $btnUpdate = '<button type="button" onclick="update(' . $department->id . ')" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">                                                 
                             アップデート
                         </button>';
                }


                if ($department->status == '1') {
                    $status = '<span class="badge badge-success">アクティブ</span>';
                } else {
                    $status = '<span class="badge badge-danger">非アクティブ</span>';
                }

             

                $buttons = $btnUpdate . " " . $btnDeleteRestore;
                $nestedData['arr'] =   $department;
                $nestedData['name'] = $department->name;
                $nestedData['description'] = $department->description;
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

    public function getAllPosition(Request $request)
    {
        $position = Position::where('status', '1')->get();
        return response()->json($position);
    }

    //save new vehicle type function
    public function saveNewDepartment(Request $request)
    {
        $department = new Department;

        try {
            DB::beginTransaction();

            $department->name = convertData($request['add_department_name']);
            $department->description = convertData($request['add_description']);
            $department->status = "1";
            $message = 'Record successfully Added!';
            $department->save();

            $position_list = $request['add_position_multiselect'];
            foreach ($position_list as $positions) {
                $departmentHasPositions = new DepartmentHasPosition();
                $departmentHasPositions->department_id = $department->id;
                $departmentHasPositions->position_id = $positions;
                $departmentHasPositions->status = '1';
                $departmentHasPositions->save();
            }

            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }

    //update vehicle type info
    public function updateDepartmentRecord(Request $request)
    {

        $department = Department::findOrFail($request['update_id']);
        $departmentHasPositions = DepartmentHasPosition::where('department_id', $department->id)->get();
        $message = '';
        $action = '';

        try {

            DB::beginTransaction();
            $department->name = convertData($request['update_department_name']);
            $department->description = convertData($request['update_description']);
            $department->save();


            foreach ($departmentHasPositions as $departmentHasPositions) {
                $departmentHasPositions->delete();
            }

            $position_list = $request['update_position_multiselect'];
            foreach ($position_list as $position) {
                $departmentHasPositions = new DepartmentHasPosition();
                $departmentHasPositions->department_id = $department->id;
                $departmentHasPositions->position_id = $position;
                $departmentHasPositions->status = '1';
                $departmentHasPositions->save();
            }
            $message = 'Record successfully Updated!';
            DB::commit();
            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }

    //delete vehicle type record
    public function removeDepartmentRecord(Request $request, $id)
    {

        $department = Department::findOrFail($id);
        $departmentHasPositions = DepartmentHasPosition::where('department_id', $department->id)->get();
        $message = '';
        $action = '';

        try {
            DB::beginTransaction();
            if ($department->status == '1') {
                // $driver->reason_for_deletion = convertData('NONE');
                $department->status = '0';
                $message = 'Record Successfully Deleted!';


                foreach ($departmentHasPositions as $departmentHasPositions) {
                    $departmentHasPositions->status = '0';
                    $departmentHasPositions->save();
                }

                $action = 'DELETED';
            }
            //$changes = $driver->getDirty();
            $department->save();
            DB::commit();
            //action_log('Department mngt', $action, array_merge(['id' => $department->id], $changes));

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }

    public function restoreDepartmentRecord(Request $request, $id)
    {

        $department = Department::findOrFail($id);
        $departmentHasPositions = DepartmentHasPosition::where('department_id', $department->id)->get();
        $message = '';
        $action = '';

        try {
            DB::beginTransaction();
            if ($department->status == '0') {
                // $driver->reason_for_deletion = convertData('NONE');
                $department->status = '1';
                $message = 'Record Successfully Restored!';

                foreach ($departmentHasPositions as $departmentHasPositions) {
                    $departmentHasPositions->status = '1';
                    $departmentHasPositions->save();
                }

                $action = 'DELETED';
            }
            //$changes = $driver->getDirty();
            $department->save();
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

        // $query = Department::with('departmentHasPosition.position')->where('status','1');
        $department = Department::with('departmentHasPosition.position')->where('status', '1')->findOrFail($id);
        // dd( $department);
        return response()->json(array('success' => true, 'messages' => 'Record successfully retrieved!', 'data' => $department));
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

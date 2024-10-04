<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Else_;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'activity.manage-activity',
            [
                'title' => "Activity Management",
                'subtitle' => "Activity Management",
                'table_title' => "活動リスト",
                'module' => "",
                'label' => "Categorizes events based on their nature and purpose, such as training sessions, tournaments, graduations, and more. This list serves as a reference to define the specific type of event being organized, aiding in planning, scheduling, and communicating the event's focus and objectives effectively."
            ]
        );
    }

    public function view(Request $request)
    {
        $columns = array(
            0 => 'title',
            1 => 'description',
        );
        if (is_super_admin()) {
            $totalData = Activity::with('company')->where('status', '1')->count();
            $query = Activity::with('company')->where('status', '1');
        } else {
            $totalData = Activity::with('company')->where('company_id', company())->where('status', '1')->count();
            $query = Activity::with('company')->where('company_id', company())->where('status', '1');
        }

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $activity = with(clone $query)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $activity = with(clone $query)->where('title', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = with(clone $query)->count();
        }
        $btnDelete = "";
        $btnUpdate = "";
        $data = array();
        if (!empty($activity)) {
            foreach ($activity as $activity) {
                if (Gate::allows('permission', 'deleteActivities')) {
                    $btnDelete = '<button onclick="remove(' . $activity->id . ')" type="button" class="btn btn-danger btn-icon-text p-2" fdprocessedid="613cnk">                                              
                           削除
                         </button>';
                }

                if (Gate::allows('permission', 'updateActivities')) {
                    $btnUpdate = '<button type="button" onclick="update(' . $activity->id . ')" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">
                                                                                
                             アップデート
                         </button>';
                }

                if ($activity->status == '1') {
                    $status = '<span class="badge badge-success">アクティブ</span>';
                } else {
                    $status = '<span class="badge badge-danger">非アクティブ</span>';
                }

                $buttons = $btnUpdate . " " . $btnDelete;
                $nestedData['title'] = $activity->title;
                $nestedData['description'] = $activity->description;
                $nestedData['company'] = $activity->company->acronym;
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

    public function listofactivity(Request $request)
    {
        $activity = Activity::where('company_id', $request['company_id'])->where('status', '1')->get();
        return response()->json($activity);
    }

    // public function getActivityByCompany($companyId)
    // {
       
    //     $activity = Activity::where('company_id',$companyId)->where('status','1')->get();
      
    //     return response()->json([
    //         'success'   => true,
    //         'data'      =>  $activity,
    //         'message'   => 'Retrieved successfully'
    //     ], 200);
    // }


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
        if(is_super_admin() == true ){
            $input = $request->only([
                'add_company', 
                'add_title', 
                'add_description'
            ]);
            // Validate input
            $validator = Validator::make($input, [
                'add_company' => 'required|integer|exists:company_profiles,id',
                'add_title' => 'required|string|max:255',
                'add_description' => 'required|string|max:255',
            ]);
    
        }
        else
        {
            $input = $request->only([
                'add_title', 
                'add_description'
            ]);
            // Validate input
            $validator = Validator::make($input, [
                'add_title' => 'required|string|max:255',
                'add_description' => 'required|string|max:255',
            ]);
    
        }
      
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation error!',
                'messages' => $validator->errors()
            ]);
        }

        $activity = new Activity;
        try {
            DB::beginTransaction();

            $activity->code = '';
            $activity->company_id = is_super_admin() == true ? $request['add_company'] : company();
            $activity->title = strtoupper(convertData($request['add_title']));
            $activity->description = strtoupper(convertData($request['add_description']));
            $activity->status = "1";
            $activity->save();
            $activity->code = generateCode("ACT", $activity->id);
            $activity->save();
            $message = '追加場所を保存しました';
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
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
        $activity = Activity::where('status', '1')->findOrFail($id);
        return response()->json(array('success' => true, 'messages' => 'Record successfully retrieved!', 'data' => $activity));
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
        $activity = Activity::findOrFail($request['update_id']);

        try {
            DB::beginTransaction();
            $activity->company_id = is_super_admin() == true ? $request['update_company'] : company();
            $activity->title = strtoupper(convertData($request['update_title']));
            $activity->description = strtoupper(convertData($request['update_description']));
            $activity->save();
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
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);

        try {
            DB::beginTransaction();
            $activity->status = "0";
            $activity->save();
            $message = 'Record successfully deleted!';
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
        }
    }
}

<?php

namespace App\Http\Controllers\Position;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PositionController extends Controller
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

    public function manage_position()
    {
        return view('position.manage-position',
        [
            'title' => "Position Management",
            'subtitle' => "Position Management",
            'table_title' => "List of Position",
            'module' => "",
            'label' => "A company refers to a collection or inventory of different job positions or roles within the organizational structure. This list helps in defining and categorizing the various positions within the company, enabling effective human resources management, organizational planning, and workflow coordination. The specific positions included in the list can vary depending on the company's size, industry, and organizational structure."
        ]);
    }

    public function findAllPosition(Request $request)
     {
         $columns = array( 
             0 =>'name', 
             1 =>'description',
         );
 
         $totalData = Position::where('status','1')->count();
         $query = Position::where('status','1');
         $totalFiltered = $totalData; 
 
         $limit = $request->input('length');
         $start = $request->input('start');
         $order = $columns[$request->input('order.0.column')];
         $dir = $request->input('order.0.dir');
 
         if(empty($request->input('search.value')))
         {            
             $position = with(clone $query)->offset($start)
                          ->limit($limit)
                          ->orderBy($order,$dir)
                          ->get();
         }
         else {
             $search = $request->input('search.value'); 
 
             $position = with(clone $query)->where('name','LIKE',"%{$search}%")
                         ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
             $totalFiltered = with(clone $query)->count();
 
         }
         $btnDelete = "";
         $btnUpdate = "";
         $data = array();
         if(!empty($position))
         {
             foreach ($position as $position)
             {  
                if (Gate::allows('permission', 'deletePosition'))
                {
                 $btnDelete = '<button onclick="removePositionRecord('.$position->id.')" type="button" class="btn btn-danger btn-icon-text p-2" fdprocessedid="613cnk">
                                                                             
                           Delete
                         </button>';
                }  
                if (Gate::allows('permission', 'updatePosition'))
                {
                 $btnUpdate = '<button type="button" onclick="update('.$position->id.')" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">
                                                                                
                             Update
                         </button>';
                }
                if($position->status == '1'){
                     $status = '<span class="badge badge-success">Active</span>';
                }else{
                     $status = '<span class="badge badge-danger">Inactive</span>';
                }
 
 
                 $buttons = $btnUpdate." ".$btnDelete;
                 $nestedData['name'] = $position->name;
                 $nestedData['description'] = $position->description;
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

     public function saveNewPosition(Request $request)
     {
         $position = new Position;
         try {
             DB::beginTransaction();
             
             $position->name = convertData($request['add_position_name']);
             $position->description = convertData($request['add_description']);
             $position->status = "1";
             $message = 'Record successfully Added!';
             $position->save();
             DB::commit();
 
             return response()->json(array('success'=> true, 'messages'=>$message));
         } catch (\PDOException $e) {
             DB::rollBack();
             return response()->json(array('success'=> false, 'error'=>'SQL error!', 'messages'=>'Transaction failed!'));
         }
     }
 
     //update vehicle type info
     public function updatePositionRecord(Request $request)
     {
         
         $position = Position::findOrFail($request['update_id']);
         $message = '';
         $action = '';
 
         try {
 
             DB::beginTransaction();
             if($position->status == '1') {
                 $position->name = convertData($request['update_position_name']);
                 $position->description = convertData($request['update_description']);
                 $position->status = "1";
                 $message = 'Record successfully Updated!';
 
             } 
             $position->save();
 
             DB::commit();
             return response()->json(array('success'=> true, 'messages'=>$message));
         } catch (\PDOException $e) {
             DB::rollBack();
             return response()->json(array('success'=> false, 'error'=>'SQL error!', 'messages'=>'Transaction failed!'));
         }
 
     }
 
     //delete vehicle type record
     public function removePositionRecord(Request $request, $id)
     {
 
         $position = Position::findOrFail($id);
         $message = '';
         $action = '';
 
         try {
             DB::beginTransaction();
             if($position->status == '1') {
                 // $driver->reason_for_deletion = convertData('NONE');
                 $position->status = '0';
                 $message = 'Record Successfully Deleted!';
                 $action = 'DELETED';
             } 
             //$changes = $driver->getDirty();
             $position->save();
             DB::commit();
             //action_log('Department mngt', $action, array_merge(['id' => $department->id], $changes));
 
             return response()->json(array('success'=> true, 'messages'=>$message));
         } catch (\PDOException $e) {
             DB::rollBack();
             return response()->json(array('success'=> false, 'error'=>'SQL error!', 'messages'=>'Transaction failed!'));
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
        $position = Position::where('status','1')->findOrFail($id);
        return response()->json(array('success'=>true, 'messages'=>'Record successfully retrieved!','data'=> $position));  
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

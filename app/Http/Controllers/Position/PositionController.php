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
            'table_title' => "ポジション一覧",
            'module' => "",
            'label' => "会社とは、組織構造内のさまざまな役職や役割の集合または目録を指します。このリストは、社内のさまざまな役職を定義および分類するのに役立ち、効果的な人事管理、組織計画、およびワークフローの調整を可能にします。リストに含まれる具体的なポジションは、企業の規模、業界、組織構造によって異なります。"
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
                                                                             
                           消去
                         </button>';
                }  
                if (Gate::allows('permission', 'updatePosition'))
                {
                 $btnUpdate = '<button type="button" onclick="update('.$position->id.')" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">
                                                                                                        
                        アップデート
                         </button>';
                }
                if($position->status == '1'){
                     $status = '<span class="badge badge-success">アクティブ</span>';
                }else{
                     $status = '<span class="badge badge-danger">非アクティブ</span>';
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
             $message = '追加場所を保存しました';
             $position->save();
             DB::commit();
 
             return response()->json(array('success'=> true, 'messages'=>$message));
         } catch (\PDOException $e) {
             DB::rollBack();
             return response()->json(array('success'=> false, 'error'=>'SQL error!', 'messages'=>'エラー'));
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
             return response()->json(array('success'=> false, 'error'=>'SQL error!', 'messages'=>'エラー'));
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
             return response()->json(array('success'=> false, 'error'=>'SQL error!', 'messages'=>'エラー'));
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

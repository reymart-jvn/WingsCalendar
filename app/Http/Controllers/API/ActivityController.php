<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($isSuperAdmin, $companyId)
    {
        if ($isSuperAdmin == 1) {
            $activity = Activity::where('status','1')->get();
        }
        else{
            $activity = Activity::where('company_id',$companyId)->where('status','1')->get();
        }
      
        return response()->json([
            'success'   => true,
            'data'      =>  $activity,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function getActivityByCompany($companyId)
    {
       
        $activity = Activity::where('company_id',$companyId)->where('status','1')->get();
      
        return response()->json([
            'success'   => true,
            'data'      =>  $activity,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function getLatestActivityData($isSuperAdmin, $companyId)
    {
        if($isSuperAdmin == 1)
        {
            $activity = Activity::where('status', '1')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        }
        else
        {
            $activity = Activity::where('company_id',$companyId)->where('status', '1')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        }


        if ($activity->isEmpty()) {
            return response()->json([
                'success'   => false,
                'data'      => [],
                'message'   => 'No Activity Founf'
            ], 200);
        }

        if ($activity->count() < 5) {
            return response()->json([
                'success'   => true,
                'data'      => $activity,
                'message'   => 'Retrieved successfully, but less than 5 activity found'
            ], 200);
        }

        return response()->json([
            'success'   => true,
            'data'      => $activity,
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

        $input = $request->only([
            'company',
            'title',
            'description'
        ]);

        // Validate input
        $validator = Validator::make($input, [
            'company' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation error!',
                'messages' => $validator->errors()
            ]);
        }

        $activity = new Activity();
        try {
            DB::beginTransaction();
            $activity->code = '';
            $activity->company_id = (int) $request['company'];
            $activity->title = strtoupper(convertData($request['title']));
            $activity->description = strtoupper(convertData($request['description']));
            $activity->status = "1";
            $activity->save();
            $activity->code = generateCode("ACT", $activity->id);
            $activity->save();
            $message = '追加場所を保存しました';
            DB::commit();

            return response()->json(array('success'=> true, 'messages'=>$message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success'=> false, 'error'=>'SQL error!', 'messages'=>'エラー'));
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

        $input = $request->only([
            'id',
            'title',
            'description'
        ]);

        // Validate input
        $validator = Validator::make($input, [
            'id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation error!',
                'messages' => $validator->errors()
            ]);
        }

        
        $activity= Activity::findOrFail(intval($request['id']));

        try {
            DB::beginTransaction();
            $activity->title = strtoupper(convertData($request['title']));
            $activity->description = strtoupper(convertData($request['description']));
            $activity->save();
            $message = 'Record successfully updated!';
            DB::commit();

            return response()->json(array('success'=> true, 'messages'=>$message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success'=> false, 'error'=>'SQL error!', 'messages'=>'エラー'));
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
        $activity= Activity::findOrFail(intval($request['id']));

        try {
            DB::beginTransaction();
            $activity->status = "0";
            $activity->save();
            $message = 'Record successfully deleted!';
            DB::commit();

            return response()->json(array('success'=> true, 'messages'=>$message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success'=> false, 'error'=>'SQL error!', 'messages'=>'エラー'));
        }
    }
}

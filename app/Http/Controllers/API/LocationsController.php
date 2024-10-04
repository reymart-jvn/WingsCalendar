<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Middleware\IsAdmin;
use App\Models\Locations;
use Google\Cloud\Location\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($isSuperAdmin, $companyId)
    {
        if ($isSuperAdmin == 1) {
            $locations = Locations::where('status', '1')->get();
        }
        else
        {
            $locations = Locations::where('company_id',$companyId)->where('status', '1')->get();
        }
       
        return response()->json([
            'success'   => true,
            'data'      =>  $locations,
            'message'   => 'Retrieved successfully'
        ], 200);

        // $locations = Locations::where('status', '1')->paginate(10);

        // return response()->json([
        //     'success' => true,
        //     'data' => $locations->items(),
        //     'message' => 'Retrieved successfully',
        //     'current_page' => $locations->currentPage(),
        //     'last_page' => $locations->lastPage(),
        //     'total' => $locations->total()
        // ], 200);
    }

    public function getLocationsByCompany($companyId)
    {
       
        $activity = Locations::where('company_id',$companyId)->where('status','1')->get();
      
        return response()->json([
            'success'   => true,
            'data'      =>  $activity,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function getLatestLocationsData($isSuperAdmin, $companyId)
    {


        if ($isSuperAdmin == 1) {
            $locations = Locations::where('status', '1')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        } else {
            $locations = Locations::where('company_id',$companyId)->where('status', '1')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        }

        if ($locations->isEmpty()) {
            return response()->json([
                'success'   => false,
                'data'      => [],
                'message'   => 'No locations found'
            ], 200);
        }

        if ($locations->count() < 5) {
            return response()->json([
                'success'   => true,
                'data'      => $locations,
                'message'   => 'Retrieved successfully, but less than 5 locations found'
            ], 200);
        }

        return response()->json([
            'success'   => true,
            'data'      => $locations,
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
            'description',
            'address'
        ]);

        // Validate input
        $validator = Validator::make($input, [
            'company' => 'required',
            'description' => 'required|string|max:255',
            'address' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation error!',
                'messages' => $validator->errors()
            ]);
        }

        $location = new Locations;
        try {
            DB::beginTransaction();
            $location->code = '';
            $location->company_id = (int) $request['company'];
            $location->description = strtoupper(convertData($request['description']));
            $location->location_address = strtoupper(convertData($request['address']));
            $location->status = "1";
            $location->save();
            $location->code = generateCode("LOC", $location->id);
            $location->save();
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
            'description',
            'address'
        ]);

        // Validate input
        $validator = Validator::make($input, [
            'id' => 'required',
            'description' => 'required|string|max:255',
            'address' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation error!',
                'messages' => $validator->errors()
            ]);
        }

        $location = Locations::findOrFail(intval($request['id']));

        try {
            DB::beginTransaction();
            $location->description = strtoupper(convertData($request['description']));
            $location->location_address = strtoupper(convertData($request['address']));
            $location->save();
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
        $location = Locations::findOrFail(intval($request['id']));

        try {
            DB::beginTransaction();
            $location->status = "0";
            $location->save();
            $message = 'Record successfully deleted!';
            DB::commit();

            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'エラー'));
        }
    }
}

<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Models\Locations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'location.manage-location',
            [
                'title' => "Location Management",
                'subtitle' => "Location Management",
                'table_title' => "場所のリスト",
                'module' => "",
                'label' => "The various venues or sites where events can be hosted, ranging from conference centers and hotels to outdoor spaces and specialized facilities. This resource facilitates the selection and booking of suitable locations based on event requirements, ensuring logistical considerations like capacity, accessibility, and amenities are met efficiently."
            ]
        );
    }

    public function view(Request $request)
    {
        $columns = array(
            0 => 'description',
            1 => 'location_address',
        );


        if (is_super_admin()) {
            $totalData = Locations::with('company')->where('status', '1')->count();
            $query = Locations::with('company')->where('status', '1');
        } else {
            $totalData = Locations::with('company')->where('company_id', company())->where('status', '1')->count();
            $query = Locations::with('company')->where('company_id', company())->where('status', '1');
        }

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $location = with(clone $query)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $location = with(clone $query)->where('description', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = with(clone $query)->count();
        }
        $btnDelete = "";
        $btnUpdate = "";
        $data = array();
        if (!empty($location)) {
            foreach ($location as $location) {
                if (Gate::allows('permission', 'deleteLocation')) {
                    $btnDelete = '<button onclick="remove(' . $location->id . ')" type="button" class="btn btn-danger btn-icon-text p-2" fdprocessedid="613cnk">
                                                                             
                           削除
                         </button>';
                }


                if (Gate::allows('permission', 'updateLocation')) {
                    $btnUpdate = '<button type="button" onclick="update(' . $location->id . ')" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">
                                                                                
                             アップデート
                         </button>';
                }

                if ($location->status == '1') {
                    $status = '<span class="badge badge-success">アクティブ</span>';
                } else {
                    $status = '<span class="badge badge-danger">非アクティブ</span>';
                }

                $buttons = $btnUpdate . " " . $btnDelete;
                $nestedData['name'] = $location->description;
                $nestedData['address'] = $location->location_address;
                $nestedData['company'] = $location->company->acronym;
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

    public function listoflocation(Request $request)
    {
        $location = Locations::where('company_id', $request['company_id'])->where('status', '1')->get();
        return response()->json($location);
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

        if(is_super_admin() == true )
        {
            $input = $request->only([
                'add_company', 
                'add_location_name', 
                'add_address'
            ]);
    
            // Validate input
            $validator = Validator::make($input, [
                'add_company' => 'required|integer|exists:company_profiles,id',
                'add_location_name' => 'required|string|max:255',
                'add_address' => 'required|string|max:255',
            ]);
    
        }
        else
        {
            $input = $request->only([
                'add_location_name', 
                'add_address'
            ]);
    
            // Validate input
            $validator = Validator::make($input, [
                'add_location_name' => 'required|string|max:255',
                'add_address' => 'required|string|max:255',
            ]);
    
        }
       
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
            $location->company_id = is_super_admin() == true ? $request['add_company'] : company();
            $location->description = strtoupper(convertData($request['add_location_name']));
            $location->location_address = strtoupper(convertData($request['add_address']));
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
        $location = Locations::where('status', '1')->findOrFail($id);
        return response()->json(array('success' => true, 'messages' => 'Record successfully retrieved!', 'data' => $location));
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
        $location = Locations::findOrFail($request['update_id']);

        try {
            DB::beginTransaction();
            $location->company_id = is_super_admin() == true ? $request['update_company'] : company();
            $location->description = strtoupper(convertData($request['update_location_name']));
            $location->location_address = strtoupper(convertData($request['update_address']));
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
    public function destroy($id)
    {
        $location = Locations::findOrFail($id);

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

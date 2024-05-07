<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\CompanyProfile;
use App\Models\CompanyHasDepartment;
use App\Models\CompanyHasPersonIncharge;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class CompanyController extends Controller
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

    public function manage_company()
    {
        return view('company.manage-company',
        [
            'title' => "Company Management",
            'subtitle' => "Company Management",
            'table_title' => "List of Company",
            'module' => "",
            'label' => "A system refers to a collection or database of companies or organizations that are registered or recognized within the system. This list helps in managing and organizing information related to different companies and their associated data. The specific details included in the list can vary depending on the system's purpose and requirements."
        ]);
    }

    public function getAllDepartment(Request $request)
    {
        $department = Department::where('status', '1')->get();
        return response()->json($department);
    }

    public function findAllCompany(Request $request)
    {
        $columns = array(
            0 => 'company_code',
            1 => 'company_name',
        );

        $totalData = CompanyProfile::where('status', '1')->count();
        $query = CompanyProfile::where('status', '1');
        $totalFiltered = $totalData;


        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        //   $query =DocumentRequest::with(['requestType','docsCategory','requestParty']);

        if (empty($request->input('search.value'))) {
            $company = with(clone $query)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $company = with(clone $query)->where('company_name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = with(clone $query)->count();
        }
        $btnDelete = "";
        $btnUpdate = "";
        $data = array();
        if (!empty($company)) {
            foreach ($company as $company) {

                if (Gate::allows('permission', 'deleteCompany'))
                {
                $btnDelete = '<button onclick="removeCompanyRecord(' . $company->id . ')" type="button" class="btn btn-danger btn-icon-text p-2" fdprocessedid="613cnk">                                                 
                            Delete
                          </button>';
                }

                if (Gate::allows('permission', 'updateCompany'))
                {
                $btnUpdate = '<button type="button" onclick="update(' . $company->id . ')" class="btn btn-info btn-icon-text p-2" fdprocessedid="613cnk">                                                 
                              Update
                          </button>';
                }


                if ($company->status == '1') {
                    $status = '<span class="badge badge-success">Active</span>';
                } else {
                    $status = '<span class="badge badge-danger">Inactive</span>';
                }

                $buttons = $btnUpdate . " " . $btnDelete;
                $department_list = CompanyHasDepartment::with(['departmentsInfo'])->where('status', '1')->where('company_id', $company->id)->get();
                $personIncharge = CompanyHasPersonIncharge::where('status', '1')->where('company_id',$company->id)->get();
                $nestedData['arr'] =  $department_list;
                $nestedData['person_incharge'] = $personIncharge;
                $nestedData['company_code'] = $company->company_code;
                $nestedData['company_name'] = $company->company_name;
                $nestedData['vat_number'] = $company->vat_no;
                $nestedData['email'] = $company->email;
                $nestedData['address'] = $company->address;
                $nestedData['contact_number'] = $company->contact_number;
                $nestedData['tel_number'] = $company->tel_number;
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

    public function saveNewCompany(Request $request)
    {

          //Variables for generated document code
          $current_date = Carbon::today();
          $year = $current_date->year;
          $day = $current_date->day;
          $month = $current_date->month;

        $company = new CompanyProfile();
        $companyHasDepartments = new CompanyHasDepartment();
        $personIncharge = new CompanyHasPersonIncharge();
      
        try {
            DB::beginTransaction();
            $company->company_code = '';
            $company->company_name = convertData($request['add_company_name']);
            $company->acronym = convertData($request['company_name_acronym']);
            $company->vat_no = convertData($request['add_vat_number']);
            $company->email = convertData($request['add_email']);
            $company->address = convertData($request['add_address']);
            $company->contact_number = convertData($request['add_contact_number']);
            $company->tel_number = convertData($request['add_tel_number']);
            // $company->department_id =  serialize($request['add_department_multiselect']);
            $company->status = "1";
            $company->save();

            $department_list = $request['add_department_multiselect'];
            foreach($department_list as $departments){
                $companyHasDepartments = new CompanyHasDepartment();
                $companyHasDepartments->company_id =$company->id;
                $companyHasDepartments->department_id = $departments;
                $companyHasDepartments->status = '1';
                $companyHasDepartments->save();
            }

            // $generate_code = 'COM' . str_pad($day . substr($year, -2) . $month .  $company->id, 6, '0', STR_PAD_LEFT);
            $company->company_code =  generateCode('COMP',$company->id);
            $company->save();

            $personIncharge->employee_no = convertData($request['add_emp_num']);
            $personIncharge->company_id =  $company->id;
            $personIncharge->first_name = convertData($request['add_first_name']);
            $personIncharge->middle_name = convertData($request['add_middle_name']);
            $personIncharge->last_name = convertData($request['add_last_name']);
            $personIncharge->home_address = convertData($request['add_person_address']);
            $personIncharge->contact_number = convertData($request['add_person_contact_number']);
            $personIncharge->email = $request['add_person_email'];
            $personIncharge->status = '1';           
            $personIncharge->save();
            $message = 'Record successfully Added!';
           
            DB::commit();

            return response()->json(array('success'=> true, 'messages'=>$message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success'=> false, 'error'=>'SQL error!', 'messages'=>'Transaction failed!'));
        }
    }
    public function updateCompanyRecord(Request $request)
    {
      
        // $companyHasDepartment = CompanyHasDepartment::with(['officialReceipt', 'certificateOfRegistration', 'vehicleInfo'])->where('status', '1')->where('vehicle_info_id', $request['update_id'])->first();
        // return response()->json(array($request['update_id']));
        $company = CompanyProfile::findOrFail($request['update_id']);
        $companyHasDepartments = CompanyHasDepartment::where('company_id', $company->id)->get();
        $personIncharge = CompanyHasPersonIncharge::where('company_id',$company->id)->first();

        // $vehicle = VehicleType::findOrFail($request['update_id']);
        $message = '';

        try {

            DB::beginTransaction();

            $company->company_name = convertData($request['update_company_name']);
            $company->vat_no = convertData($request['update_vat_number']);
            $company->email = convertData($request['update_email']);
            $company->address = convertData($request['update_address']);
            $company->contact_number = convertData($request['update_contact_number']);
            $company->tel_number = convertData($request['update_tel_number']);
            $company->save();

         
            foreach($companyHasDepartments as $companyHasDepartments){
                $companyHasDepartments->delete();
            }

            
            $department_list = $request['update_department_multiselect'];
            foreach($department_list as $departments){
                $companyHasDepartments = new CompanyHasDepartment();
                $companyHasDepartments->company_id =$company->id;
                $companyHasDepartments->department_id = $departments;
                $companyHasDepartments->status = '1';
                $companyHasDepartments->save();
            }

            $personIncharge->employee_no = convertData($request['update_emp_num']);
            $personIncharge->first_name = convertData($request['update_first_name']);
            $personIncharge->middle_name = convertData($request['update_middle_name']);
            $personIncharge->last_name = convertData($request['update_last_name']);
            $personIncharge->home_address = convertData($request['update_person_address']);
            $personIncharge->contact_number = convertData($request['update_person_contact_number']);
            $personIncharge->email = $request['update_person_email'];         
            $personIncharge->save();

            // $user = User::where('id', $id)->firstorfail()->delete();

            $message = 'Record successfully Updated!';

            DB::commit();
            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }

    public function removeCompanyRecord(Request $request, $id)
    {
  
        $company = CompanyProfile::where('status', '1')->findOrFail($id);
        $companyHasDepartment = CompanyHasDepartment::where('company_id', $company->id)->get();
        $personIncharge = CompanyHasPersonIncharge::where('company_id',$company->id)->first();
  
          try {
              DB::beginTransaction();
              if($company->status == '1') {
                  // $driver->reason_for_deletion = convertData('NONE');
                  $company->status = '0';
                  $personIncharge->status = '0';

                  foreach($companyHasDepartment as $companyHasDepartment){
                    $companyHasDepartment->status = '0';
                    $companyHasDepartment->save();
                }
                //   $companyHasDepartment->status = '0';
                  $message = 'Record Successfully Deleted!';
                  $action = 'DELETED';
              } 
              //$changes = $driver->getDirty();
              $company->save();
              $personIncharge->save();
              $companyHasDepartment->save();
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
        $company = CompanyProfile::where('status', '1')->findOrFail($id);
        $department_list = CompanyHasDepartment::with(['departmentsInfo'])->where('status', '1')->where('company_id', $company->id)->get();
        $personIncharge = CompanyHasPersonIncharge::where('status','1')->where('company_id',$company->id)->first();
        return response()->json(array('success' => true,'company_profile'=> $company,'department_info'=>$department_list,'person_incharge'=> $personIncharge));   
        // return response()->json(array('success' => true, 'messages' => 'Record successfully retrieved!', 'data' => $companyHasDepartment));
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

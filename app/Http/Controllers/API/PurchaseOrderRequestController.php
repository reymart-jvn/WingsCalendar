<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Models\PrpStatus;
use App\Models\PurchaseOrderTransaction;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestProgress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;


class PurchaseOrderRequestController extends Controller
{
    //
    public function storePurchaseOrderRequest($code, $company_id, $category, $amount_requested)
    {


        try {
            DB::beginTransaction();
            $purchase_request = new PurchaseRequest();
            $purchase_request_progress = new PurchaseRequestProgress();

            $getdriverinfo = Driver::where('code', $code)->where('status', '1')->first();
            $purchase_request->requested_by = $getdriverinfo->first_name . " " . $getdriverinfo->last_name;
            $purchase_request->driver_id = $getdriverinfo->id;
            $purchase_request->company_id = $company_id;
            $purchase_request->reference_no = "";
            $purchase_request->details = "NONE";
            $purchase_request->category = $category;
            $purchase_request->remarks = 'FOR APPROVAL';
            $purchase_request->amount_requested = $amount_requested;
            $purchase_request->status = "1";
            $message = 'Record successfully Added!';
            $purchase_request->save();

            $purchase_request->reference_no =  generateCode("PR", $purchase_request->id);
            $purchase_request->save();

            $purchase_request_progress->pr_id =  $purchase_request->id;
            $purchase_request_progress->prp_status = "PENDING";
            $purchase_request_progress->status = "1";
            $purchase_request_progress->save();

            DB::commit();
            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
    }

    public function getPurchaseOrderTransaction($driver_id)
    {
        $query = PurchaseRequest::with(['purchaseRequestProgress' => function ($query) {
            $query->where('status', '1')->latest();
        }, 'purchaseOrderTransactionForDisplay', 'purchaseRequestHasVehicleAndDriver.certificateOfRegistration', 'companyProfile','consolidateRequest.consolidatePurchaseTransactions'])->where('status', '1')->where('driver_id', $driver_id)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success'   => true,
            'data'      =>  $query,
            'message'   => 'Retrieved successfully'
        ], 200);
    }

    public function checkExistPurchaseOrderTransaction($id)
    {
        //   try {
        //     DB::beginTransaction();
        //     $purchase_request = PurchaseRequest::where('driver_id',$id)->where('status','1')->latest();
        //     $getpurchaseprogess = PurchaseRequestProgress::where('pr_id',$purchase_request->id)->where('prp_status','PENDING')->where('status','1')->first();




        //     DB::commit();
        //     return response()->json(array('success' => true, 'messages' => $message));
        // } catch (\PDOException $e) {
        //     DB::rollBack();
        //     return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        // }
    }
}

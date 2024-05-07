<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConsolidatePOImage;
use App\Models\ConsolidatePurchaseOrder;
use App\Models\ConsolidatePurchaseOrderHasSupplier;
use App\Models\ConsolidatePurchaseOrderTransaction;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestProgress;
use App\Models\PurchaseOrderTransaction;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ConsolidatePurchaseOrderController extends Controller
{
    //
    public function storeConsolidatrPurchaseOrder(Request $request)
    {
        $consolidate_request = new ConsolidatePurchaseOrder();
        $consolidate_request_transaction = new ConsolidatePurchaseOrderTransaction();
        $consolidate_request_image = new ConsolidatePOImage();
        $consolidate_request_supplier = new ConsolidatePurchaseOrderHasSupplier();

        try {
            DB::beginTransaction();

            $discrepancy = 0;
            $googleCloudStoragePath = "";
            $amount_granted = floatval(convertData($request['po_amount_granted']));
            $amount_consolidated = floatval(convertData($request['con_amount']));
            // 5000 >= 4000
            if ($amount_granted > $amount_consolidated) {
                $discrepancy =  $amount_granted - $amount_consolidated;
                $discrepancy_status = "SHORTAGE";
            } // 5000 < 6000
            else if ($amount_granted < $amount_consolidated) {
                //6000 - 5000
                $discrepancy =   $amount_consolidated - $amount_granted;
                $discrepancy_status = "EXCESS";
            } else {
                $discrepancy = 0;
                $discrepancy_status = "NORMAL";
            }

            $consolidate_request->reference_no = "";
            $consolidate_request->po_id = convertData($request['po_id']);
            $consolidate_request->amount_consolidated = convertData($request['con_amount']);
            $consolidate_request->discrepancy =  $discrepancy;
            $consolidate_request->discrepancy_status = $discrepancy_status;
            $consolidate_request->status = "1";
            $message = 'Record successfully Added!';
            $consolidate_request->save();

            if ($request->hasFile('con_image')) {
                $allowedfileExtension = ['jpg', 'jpeg', 'png'];
                $image = $request->file('con_image');


                $extension = $image->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);

                if ($check) {
                    $disk = Storage::disk('gcs');

                    // Specify the folder name where you want to store the image
                    //Driver Name with code // Another folder name base of what management
                    $folderName = 'ConsolidateRequest/';

                    // Specify the file name for the image
                    $fileName = generateCode("CON", $consolidate_request->id) . '.' . $image->getClientOriginalExtension();
                    $googleCloudStoragePath = $folderName . '/' . $fileName;

                    // Get the contents of the image
                    $imageContent = file_get_contents($image->getPathname());

                    // Upload the image to the specified folder using write() method
                    $disk->write($folderName . $fileName, $imageContent);
                } else {
                    DB::rollBack();
                    return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Your file extension in not allowed. Please convert first to the following alllowed extension (jpg,jpeg,png)'));
                }

                // Optionally return a success message or perform additional actions
                // return response()->json(['message' => 'Image uploaded successfully']);
            }

            // $consolidate_request->img = $googleCloudStoragePath;
            $consolidate_request->reference_no =  generateCode("CON", $consolidate_request->id);
            $consolidate_request->save();

            $consolidate_request_transaction->consolidate_id =  $consolidate_request->id;
            $consolidate_request_transaction->transaction_status = "PENDING";
            $consolidate_request_transaction->remarks = "PENDING";
            $consolidate_request_transaction->process_by = Auth::user()->name;
            $consolidate_request_transaction->status = "1";
            $consolidate_request_transaction->save();

            $consolidate_request_image->consolidate_id =  $consolidate_request->id;
            $consolidate_request_image->img = $fileName;
            $consolidate_request_image->status = "1";
            $consolidate_request_image->save();

            $consolidate_request_supplier->consolidate_id  =  $consolidate_request->id;
            $consolidate_request_supplier->supplier_id  =  $request['con_supplier'];
            $consolidate_request_supplier->status = "1";
            $consolidate_request_supplier->save();



            DB::commit();
            return response()->json(array('success' => true, 'messages' => $message));
        } catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(array('success' => false, 'error' => 'SQL error!', 'messages' => 'Transaction failed!'));
        }
}
}

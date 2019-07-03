<?php

namespace App\Http\Controllers;

use Validator;
use App\Vendor;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function list(Request $request) {
       $vendors = Vendor::all();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $vendors
        ], 200);   
    }

    public function detail(Request $request) {
        $vendor = Vendor::find($request->vendor_id);

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $vendor
        ], 200);  
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'vendor_name' => 'required|unique:vendors',
            'phone_number' => 'required',
            'company_name' => 'required|unique:vendors',
            'npwp' => 'required|unique:vendors'
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Create vendor failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $vendor = Vendor::create([
            'vendor_name' => $request->vendor_name,
            'phone_number' => $request->phone_number,
            'company_name' => $request->company_name,
            'npwp' => $request->npwp,
            'bank_name' => $request->bank_name,
            'account_bank' => $request->account_bank,
            'account_bank_name' => $request->account_bank_name,
            'created_by' => $request->auth->id
        ]);

        return response()->json([
           "status" => 200,
            "message" => "Vendor created successfully",
            "data" => $vendor
            ], 200);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'vendor_name' => 'required|unique:vendors,vendor_name,'.$request->vendor_id,
            'phone_number' => 'required|unique:vendors,phone_number,'.$request->vendor_id,
            'company_name' => 'required|unique:vendors,company_name,'.$request->vendor_id,
            'npwp' => 'required|unique:vendors,npwp,'.$request->vendor_id
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Update vendor failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }
        
        $vendor = Vendor::find($request->vendor_id);

        if($vendor){
            if($request->vendor_name)
                $vendor->vendor_name = $request->vendor_name;

            else if($request->phone_number)
                $vendor->phone_number = $request->phone_number;

            else if($request->company_name)
                $vendor->company_name = $request->company_name;

            else if($request->npwp)
                $vendor->npwp = $request->npwp;

            else if($request->bank_name)
                $vendor->bank_name = $request->bank_name;

            else if($request->account_bank_name)
                $vendor->account_bank_name = $request->account_bank_name;

            $vendor->updated_by = $request->auth->id;
            $vendor->update();

            $status = 200;
            $message = "Vendor updated successfully";
        }

        else{
            $status = 410;
            $message = "Vendor not found";
        }
        

        return response()->json([
           "status" => $status,
            "message" => $message,
            "data" => $vendor
            ], $status);        
    }

    public function delete(Request $request) {
        $vendor = Vendor::find($request->vendor_id);

        if($vendor){
            $vendor->deleted_by = $request->auth->id;
            $vendor->save();
            $vendor->delete();
            $status = 200;
            $message = "Vendor deleted successfully";
        }

        else{
            $status = 401;
            $message = "Delete a vendor failed";
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $vendor
        ], $status);        
    }

    public function trash()
    {
        $vendor = Vendor::onlyTrashed()->get();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $vendor
        ], 200);       
    }
}

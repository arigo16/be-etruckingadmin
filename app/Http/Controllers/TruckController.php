<?php

namespace App\Http\Controllers;

use Validator;
use App\Truck;
use App\Vendor;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;

class TruckController extends Controller
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
    $trucks = Truck::with("truck_type", "box_type")->get();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $trucks
        ], 200);   
    }

    public function detail(Request $request) {
        $truck = Truck::with("truck_type", "box_type")->where('id', $request->truck_id);

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $truck
        ], 200);  
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required',
            'truck_type_id' => 'required|exists:truck_types,id',
            'box_type_id' => 'required|exists:box_types,id',
            'plat_number' => 'required|unique:trucks',
            'merk' => 'required',
            'model' => 'required',
            'status' => 'required',
            'image_stnk' => 'required',
            'image_interior' => 'required',
            'image_front' => 'required',
            'image_back' => 'required'
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Create truck failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $truck = Truck::create([
            'vendor_id' => $request->vendor_id,
            'truck_type_id' => $request->truck_type_id,
            'box_type_id' => $request->box_type_id,
            'plat_number' => $request->plat_number,
            'merk' => $request->merk,
            'model' => $request->model,
            'status' => $request->status,
            'image_stnk' => $request->image_stnk,
            'image_interior' => $request->image_interior,
            'image_front' => $request->image_front,
            'image_back' => $request->image_back,
            'created_by' => $request->auth->id
        ]);

        if($truck){
            return response()->json([
               "status" => 200,
                "message" => "Truck created successfully",
                "data" => $truck
                ], 200);
        }

        else{
            return response()->json([
               "status" => 401,
                "message" => "Truck failed to create successfully",
                "data" => $truck
                ], 401);
        }
    }

    public function update(Request $request) {
       $status = $message = "";
       $validator = Validator::make($request->all(), [
            'truck_type_id' => 'exists:truck_types,id',
            'plat_number' => 'unique:trucks,id,'.$request->truck_id,
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Update truck failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $truck = Truck::find($request->truck_id);
        // dd($request->truck_id);
        if($truck){
            if($request->vendor_id){
                $truck->vendor_id = $request->vendor_id;
            }

            if($request->truck_type_id){
                $truck->truck_type_id = $request->truck_type_id;
            }

            if($request->box_type_id){
                $truck->box_type_id = $request->box_type_id;
            }

            if($request->plat_number){
                $truck->plat_number = $request->plat_number;
            }

            if($request->merk){
                $truck->merk = $request->merk;
            }

            if($request->model){
                $truck->model = $request->model;
            }

            if($request->status){
                $truck->status = $request->status;
            }

            if($request->image_stnk){
                $truck->image_stnk = $request->image_stnk;
            }

            if($request->image_interior){
                $truck->image_interior = $request->image_interior;
            }

            if($request->image_front){
                $truck->image_front = $request->image_front;
            }

            if($request->image_back){
                $truck->image_back = $request->image_back;
            }

            $truck->updated_by = $request->auth->id;

            $truck->update();

            $status = 200;
            $message = "Truck updated successfully";
        }

        else{
            $status = 401;
            $message = "Truck not found";
        }
        

        return response()->json([
           "status" => $status,
            "message" => $message,
            "data" => $truck
            ], $status);        
    }

    public function delete(Request $request) {
        $truck = Truck::find($request->truck_id);

        if($truck){
            $truck->deleted_by = $request->auth->id;
            $truck->save();
            $truck->delete();
            $status = 200;
            $message = "Truck deleted successfully";
        }

        else{
            $status = 401;
            $message = "Delete a truck failed";
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $truck
        ], $status);        
    }

    public function trash()
    {
        $truck = Truck::onlyTrashed()->get();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $truck
        ], 200);       
    }
}

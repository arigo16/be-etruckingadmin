<?php

namespace App\Http\Controllers;

use Validator;
use App\Driver;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
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
       $drivers = Driver::with('vendor')->get();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $drivers
        ], 200);   
    }

    public function detail(Request $request) {
        $driver = Driver::with('vendor')->where('id', $request->driver_id)->first();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $driver
        ], 200);  
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:vendors,id',
            'driver_name' => 'required',
            'username' => 'unique:drivers',
            'password' => 'required',
            'phone_number' => 'required|unique:drivers',
            'email' => 'required|unique:drivers',
            'ktp' => 'required|unique:drivers'
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Create driver failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $driver = Driver::create([
            'vendor_id' => $request->vendor_id,
            'driver_name' => $request->driver_name,
            'username' => $request->username,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'ktp' => $request->ktp,
            'status' => $request->status,
            'address' => $request->address,
            'image_ktp' => $request->image_ktp,
            'image_sim' => $request->image_sim,
            'image_skck' => $request->image_skck,
            'image_front' => $request->image_front,
            'image_left' => $request->image_left,
            'image_right' => $request->image_right,
            'created_by' => $request->auth->id
        ]);

        if($driver){
            return response()->json([
               "status" => 200,
                "message" => "Driver created successfully",
                "data" => $driver
                ], 200);
        }

        else{
            return response()->json([
               "status" => 401,
                "message" => "Driver failed to create successfully",
                "data" => $driver
                ], 401);
        }
    }

    public function update(Request $request) {
       $status = $message = "";

        $validator = Validator::make($request->all(), [
            'vendor_id' => 'exists:vendors,id',
            'driver_name' => 'unique:drivers,driver_name,'.$request->driver_id,
            'username' => 'unique:drivers,username,'.$request->driver_id,
            'phone_number' => 'unique:drivers,phone_number,'.$request->driver_id,
            'email' => 'unique:drivers,email,'.$request->driver_id
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Update driver failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $driver = Driver::find($request->driver_id);

        if($driver){
            if($request->vendor_id){
                $driver->vendor_id = $request->vendor_id;
            }

            if($request->driver_name){
                $driver->driver_name = $request->driver_name;
            }

            if($request->username){
                $driver->username = $request->username;
            }

            if($request->phone_number){
                $driver->phone_number = $request->phone_number;
            }

            if($request->email){
                $driver->email = $request->email;
            }

            if($request->ktp){
                $driver->ktp = $request->ktp;
            }

            if($request->status){
                $driver->status = $request->status;
            }

            if($request->address){
                $driver->address = $request->address;
            }

            if($request->image_ktp){
                $driver->image_ktp = $request->image_ktp;
            }

            if($request->image_sim){
                $driver->image_sim = $request->image_sim;
            }

            if($request->image_skck)
                $driver->image_skck = $request->image_skck;

            if($request->image_front){
                $driver->image_front = $request->image_front;
            }

            if($request->image_right){
                $driver->image_right = $request->image_right;
            }

            if($request->image_left){
                $driver->image_left = $request->image_left;
            }

            $driver->updated_by = $request->auth->id;

            $driver->update();
            
            $status = 200;
            $message = "Driver updated successfully";
        }

        else{
            $status = 410;
            $message = "Driver not found";
        }
        

        return response()->json([
           "status" => $status,
            "message" => $message,
            "data" => $driver
            ], $status);        
    }

    public function delete(Request $request) {
        $driver = Driver::find($request->driver_id);

        if($driver){
            $driver->deleted_by = $request->auth->id;
            $driver->save();
            $driver->delete();
            $status = 200;
            $message = "Driver deleted successfully";
        }

        else{
            $status = 401;
            $message = "Delete a driver failed";
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $driver
        ], $status);        
    }

    public function trash()
    {
        $driver = Driver::onlyTrashed()->get();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $driver
        ], 200);       
    }

    public function changePassword(Request $request)
    {
        $status = $message = "";
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required|exists:drivers,id',
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $token = null;

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Change password of driver failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $driver = Driver::find($request->driver_id);

        $hashed_old_password = $driver->password;
        if (Hash::check($request->current_password, $hashed_old_password )) {
            if (!Hash::check($request->new_password, $hashed_old_password)) {

              $driver->password = password_hash($request->new_password, PASSWORD_BCRYPT);
              $driver->update();
              $status = 200;
              $message = "Password updated successfully";
            }

            else{
              $status = 401;
              $message = "New password can not be the same with the old password";
            }

        }

        else{
            $status = 401;
            $message = "Old password does not matched";
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $driver
        ], $status);
    }
}

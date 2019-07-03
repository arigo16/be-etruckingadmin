<?php

namespace App\Http\Controllers;

use Validator;
use App\customer;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
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
       $customers = Customer::with('user_aliases')->get();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $customers
        ], 200);   
    }

    public function detail(Request $request) {
        $customer = Customer::with('user_aliases')->where('id', $request->customer_id)->first();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $customer
        ], 200);  
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'username' => 'unique:customers',
            'password' => 'required',
            'phone_number' => 'required|unique:customers',
            'email' => 'required|unique:customers',
            'ktp' => 'required|unique:customers'
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Create customer failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $customer = Customer::create([
            'customer_name' => $request->customer_name,
            'username' => $request->username,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'ktp' => $request->ktp,
            'status' => $request->status,
            'address' => $request->address,
            'image_ktp' => $request->image_ktp,
            'created_by' => $request->auth->id
        ]);

        if($customer){
            return response()->json([
               "status" => 200,
                "message" => "customer created successfully",
                "data" => $customer
                ], 200);
        }

        else{
            return response()->json([
               "status" => 401,
                "message" => "customer failed to create successfully",
                "data" => $customer
                ], 401);
        }
    }

    public function update(Request $request) {
       $status = $message = "";

        $validator = Validator::make($request->all(), [
            'customer_name' => 'unique:customers,customer_name,'.$request->customer_id,
            'username' => 'unique:customers,username,'.$request->customer_id,
            'phone_number' => 'unique:customers,phone_number,'.$request->customer_id,
            'email' => 'unique:customers,email,'.$request->customer_id
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Update customer failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $customer = Customer::find($request->customer_id);

        if($customer){
            if($request->customer_name){
                $customer->customer_name = $request->customer_name;
            }

            if($request->username){
                $customer->username = $request->username;
            }

            if($request->phone_number){
                $customer->phone_number = $request->phone_number;
            }

            if($request->email){
                $customer->email = $request->email;
            }

            if($request->ktp){
                $customer->ktp = $request->ktp;
            }

            if($request->status){
                $customer->status = $request->status;
            }

            if($request->address){
                $customer->address = $request->address;
            }

            if($request->image_ktp){
                $customer->image_ktp = $request->image_ktp;
            }

            if($request->image_sim){
                $customer->image_sim = $request->image_sim;
            }

            if($request->image_skck)
                $customer->image_skck = $request->image_skck;

            if($request->image_front){
                $customer->image_front = $request->image_front;
            }

            if($request->image_right){
                $customer->image_right = $request->image_right;
            }

            if($request->image_left){
                $customer->image_left = $request->image_left;
            }

            $customer->updated_by = $request->auth->id;

            $customer->update();
            
            $status = 200;
            $message = "customer updated successfully";
        }

        else{
            $status = 410;
            $message = "customer not found";
        }
        

        return response()->json([
           "status" => $status,
            "message" => $message,
            "data" => $customer
            ], $status);        
    }

    public function delete(Request $request) {
        $customer = Customer::find($request->customer_id);

        if($customer){
            $customer->deleted_by = $request->auth->id;
            $customer->save();
            $customer->delete();
            $status = 200;
            $message = "customer deleted successfully";
        }

        else{
            $status = 401;
            $message = "Delete a customer failed";
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $customer
        ], $status);        
    }

    public function trash()
    {
        $customer = Customer::onlyTrashed()->get();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $customer
        ], 200);       
    }

    public function changePassword(Request $request)
    {
        $status = $message = "";
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $token = null;

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Change password of customer failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $customer = Customer::find($request->customer_id);

        $hashed_old_password = $customer->password;
        if (Hash::check($request->current_password, $hashed_old_password )) {
            if (!Hash::check($request->new_password, $hashed_old_password)) {

              $customer->password = password_hash($request->new_password, PASSWORD_BCRYPT);
              $customer->update();
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
            "data" => $customer
        ], $status);
    }
}

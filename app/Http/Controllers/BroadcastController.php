<?php

namespace App\Http\Controllers;

use Validator;
use App\Broadcast;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;

class BroadcastController extends Controller
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
       $broadcasts = Broadcast::all();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $broadcasts
        ], 200);   
    }

    public function detail(Request $request) {
        $broadcast = Broadcast::find($request->broadcast_id);

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $broadcast
        ], 200);  
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:broadcasts',
            'short_desc' => 'required',
            'desc' => 'required',
            'banner_url' => 'required',
            'send_to' => 'required'
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Create broadcast failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $broadcast = Broadcast::create([
            'title' => $request->title,
            'short_desc' => $request->short_desc,
            'desc' => $request->desc,
            'banner_url' => $request->banner_url,
            'send_to' => $request->send_to,
            'created_by' => $request->auth->id
        ]);

        return response()->json([
           "status" => 200,
            "message" => "broadcast created successfully",
            "data" => $broadcast
            ], 200);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:broadcasts,title,'.$request->broadcast_id
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Update broadcast failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }
        
        $broadcast = Broadcast::find($request->broadcast_id);

        if($broadcast){
            if($request->title)
                $broadcast->title = $request->title;

            if($request->short_desc)
                $broadcast->short_desc = $request->short_desc;

            if($request->desc)
                $broadcast->desc = $request->desc;

            if($request->banner_url)
                $broadcast->banner_url = $request->banner_url;

            if($request->send_to)
                $broadcast->send_to = $request->send_to;

            $broadcast->updated_by = $request->auth->id;
            $broadcast->update();

            $status = 200;
            $message = "broadcast updated successfully";
        }

        else{
            $status = 410;
            $message = "broadcast not found";
        }
        

        return response()->json([
           "status" => $status,
            "message" => $message,
            "data" => $broadcast
            ], $status);        
    }

    public function delete(Request $request) {
        $broadcast = Broadcast::find($request->broadcast_id);

        if($broadcast){
            $broadcast->deleted_by = $request->auth->id;
            $broadcast->save();
            $broadcast->delete();
            $status = 200;
            $message = "broadcast deleted successfully";
        }

        else{
            $status = 401;
            $message = "Delete a broadcast failed";
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $broadcast
        ], $status);        
    }

    public function trash()
    {
        $broadcast = Broadcast::onlyTrashed()->get();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $broadcast
        ], 200);       
    }
}

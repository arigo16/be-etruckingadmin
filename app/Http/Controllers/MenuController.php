<?php

namespace App\Http\Controllers;

use Validator;
use App\Menu;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;

class MenuController extends Controller
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
       $menus = Menu::all();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $menus
        ], 200);   
    }

    public function detail(Request $request) {
        $menu = Menu::find($request->menu_id);

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $menu
        ], 200);  
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'menu_name' => 'required|unique:menus'
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Create menu failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $menu = Menu::create([
            'menu_name' => $request->menu_name,
            'created_by' => $request->auth->id
        ]);

        return response()->json([
           "status" => 200,
            "message" => "Menu created successfully",
            "data" => $menu
            ], 200);
    }

    public function update(Request $request) {
        $status = $message = "";

        $validator = Validator::make($request->all(), [
            'menu_name' => 'unique:menus,menu_name,'.$request->menu_id,
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Update menu failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $menu = Menu::find($request->menu_id);

        if($menu){
            if($request->menu_name)
                $menu->menu_name = $request->menu_name;

            $menu->updated_by = $request->auth->id;
            $menu->update();

            $status = 200;
            $message = "Menu updated successfully";
        }

        else{
            $status = 410;
            $message = "Menu not found";
        }
        

        return response()->json([
           "status" => $status,
            "message" => "$message",
            "data" => $menu
            ], 200);        
    }

    public function delete(Request $request) {
        $menu = Menu::find($request->menu_id);

        if($menu){
            $menu->deleted_by = $request->auth->id;
            $menu->save();
            $menu->delete();
            $status = 200;
            $message = "Menu deleted successfully";
        }

        else{
            $status = 401;
            $message = "Delete a menu failed";
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $menu
        ], $status);        
    }

    public function trash()
    {
        $menu = Menu::onlyTrashed()->get();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $menu
        ], 200);       
    }
}

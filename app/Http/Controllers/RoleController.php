<?php

namespace App\Http\Controllers;

use Validator;
use App\Role;
use App\RoleMenu;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use DB;

class RoleController extends Controller
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
       $roles = Role::with('menus')->get();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $roles
        ], 200);   
    }

    public function detail(Request $request) {
        $role = Role::where('id', $request->role_id)->with('menus')->first();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $role
        ], 200);  
    }

    public function create(Request $request) {
        DB::beginTransaction();

        $validator = Validator::make($request->all(), [
            'role_name' => 'required|unique:roles'
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Create role failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $role = Role::create([
            'role_name' => $request->role_name,
            'created_by' => $request->auth->id
        ]);

        if($request->menu_ids){
            foreach ($request->menu_ids as $key => $menu_id) {
                $user_role = new RoleMenu;
                $user_role->role_id = $role->id;
                $user_role->menu_id = $menu_id;
                $user_role->created_by = $request->auth->id;
                $user_role->save();                
            }
        }

        DB::commit();

        return response()->json([
            "status" => 200,
            "message" => "Role created successfully",
            "data" => array(
                "role" => $role,
                "menu" => $role->menus)
            ], 200);

    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'role_name' => 'unique:roles,role_name,'.$request->role_id,
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Update role failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $role = Role::find($request->role_id);

        if($request->role_name)
            $role->role_name = $request->role_name;

        $role->updated_by = $request->auth->id;
        $role->update();

        if($request->menu_ids){
            $menu = RoleMenu::where('role_id', $request->role_id)->delete();
            foreach ($request->menu_ids as $key => $menu_id) {
                $role_menu = new RoleMenu;
                $role_menu->role_id = $role->id;
                $role_menu->menu_id = $menu_id;
                $role_menu->created_by = $request->auth->id;
                $role_menu->save();                
            }
        }

        return response()->json([
           "status" => 200,
            "message" => "Role updated successfully",
            "data" => $role
            ], 200);        
    }

    public function delete(Request $request) {
        $role = Role::find($request->role_id);

        if($role){
            $role->deleted_by = $request->auth->id;
            $role->save();
            $role->delete();
            $status = 200;
            $message = "Role deleted successfully";
        }

        else{
            $status = 401;
            $message = "Delete a role failed";
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $role
        ], $status);        
    }

    public function trash()
    {
        $role = Role::onlyTrashed()->get();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $role
        ], 200);       
    }
}

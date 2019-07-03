<?php

namespace App\Http\Controllers;
use Validator;
use App\User;
use App\UserRole;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use DB;

class AuthController extends Controller
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

    protected function jwt(User $user) {
        $payload = [
            'iss' => "etrucking-secure", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*1440 // Expiration time
        ];
         
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function register(Request $request)
    {
        DB::beginTransaction();

        $validator = Validator::make($request->all(), [
            'user_role_id' => 'required',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',

        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Create user failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $user = User::create([
            'user_role_id' => $request->user_role_id,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'user_phone' => $request->user_phone,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
            'user_image' => $request->user_image,
            'vendor_id' => $request->vendor_id,
            'created_by' => $request->auth->id
        ]);

        $token = $this->jwt($user);

        $user_role = new UserRole;
        $user_role->user_id = $user->id;
        $user_role->role_id = $request->user_role_id;
        $user_role->created_by = $request->auth->id;
        $user_role->save();

        DB::commit();

        return response()->json([
           "status" => 200,
            "message" => "User created successfully",
            "data" => array(
                "token" => $token,
                "user" => $user,
                "role" => $user->roles)
            ], 200);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required'
        ]);

        $token = $status = $message = null;

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Login user failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        if(filter_var($request->login, FILTER_VALIDATE_EMAIL)){
            $user = User::where('email', $request->login)->first();
        } else {
            $user = User::where('username', $request->login)->first();
        }


        if (!$user) {
            $status = 400;
            $message = "invalid credentials";
        }

        else{
            // Verify the password and generate the token
            if (Hash::check($request->password, $user->password)) {
                $status = 200;
                $message = "token created";
                $token = $this->jwt($user);
            }
            else{
                $status = 401;
                $message = "Invalid credentials";
            }
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => array(
                "token" => $token,
                "user" => $user)
        ], $status);
    }

    public function list() {
        $users = User::with('roles')->get();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $users
        ], 200);        
    }

    public function detail(Request $request) {
        $user = User::where('id', $request->user_id)->with('roles')->first();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $user
        ], 200);  
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'string|max:255|unique:users,username,'.$request->user_id,
            'email' => 'string|email|max:255|unique:users,email,'.$request->user_id,
        ]);

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Update user failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $user = User::find($request->user_id);

        if($request->user_role_id)
            $user->user_role_id = $request->user_role_id;

        if($request->name)
            $user->name = $request->name;

        if($request->username)
            $user->username = $request->username;

        if($request->email)
            $user->email = $request->email;

        if($request->user_phone)
            $user->user_phone = $request->user_phone;

        if($request->user_image)
            // $user->password = password_hash($request->password, PASSWORD_BCRYPT);
            $user->user_image = $request->user_image;

        if($request->vendor_id)
            $user->vendor_id = $request->vendor_id;

        $user->updated_by = $request->auth->id;

        $user->update();

        return array(
            "status" => 200,
            "message" => "User updated successfully",
            "data" => array(
                "user" => $user
            )
        );        
    }

    public function delete(Request $request) {
        $user = User::find($request->user_id);

        if($user){
            $user->deleted_by = $request->auth->id;
            $user->save();
            $user->delete();
            $status = 200;
            $message = "User deleted successfully";
        }

        else{
            $status = 401;
            $message = "Delete a user failed";
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $user
        ], $status);
    }

    public function trash()
    {
        $user = User::onlyTrashed()->get();

        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $user
        ], 200);       
    }

    public function changePassword(Request $request)
    {
        $status = $message = "";
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $token = null;

        if($validator->fails()){
            return array(
                "status" => 401,
                "message" => "Change password of user failed",
                "data" => array(
                    "error" => array_map(function($values) {
                                    return join(',', $values);
                                }, array_values($validator->errors()->toArray()))
                )
            );
        }

        $user = User::find($request->user_id);

        $hashed_old_password = $user->password;
        if (Hash::check($request->current_password, $hashed_old_password )) {
            if (!Hash::check($request->new_password, $hashed_old_password)) {

              $user->password = password_hash($request->new_password, PASSWORD_BCRYPT);
              $user->update();
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
            "data" => $user
        ], $status);
    }
}

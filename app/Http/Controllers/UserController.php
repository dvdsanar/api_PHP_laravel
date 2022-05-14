<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  public function getAllusers()
  {
    try {
        Log::info('Get users');
        $user = User::all(); 

        if(empty($user)){
            return response()->json(
                [
                    "success" => "Users are empty"
                ], 202
            );
        };

        Log::info('Get users');

        return response()->json($user, 200);

    } catch (\Throwable $th) {
        Log::error('Failed to get users->'.$th->getMessage());

        return response()->json([ 'error'=> 'Error, try again!'], 500);
    }
    }

    public function getusersById($id)
    {
        try {
            Log::info('Get user by Id');
            $user = DB::table('users')->where('id',$id)->get();

            if(empty($user)){
                return response()->json(
                    [
                        "error" => "user not exists"
                    ],404
                );
            };
            return response()->json($user, 200);
        } catch (\Throwable $th) {
            Log::error('Failed, can not get user -> '.$th->getMessage());

            return response()->json([ 'error'=> 'Error, try again!'], 500);
        }
    }

    public function createNewUser(Request $request)
    {
        try {
            Log::info('Creating User');
            $validator = Validator::make($request->all(), [  
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
                'alias'=> 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 404);
            };

            $newUser = new User();  
            $newUser->name = $request->name;
            $newUser->email=$request->email;
            $newUser->password=$request->password;
            $newUser->alias=$request->alias;                                     
            
            $newUser->save();

        return response()->json(["data"=>$newUser, "success"=>'User created'], 200);

        } catch (\Throwable $th) {
            Log::error('Failed can not create user->'.$th->getMessage());

            return response()->json([ 'error'=> 'Error, try again!'], 500);
        }
    }

    public function updateUserById(Request $request, $id)
    {
        try {
            Log::info('Update user');
           $validator = Validator::make($request->all(), [  
            'name' => 'string|max:100',
            'email' => 'email',
            'password' => 'string',
            'alias' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        };
        
        $user = User::where('id',$id)->first();
        if(empty($user)){
            return response()->json(["error"=> "user not exists"], 404);
        };

        if(isset($request->name)){
            $user->name = $request->name;
        };

        if(isset($request->email)){
            $user->email = $request->email;
        };

        if(isset($request->password)){
            $user->password = $request->password;
        };

        if(isset($request->alias)){
            $user->alias = $request->alias;
        };

        $user->save();

        return response()->json(["data"=>$user, "success"=>'User updated'], 200);

        } catch (\Throwable $th) {
            Log::error('Failed can not update user -> '.$th->getMessage());
            return response()->json([ 'error'=> 'Error, try again!'], 500);
        }
    }

    public function deleteUserById ($id)
    {
        try {
            Log::info('Delete user');
            $user = User::where('id',$id)->first();

            if(empty($user)){
                return response()->json(["error"=> "user not exists"], 404);
            };
            
            $user->delete();

            return response()->json(["data"=> "User deleted"], 200);

        } catch (\Throwable $th) {
            Log::error('Failed can not delete user->'.$th->getMessage());
            return response()->json([ 'error'=> 'Error, try again!'], 500);
        }
    }
}

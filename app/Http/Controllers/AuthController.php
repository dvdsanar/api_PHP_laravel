<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request){
    try {
        Log::info('Register');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
            'alias' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->password),
            'alias' => $request->get('alias'),
        ]);

        $token = JWTAuth::fromUser($user);
        
        return response()->json(compact('user','token'),201);

    } catch (\Throwable $th) {
        Log::error('Fail, can not register User -> ' . $th->getMessage());
        
        return response()->json(['error' => 'Error from User register'],201);

    }
    }

    public function login(Request $request)
    {
        try {
            $input = $request->only('email', 'password');
            $jwt_token = null;

            if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
            'success' => false,
            'message' => 'Invalid Email or Password',
            ], Response::HTTP_UNAUTHORIZED);
            }

            return response()->json([
            'success' => true,
            'token' => $jwt_token,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error wrong user or password'],201);
        }
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
        'token' => 'required'
        ]);

        try {
            Log::info('Init Logout');

            JWTAuth::invalidate($request->token);
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (\Exception $exception) {
        Log::error('failed to Login User->' . $exception->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Sorry, the user cannot be logged out'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function profile()
    {
        try {
            return response()->json(auth()->user());
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error de Registro de usuario'],201);
        }
        
    }
}

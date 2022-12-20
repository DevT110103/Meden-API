<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function _construct()
    {
        $this->middleware('auth:api', ['expect' => ['login', 'register']]);
    }

    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'full_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'role_id' => 'int',
            'address' => 'required|string',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'err' => true,
                'msg' => $validator->errors()->toJson(),
                'data' => [],
            ], 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($req->password)]
        ));

        return response()->json([
            'message' => 'User Success Registered',
            'user' => $user,
        ], 201);
    }

    public function login(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'err' => true,
                'msg' => $validator->errors(),
                'data' => [],
            ], 422);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json([
                'status' => 401,
                'err' => true,
                'msg' => 'UnAuthorized',
                'data' => [],
            ], 401);
        }

        return $this->createNewToken($token);

    }

    protected function createNewToken($token)
    {
        return response()->json([
            'status' => 200,
            'err' => false,
            'msg' => 'Create token success',
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'user' => auth()->user(),
            ],
        ]);
    }

    public function profile(Request $req)
    {
        return response()->json([
            'status' => 200,
            'err' => false,
            'msg' => 'Profile user',
            'data' => [
                'user' => auth()->user(),
            ],
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'status' => 200,
            'err' => false,
            'msg' => 'Logout Success',
            'data' => [],
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $userList = User::query()->get();

        return response()->json([
            'status' => 200,
            'err' => false,
            'msg' => 'Get all users success',
            'data' => $userList,
        ]);
    }

    public function show(Request $request)
    {
        $id = $request->query('id');
        trim($id);
        if ($id) {
            $user = User::find($id);
            if (is_null($user)) {
                return response()->json([
                    'status' => 200,
                    'err' => true,
                    'msg' => 'User not found',
                    'data' => [],
                ], 404);
            } else {

                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Get user success',
                    'data' => $user,
                ]);
            }

        } else {
            return response()->json([
                'status' => 400,
                'err' => true,
                'msg' => 'Id not null',
                'data' => [],
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $id = $request->query('id');

        trim($id);

        if ($id) {
            $user = User::find($id);

            if (is_null($user)) {
                return response()->json([
                    'status' => 200,
                    'err' => true,
                    'msg' => 'User not found',
                    'data' => [],
                ], 404);
            } else {

                $validate = Validator::make($request->all(), [
                    'full_name' => 'required|string',
                    'role_id' => 'required|int',
                ]);

                if ($validate->fails()) {
                    return response()->json([
                        'status' => 400,
                        'err' => true,
                        'msg' => 'failed',
                        'data' => [],
                    ], 400);
                } else {

                    $fullName = $request->get('full_name');
                    $roleId = $request->get('role_id');

                    $user['full_name'] = $fullName;
                    $user['role_id'] = $roleId;
                    $user->save();
                    $userList = User::query()->get();
                    return response()->json([
                        'status' => 200,
                        'err' => false,
                        'msg' => 'Get user success',
                        'data' => $userList,
                    ]);
                }
            }
        } else {
            return response()->json([
                'status' => 400,
                'err' => true,
                'msg' => 'Id not null',
                'data' => [],
            ], 400);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->query('id');

        trim($id);

        if ($id) {
            $user = User::find($id);
            if (is_null($user)) {
                return response()->json([
                    'status' => 200,
                    'err' => true,
                    'msg' => 'User not found',
                    'data' => [],
                ], 404);
            } else {
                User::destroy($id);
                $userList = User::query()->get();
                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Delete user success',
                    'data' => $userList,
                ]);
            }

        } else {
            return response()->json([
                'status' => 400,
                'err' => true,
                'msg' => 'Id and name not null',
                'data' => [],
            ], 400);
        }
    }
}

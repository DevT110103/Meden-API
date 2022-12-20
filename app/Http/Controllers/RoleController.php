<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index()
    {
        $roleList = Role::query()->get();

        return response()->json([
            'status' => 200,
            'err' => false,
            'msg' => 'Get all roles success',
            'data' => $roleList,
        ]);
    }

    public function store(Request $request)
    {
        $name = $request->get('name');
        trim($name);
        if ($name) {
            $isUnique = Role::query()->get('name')->where('name', $name);

            if (count($isUnique) != 0) {
                return response()->json([
                    'status' => 400,
                    'err' => true,
                    'msg' => 'Role name is unique',
                    'data' => [],
                ], 400);
            } else {
                $role = new Role();
                $role->name = $name;
                $role->save();

                $roleList = Role::query()->get();

                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Create Role Success',
                    'data' => $roleList,
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'err' => true,
                'msg' => 'Role name cannot be empty',
                'data' => [],
            ], 400);
        }

    }

    public function show(Request $request)
    {
        $id = $request->query('id');
        trim($id);
        if ($id) {
            $role = Role::find($id);
            if (is_null($role)) {
                return response()->json([
                    'status' => 200,
                    'err' => true,
                    'msg' => 'Role not found',
                    'data' => [],
                ], 404);
            } else {

                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Get role success',
                    'data' => $role,
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
        $name = $request->get('name');
        trim($id);
        trim($name);
        if ($id && $name) {
            $role = Role::find($id);
            if (is_null($role)) {
                return response()->json([
                    'status' => 200,
                    'err' => true,
                    'msg' => 'Role not found',
                    'data' => [],
                ], 404);
            } else {
                $role->name = $name;
                $role->save();
                $roleList = Role::query()->get();
                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Get role success',
                    'data' => $roleList,
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

    public function destroy(Request $request)
    {
        $id = $request->query('id');

        trim($id);

        if ($id) {
            $role = Role::find($id);
            if (is_null($role)) {
                return response()->json([
                    'status' => 200,
                    'err' => true,
                    'msg' => 'Role not found',
                    'data' => [],
                ], 404);
            } else {
                Role::destroy($id);
                $roleList = Role::query()->get();
                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Delete role success',
                    'data' => $roleList,
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

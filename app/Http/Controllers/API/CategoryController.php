<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function getAllCategories(Request $req, Response $res)
    {
        $categories = Categories::query()->get();

        return response()->json([
            'status' => 200,
            'error' => false,
            'message' => 'Get All Categories Success',
            'data' => $categories]);
    }

    public function createCategory(Request $req)
    {
        $name = $req->get('name');
        trim($name);
        if (!$name) {
            return response()->json([
                'status' => 400,
                'error' => true,
                'message' => 'Name category is valid',
                'data' => [],
            ]);
        } else {
            $obj = new Categories();
            $obj->name = $req->get('name');
            $obj->save();

            return response()->json([
                'status' => 200,
                'error' => false,
                'message' => 'Create success',
                'data' => $obj->query()->get(),
            ]);
        }
    }

    public function getEditCategory(Request $req)
    {
        $id = $req->query('id');
        if ($id) {
            $category = Categories::find($id);

            if ($category) {
                return response()->json([
                    'status' => 200,
                    'error' => false,
                    'message' => 'Get category success!!',
                    'data' => $category,
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'error' => true,
                    'message' => 'Category not found',
                    'data' => [],
                ], 404);
            }
        }
    }

    public function putEditCategory(Request $req)
    {
        $id = $req->query('id');
        echo ($id);
        $name = $req->get('name');
        trim($name);
        trim($id);

        if ($id && $name) {
            $category = Categories::find($id);

            $category->name = $name;

            $category->save();

            return response()->json([
                'status' => 200,
                'error' => false,
                'message' => 'Update success!!',
                'data' => $category,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'error' => true,
                'message' => 'Error',
                'data' => [],
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req)
    {
        $id = $req->query('id');

        if ($id) {
            $category = DB::table('categories')->delete($id);
            if ($category == 0) {
                return response()->json([
                    'status' => 400,
                    'error' => true,
                    'message' => 'Failed id not found',
                    'data' => [],
                ], 400);
            }

            $categories = DB::table('categories')->get();
            return response()->json([
                'status' => 200,
                'error' => false,
                'message' => 'Deleted success',
                'data' => $categories,
            ]);
        }
    }
}

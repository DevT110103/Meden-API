<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $id = $request->id;
        if (trim($id)) {
            $product = Product::find($id);
            if (is_null($product)) {
                return response()->json([
                    'status' => 404,
                    'err' => true,
                    'msg' => 'Product not found',
                    'data' => [],
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Get product success',
                    'data' => $product,
                ]);
            }

        } else {

            $productList = Product::query()->get();

            return response()->json([
                'status' => 200,
                'err' => false,
                'msg' => 'Get all products success',
                'data' => $productList,
            ]);
        }

    }

    public function store(Request $request)
    {
        $title = $request->get('title');
        $category_id = $request->get('category_id');
        $sub_title = $request->get('sub_title');
        $desc = $request->get('desc');

        $validate = Validator::make($request->all(), [
            'title' => 'required|string',
            'category_id' => 'required|int',
            'sub_title' => 'string',
            'desc' => 'string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'err' => false,
                'msg' => 'Value is valid',
                'data' => [],
            ], 400);
        } else {
            if ($request->has('thumbnail')) {

                $file = $request->thumbnail;
                $extension = $request->thumbnail->extension();
                $thumbnailName = time() . '-' . 'product' . '.' . $extension;
                $file->move(public_path('uploads'), $thumbnailName);
                $request->merge(['thumbnail' => $thumbnailName]);

                $product = new Product();
                $product->title = trim($title);
                $product->category_id = trim($category_id);
                $product->sub_title = trim($sub_title);
                $product->desc = trim($desc);
                if (env('APP_ENV') == 'local') {
                    $product->thumbnail = env('APP_URL') . ':' . env('APP_PORT') . '/uploads/' . $thumbnailName;
                } else {
                    $product->thumbnail = env('APP_URL') . '/uploads/' . $thumbnailName;
                }
                $product->save();

                $productList = Product::query()->get();

                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Create Role Success',
                    'data' => $productList,
                ]);
            } else {
                $product = new Product();
                $product->title = trim($title);
                $product->category_id = trim($category_id);
                $product->sub_title = trim($sub_title);
                $product->desc = trim($desc);
                if (env('APP_ENV') == 'local') {
                    $product->thumbnail = env('APP_URL') . ':' . env('APP_PORT') . '/err/err.png';
                } else {
                    $product->thumbnail = env('APP_URL') . '/err/err.png';
                }
                $product->save();

                $productList = Product::query()->get();
                return response()->json([
                    'status' => 400,
                    'err' => true,
                    'msg' => 'fails ',
                    'data' => $productList,
                ]);
            }

        }

    }

    public function update(Request $request)
    {
        $id = $request->query('id');

        if ($id) {
            $product = Product::find($id);
            if (is_null($product)) {
                return response()->json([
                    'status' => 200,
                    'err' => true,
                    'msg' => 'id not found',
                    'data' => [],
                ], 404);
            } else {

                $validate = Validator::make($request->all(), [
                    'title' => 'required|string',
                    'sub_title' => 'string|nullable',
                    'category_id' => 'required|int',
                    'desc' => 'string',
                ]);

                if ($validate->fails()) {
                    return response()->json([
                        'status' => 400,
                        'err' => true,
                        'msg' => 'Is valid',
                        'data' => [],
                    ], 400);
                } else {

                    $title = $request->get('title');
                    $sub_title = $request->sub_title;
                    $category_id = $request->category_id;
                    $desc = $request->desc;

                    if ($request->has('thumbnail')) {
                        $product = Product::find($id);

                        $nameImg = substr($product->thumbnail, -22);
                        $path = 'uploads' . '/' . $nameImg;
                        if (File::exists($path)) {
                            File::delete(public_path($path));
                        }

                        $file = $request->thumbnail;
                        $extension = $request->thumbnail->extension();
                        $thumbnailName = time() . '-' . 'product' . '.' . $extension;
                        $file->move(public_path('uploads'), $thumbnailName);
                        $request->merge(['thumbnail' => $thumbnailName]);

                        $product->title = $title;
                        $product->sub_title = $sub_title;
                        $product->category_id = $category_id;
                        $product->desc = $desc;
                        if (env('APP_ENV') == 'local') {
                            $product->thumbnail = env('APP_URL') . ':' . env('APP_PORT') . '/uploads/' . $thumbnailName;
                        } else {
                            $product->thumbnail = env('APP_URL') . '/uploads/' . $thumbnailName;
                        }

                        $product->save();

                        $product = Product::query()->get();

                        return response()->json([
                            'status' => 200,
                            'err' => false,
                            'msg' => 'Get product success',
                            'data' => $product,
                        ]);
                    } else {
                        $product = Product::find($id);
                        $product->title = $title;
                        $product->sub_title = $sub_title;
                        $product->category_id = $category_id;
                        $product->desc = $desc;
                        $product->save();

                        $product = Product::all();

                        return response()->json([
                            'status' => 200,
                            'err' => false,
                            'msg' => 'Get product success',
                            'data' => $product,
                        ]);
                    }
                }
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
            $product = Product::find($id);
            if (is_null($product)) {
                return response()->json([
                    'status' => 200,
                    'err' => true,
                    'msg' => 'Role not found',
                    'data' => [],
                ], 404);
            } else {
                $nameThumbnail = substr($product->thumbnail, -22);
                $path = 'uploads' . '/' . $nameThumbnail;
                if (File::exists($path)) {
                    File::delete(public_path($path));
                }

                Product::destroy($id);
                $productList = Product::query()->get();
                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Delete pr$product success',
                    'data' => $productList,
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

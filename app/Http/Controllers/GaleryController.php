<?php

namespace App\Http\Controllers;

use App\Models\Galery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class GaleryController extends Controller
{

    public function index()
    {
        $galeryList = Galery::all();

        return response()->json([
            'status' => 200,
            'err' => false,
            'msg' => 'Get all galeries success',
            'data' => $galeryList,
        ]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'product_id' => 'required|int',
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
                $thumbnailName = time() . '-' . 'galery' . '.' . $extension;
                $file->move(public_path('uploads'), $thumbnailName);
                $request->merge(['thumbnail' => $thumbnailName]);

                $product_id = $request->product_id;

                $galery = new Galery();
                $galery->product_id = trim($product_id);
                if (env('APP_ENV') == 'local') {
                    $galery->thumbnail = env('APP_URL') . ':' . env('APP_PORT') . '/uploads/' . $thumbnailName;
                } else {
                    $galery->thumbnail = env('APP_URL') . '/uploads/' . $thumbnailName;
                }

                $galery->save();

                $galeryList = Galery::all();

                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Create galery Success',
                    'data' => $galeryList,
                ]);
            } else {
                $product_id = $request->product_id;

                $galery = new Galery();
                $galery->product_id = trim($product_id);
                if (env('APP_ENV') == 'local') {
                    $galery->thumbnail = env('APP_URL') . ':' . env('APP_PORT') . '/err/err.png';
                } else {
                    $galery->thumbnail = env('APP_URL') . '/err/err.png';
                }
                $galery->save();

                $galeryList = Galery::all();

                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Create galery Success',
                    'data' => $galeryList,
                ]);
            }

        }

    }

    public function show(Request $request)
    {
        $id = $request->query('id');
        trim($id);
        if ($id) {
            $galery = Galery::find($id);
            if (is_null($galery)) {
                return response()->json([
                    'status' => 404,
                    'err' => false,
                    'msg' => 'Role not found',
                    'data' => [],
                ], 404);
            } else {

                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Get galery success',
                    'data' => $galery,
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

        if ($id) {
            $galery = Galery::find($id);
            if (is_null($galery)) {
                return response()->json([
                    'status' => 200,
                    'err' => true,
                    'msg' => 'Role not found',
                    'data' => [],
                ], 404);
            } else {

                $validate = Validator::make($request->all(), [
                    'product_id' => 'int',
                ]);

                if ($validate->fails()) {
                    return response()->json([
                        'status' => 400,
                        'err' => true,
                        'msg' => 'Is valid',
                        'data' => [],
                    ], 400);
                } else {

                    if ($request->has('thumbnail')) {

                        $galery = Galery::find($id);

                        $nameImg = substr($galery->thumbnail, -21);
                        $path = 'uploads' . '/' . $nameImg;
                        if (File::exists($path)) {
                            File::delete(public_path($path));
                        }

                        $file = $request->thumbnail;
                        $extension = $request->thumbnail->extension();
                        $thumbnailName = time() . '-' . 'galery' . '.' . $extension;
                        $file->move(public_path('uploads'), $thumbnailName);
                        $request->merge(['thumbnail' => $thumbnailName]);

                        $product_id = $request->product_id;

                        $galery->product_id = $product_id;
                        if (env('APP_ENV') == 'local') {
                            $galery->thumbnail = env('APP_URL') . ':' . env('APP_PORT') . '/uploads/' . $thumbnailName;
                        } else {
                            $galery->thumbnail = env('APP_URL') . '/uploads/' . $thumbnailName;
                        }

                        $galery->save();

                        $galeryList = Galery::all();

                        return response()->json([
                            'status' => 200,
                            'err' => false,
                            'msg' => 'Get galery success',
                            'data' => $galeryList,
                        ]);
                    } else {
                        $product_id = $request->product_id;

                        $galery = Galery::find($id);
                        $galery->product_id = $product_id;

                        $galery->save();

                        $galery = Galery::query()->get();

                        return response()->json([
                            'status' => 200,
                            'err' => false,
                            'msg' => 'Get galery success',
                            'data' => $galery,
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
            $galery = Galery::find($id);
            if (is_null($galery)) {
                return response()->json([
                    'status' => 200,
                    'err' => true,
                    'msg' => 'Role not found',
                    'data' => [],
                ], 404);
            } else {

                $nameThumbnail = substr($galery->thumbnail, -21);
                $path = 'uploads' . '/' . $nameThumbnail;
                if (File::exists($path)) {
                    File::delete(public_path($path));
                }

                Galery::destroy($id);
                $galeryList = Galery::query()->get();
                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Delete galery success',
                    'data' => $galeryList,
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

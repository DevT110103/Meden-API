<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    public function index(Request $request)
    {

        $id = $request->id;
        if (trim($id)) {
            $content = Content::find($id);
            if (is_null($content)) {
                return response()->json([
                    'status' => 404,
                    'err' => true,
                    'msg' => 'Content not found',
                    'data' => [],
                ], 404);
            } else {
                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Get content success',
                    'data' => $content,
                ]);
            }

        } else {

            $contentList = Content::query()->get();

            return response()->json([
                'status' => 200,
                'err' => false,
                'msg' => 'Get all contents success',
                'data' => $contentList,
            ]);
        }

    }

    public function store(Request $request)
    {
        $title = $request->title;
        $product_id = $request->product_id;
        $sub_title = $request->sub_title;
        $desc = $request->desc;

        $validate = Validator::make($request->all(), [
            'title' => 'required|string',
            'product_id' => 'required|int',
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
                $thumbnailName = time() . '-' . 'content' . '.' . $extension;
                $file->move(public_path('uploads'), $thumbnailName);
                $request->merge(['thumbnail' => $thumbnailName]);

                $content = new Content();
                $content->title = trim($title);
                $content->product_id = trim($product_id);
                $content->sub_title = trim($sub_title);
                $content->desc = trim($desc);
                if (env('APP_ENV') == 'local') {
                    $content->thumbnail = env('APP_URL') . ':' . env('APP_PORT') . '/uploads/' . $thumbnailName;
                } else {
                    $content->thumbnail = env('APP_URL') . '/uploads/' . $thumbnailName;
                }
                $content->save();

                $contentList = Content::query()->get();

                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Create Role Success',
                    'data' => $contentList,
                ]);

            } else {

                $content = new Content();
                $content->title = trim($title);
                $content->product_id = trim($product_id);
                $content->sub_title = trim($sub_title);
                $content->desc = trim($desc);
                if (env('APP_ENV') == 'local') {
                    $content->thumbnail = env('APP_URL') . ':' . env('APP_PORT') . '/err/err.png';
                } else {
                    $content->thumbnail = env('APP_URL') . '/err/err.png';
                }
                $content->save();

                $contentList = Content::query()->get();
                return response()->json([
                    'status' => 400,
                    'err' => true,
                    'msg' => 'Create success',
                    'data' => $contentList,
                ]);
            }

        }

    }

    public function update(Request $request)
    {
        $id = $request->query('id');

        if ($id) {
            $content = Content::find($id);
            if (is_null($content)) {
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
                    'product_id' => 'required|int',
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
                    $product_id = $request->product_id;
                    $desc = $request->desc;

                    if ($request->has('thumbnail')) {
                        $content = Content::find($id);

                        $nameImg = substr($content->thumbnail, -22);
                        $path = 'uploads' . '/' . $nameImg;
                        if (File::exists($path)) {
                            File::delete(public_path($path));
                        }

                        $file = $request->thumbnail;
                        $extension = $request->thumbnail->extension();
                        $thumbnailName = time() . '-' . 'content' . '.' . $extension;
                        $file->move(public_path('uploads'), $thumbnailName);
                        $request->merge(['thumbnail' => $thumbnailName]);

                        $content->title = $title;
                        $content->sub_title = $sub_title;
                        $content->product_id = $product_id;
                        $content->desc = $desc;
                        if (env('APP_ENV') == 'local') {
                            $content->thumbnail = env('APP_URL') . ':' . env('APP_PORT') . '/uploads/' . $thumbnailName;
                        } else {
                            $content->thumbnail = env('APP_URL') . '/uploads/' . $thumbnailName;
                        }

                        $content->save();

                        $content = Content::query()->get();

                        return response()->json([
                            'status' => 200,
                            'err' => false,
                            'msg' => 'Get content success',
                            'data' => $content,
                        ]);
                    } else {
                        $content = Content::find($id);
                        $content->title = $title;
                        $content->sub_title = $sub_title;
                        $content->product_id = $product_id;
                        $content->desc = $desc;
                        $content->save();

                        $content = Content::all();

                        return response()->json([
                            'status' => 200,
                            'err' => false,
                            'msg' => 'Get content success',
                            'data' => $content,
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
            $content = Content::find($id);
            if (is_null($content)) {
                return response()->json([
                    'status' => 200,
                    'err' => true,
                    'msg' => 'Role not found',
                    'data' => [],
                ], 404);
            } else {
                $nameThumbnail = substr($content->thumbnail, -22);
                $path = 'uploads' . '/' . $nameThumbnail;
                if (File::exists($path)) {
                    File::delete(public_path($path));
                }

                Content::destroy($id);
                $contentList = Content::query()->get();
                return response()->json([
                    'status' => 200,
                    'err' => false,
                    'msg' => 'Delete pr$content success',
                    'data' => $contentList,
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

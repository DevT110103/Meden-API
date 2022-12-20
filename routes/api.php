<?php

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['middleware' => ['api', 'cors', 'authentication', 'authorization'], 'prefix' => 'role'], function ($request) {
//     Route::get('/', [RoleController::class, 'index']);
//     Route::post('/create', [RoleController::class, 'store']);
//     Route::get('/edit/', [RoleController::class, 'show']);
//     Route::put('/edit/', [RoleController::class, 'update']);
//     Route::delete('/delete/', [RoleController::class, 'destroy']);
// });

// Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
//     Route::post('/register', [AuthController::class, 'register']);
//     Route::post('/login', [AuthController::class, 'login']);
//     Route::get('/profile', [AuthController::class, 'profile'])->middleware('authentication');
//     Route::post('/logout', [AuthController::class, 'logout'])->middleware('authentication');
// });

// Route::group(['middleware' => ['api', 'cors', 'authentication', 'authorization'], 'prefix' => 'user'], function ($request) {
//     Route::get('/', [UserController::class, 'index']);
//     Route::get('/edit/', [UserController::class, 'show']);
//     Route::put('/edit/', [UserController::class, 'update']);
//     Route::delete('/delete/', [UserController::class, 'destroy']);
// });

// Route::group(['middleware' => ['api', 'cors', 'authentication', 'authorization'], 'prefix' => 'category'], function ($router) {
//     Route::get('/get-all-category', [CategoryController::class, 'getAllCategories']);
//     Route::post('/create', [CategoryController::class, 'createCategory']);
//     Route::delete('/delete', [CategoryController::class, 'destroy']);
//     Route::get('/edit/', [CategoryController::class, 'getEditCategory']);
//     Route::put('/edit/', [CategoryController::class, 'putEditCategory']);
// });

// Route::group(['middleware' => ['api', 'cors', 'authentication', 'authorization'], 'prefix' => 'galery'], function ($request) {
//     Route::get('/', [GaleryController::class, 'index']);
//     Route::post('/create', [GaleryController::class, 'store']);
//     Route::get('/edit/', [GaleryController::class, 'show']);
//     Route::post('/edit/', [GaleryController::class, 'update']);
//     Route::delete('/delete/', [GaleryController::class, 'destroy']);
// });

// Route::group(['middleware' => ['api', 'cors', 'authentication', 'authorization'], 'prefix' => 'product'], function ($request) {
//     Route::get('/', [ProductController::class, 'index']);
//     Route::post('/create', [ProductController::class, 'store']);
//     Route::post('/edit/', [ProductController::class, 'update']);
//     Route::delete('/delete/', [ProductController::class, 'destroy']);
// });

// Route::group(['middleware' => ['api', 'cors', 'authentication', 'authorization'], 'prefix' => 'content'], function ($request) {
//     Route::get('/', [ContentController::class, 'index']);
//     Route::post('/create', [ContentController::class, 'store']);
//     Route::get('/edit/', [ContentController::class, 'show']);
//     Route::delete('/delete/', [ContentController::class, 'destroy']);
// });

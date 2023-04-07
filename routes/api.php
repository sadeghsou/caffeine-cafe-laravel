<?php

use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// function notFound($message = 'Not Found')
// {
//     return response()->json([
//         'data' => null,
//         'meta' => [
//             'status' => 404,
//             'messages' => $message
//         ]
//     ], 200);
// };

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'file'], function () {
    Route::post('/', [FileController::class, 'uploadFile'])->name('api.file.create');
    Route::get('/{file}', [FileController::class, 'getOneFile'])->whereNumber('file')->name('api.file.get.one'); //->missing(fn () => notFound('File Not Found'));
    Route::get('/', [FileController::class, 'getAllFiles'])->name('api.file.get.all');
    Route::delete('/{file}', [FileController::class, 'deleteFile'])->whereNumber('file')->name('api.file.delete'); //->missing(fn () => notFound('File Not Found'));
});

Route::group(['prefix' => 'category'], function () {
    Route::post('/', [CategoryController::class, 'createCategory'])->name('api.category.create');
    Route::get('/{category}', [CategoryController::class, 'getOneCategory'])->whereNumber('category')->name('api.category.get.one'); //->missing(fn () => notFound('Category Not Found'));
    Route::get('/', [CategoryController::class, 'getAllCategories'])->name('api.category.get.all');
    Route::put('/{category}', [CategoryController::class, 'editCategory'])->whereNumber('category')->name('api.category.edit'); //->missing(fn () => notFound('Category Not Found'));
    Route::delete('/{category}', [CategoryController::class, 'deleteCategory'])->whereNumber('category')->name('api.category.delete'); //->missing(fn () => notFound('Category Not Found'));
});

Route::group(['prefix' => 'product'], function () {
    Route::post('/', [ProductController::class, 'createProduct'])->name('api.product.create');
    Route::get('/{product}', [ProductController::class, 'getOneProduct'])->whereNumber('product')->name('api.product.get.one'); //->missing(fn () => notFound('Product Not Found'));
    Route::get('/', [ProductController::class, 'getAllProducts'])->name('api.product.get.all');
    Route::put('/{product}', [ProductController::class, 'editProduct'])->whereNumber('product')->name('api.product.edit'); //->missing(fn () => notFound('Product Not Found'));
    Route::delete('/{product}', [ProductController::class, 'deleteProduct'])->whereNumber('product')->name('api.product.delete'); //->missing(fn () => notFound('Product Not Found'));
});

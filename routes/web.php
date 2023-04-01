<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/menu');
Route::prefix('/menu')->group(function () {
    Route::get('/', fn () => view('menu/index'));
    Route::prefix('/categories')->group(function () {
        Route::get('/', [CategoryController::class, 'categoriesPage']);
        Route::get('/{categoryName}', [CategoryController::class, 'categoryPage']);
        Route::get('/{categoryName}/{productName}', [ProductController::class, 'productPage']);
    });
});

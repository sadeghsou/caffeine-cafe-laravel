<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::prefix('/admin')->middleware('auth')->group(function () {
    Route::get('/', fn () => view('admin/index'));
    Route::get('/products', [ProductController::class, 'productsAdminPage']);
    Route::get('/products/add', [ProductController::class, 'productAdminPage']);
    Route::get('/products/{product}', [ProductController::class, 'productAdminPage']);
    Route::get('/categories', [CategoryController::class, 'categoriesAdminPage']);
    Route::get('/categories/add', fn () => view('admin/categories/add'));
    Route::get('/categories/{category}', [CategoryController::class, 'categoryAdminPage']);
});

Route::get('/login', function () {
    if (Auth::check()) return redirect('admin');
    return view('auth/login');
})->name('login');

Route::post('/login', function (Request $request) {
    $username = $request->username;
    $password = $request->password;
    if (!($username && $password)) return redirect()->route('login', ['error' => 'null']);
    $user = User::where('name', $username)->orWhere('mobile', $username)->first();
    if (!$user) return redirect()->route('login', ['error' => 'username']);
    if ($user->password !== md5($password)) return redirect()->route('login', ['error' => 'password']);
    Auth::login($user);
    Session::put('user', $user);
    return redirect('admin');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('login');
});

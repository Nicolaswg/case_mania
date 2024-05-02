<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware'=>'auth'],function (){
    Route::get('/usuarios', [UserController::class, 'index'])
        ->name('users.index');
    Route::get('/usuarios/nuevo', [UserController::class, 'create'])->name('users.create');
    Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
    Route::get('/usuarios/{user}', [UserController::class, 'show'])
        ->where('user', '[0-9]+')
        ->name('users.show');
    Route::put('/usuarios/{user}', [UserController::class, 'update']);
    Route::post('/usuarios', [UserController::class, 'store']);
    Route::post('/user/delete', [UserController::class, 'destroy'])->name('users.destroy');
});
Route::group(['middleware'=>['auth','admin']],function (){});

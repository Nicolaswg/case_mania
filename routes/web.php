<?php

use App\Http\Controllers\CompraController;
use App\Http\Controllers\ProductoController;
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

    //PRODUCTOS
    Route::get('productos',[ProductoController::class,'index'])->name('productos.index');
    Route::get('/productos/nuevo', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store']);
    Route::get('/productos/{producto}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{producto}', [ProductoController::class, 'update']);

    //COMPRAS
    Route::get('compras',[CompraController::class,'index'])->name('compras.index');
    Route::get('/compras/nueva', [CompraController::class, 'create'])->name('compras.create');
    Route::post('/selecproducto', [CompraController::class, 'selecproducto']);
    Route::post('compras',[CompraController::class,'store'])->name('compras.store');
    Route::get('compras/{compra}/mostrar',[CompraController::class,'show'])->name('compras.show');
    Route::get('compras/{compra}/pdf',[CompraController::class,'showpdf'])->name('compras.showpdf');
    Route::get('compras/{compra}/editar',[CompraController::class,'edit'])->name('compras.edit');
    Route::post('cargarproducto',[CompraController::class,'selecdata']);
    Route::post('compra/update',[CompraController::class,'update']);
    Route::post('/compra/delete',[CompraController::class,'delete'])->middleware('password.confirm')->name('compras.delete');
});
Route::group(['middleware'=>['auth','admin']],function (){});

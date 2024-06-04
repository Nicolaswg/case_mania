<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
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
//RUTA PARA SELECIONAR PRODUCOTS TANTO EN VENTS COMO EN COMPRAS
    Route::post('/selecproducto', [ProductoController::class, 'selecproducto']);
    Route::post('/verificarmaxproducto', [ProductoController::class, 'selecmaxproducto']);
    //COMPRAS
    Route::get('compras',[CompraController::class,'index'])->name('compras.index');
    Route::get('/compras/nueva', [CompraController::class, 'create'])->name('compras.create');
    Route::post('compras',[CompraController::class,'store'])->name('compras.store');
    Route::get('compras/{compra}/mostrar',[CompraController::class,'show'])->name('compras.show');
    Route::get('compras/{compra}/pdf',[CompraController::class,'showpdf'])->name('compras.showpdf');
    Route::get('compras/{compra}/editar',[CompraController::class,'edit'])->name('compras.edit');
    Route::post('cargarproducto',[CompraController::class,'selecdata']);
    Route::post('compra/update',[CompraController::class,'update']);
    Route::post('/compra/delete',[CompraController::class,'delete'])->middleware('password.confirm')->name('compras.delete');

    //PROVEEDORES
    Route::get('/proveedores', [ProveedorController::class, 'index'])
        ->name('proveedores.index');
    Route::get('/proveedores/nuevo', [ProveedorController::class, 'create'])->name('proveedores.create');
    Route::get('/proveedores/{proveedor}/editar', [ProveedorController::class, 'edit'])->name('proveedores.edit');
    Route::get('/proveedores/{proveedor}', [ProveedorController::class, 'show'])
        ->where('proveedor', '[0-9]+')
        ->name('proveedores.show');
    Route::post('proveedores',[ProveedorController::class,'store'])->name('proveedores.store');
    Route::put('/proveedores/{proveedor}', [ProveedorController::class, 'update']);
    Route::post('/proveedor/delete',[ProveedorController::class,'delete'])->name('proveedor.delete');
    //VENTAS
    Route::get('ventas',[VentaController::class,'index'])->name('ventas.index');
    Route::get('/ventas/nueva', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('ventas',[VentaController::class,'store'])->name('ventas.store');
    Route::post('/venta/delete',[VentaController::class,'delete'])->name('ventas.delete');
    Route::get('ventas/{venta}/mostrar',[VentaController::class,'show'])->name('ventas.show');
    Route::get('ventas/{venta}/pdf',[VentaController::class,'showpdf'])->name('ventas.showpdf');
    Route::get('ventas/{venta}/editar',[VentaController::class,'edit'])->name('ventas.edit');
    Route::post('cargarventa',[VentaController::class,'selecdata']);
    Route::post('venta/update',[VentaController::class,'update']);
    //CLIENTES
    Route::get('/clientes', [ClienteController::class, 'index'])
        ->name('clientes.index');
    Route::get('/clientes/nuevo', [ClienteController::class, 'create'])->name('clientes.create');
    Route::get('/clientes/{cliente}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::post('clientes',[ClienteController::class,'store'])->name('clientes.store');
    Route::put('/clientes/{cliente}', [ClienteController::class, 'update']);
    Route::post('/cliente/delete',[ClienteController::class,'delete'])->name('cliente.delete');

    //CATEGORIA DE PRODUCTOS

    Route::get('/categorias', [CategoriaController::class, 'index'])
        ->name('categorias.index');
    Route::get('/categorias/nuevo', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::get('/categorias/{categoria}/editar', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::post('/categorias',[CategoriaController::class,'store'])->name('categorias.store');
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update']);
    Route::post('/categorias/delete',[CategoriaController::class,'delete'])->name('categorias.delete');


});
Route::group(['middleware'=>['auth','admin']],function (){});

<?php

use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ContactoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PortadaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ClienteController;

/* RUTA DE INICIO (PORTADA) */
Route::get('/', [PortadaController::class, 'index'])->name('portada.index');

/* RUTAS DE PRODUCTOS */
Route::resource('producto', ProductoController::class);


/* RUTAS DE CONTACTO */
Route::resource('contacto', ContactoController::class);

/* RUTAS DE CARRITO */
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/add', [CarritoController::class, 'add'])->name('carrito.add');
Route::post('/carrito/update-cantidad', [CarritoController::class, 'updateCantidad'])->name('carrito.updateCantidad');
Route::post('/carrito/remove-producto', [CarritoController::class, 'removeProducto'])->name('carrito.removeProducto');
Route::post('/carrito/anular', [CarritoController::class, 'anular'])->name('carrito.anular');
Route::get('/carrito/count', [CarritoController::class, 'count'])->name('carrito.count');




/* RUTAS DE LOGIN */
Route::resource('login', LoginController::class);





/*CREACION DE GRUPO DE RUTAS ADMINISTRATIVAS
    Se utiliza para la administración de las clases independientes
    y dependientes. Esta sección se la trabaja en IS.
*/

Route::prefix('admin') -> name('admin.')->group(function() {
    Route::get('/', fn() => view('admin.dashboard'))->name('dashboard');

    Route::resource('clientes',ClienteController::class);
    Route::resource('productos', ProductoController::class);
});


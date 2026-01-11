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

/* RUTAS DE CARRITO DE COMPRAS */
Route::resource('carrito', CarritoController::class);

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


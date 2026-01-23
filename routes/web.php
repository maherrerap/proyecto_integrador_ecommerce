<?php

use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ContactoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PortadaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistorialComprasController;

/* ============================================
   RUTAS PÚBLICAS
   ============================================ */

/* RUTA DE INICIO (PORTADA) */
Route::get('/', [PortadaController::class, 'index'])->name('portada.index');

/* RUTAS DE AUTENTICACIÓN */
Route::prefix('auth')->name('auth.')->group(function () {
    // Mostrar formulario de login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    // Procesar login
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // NUEVO: Mostrar formulario de verificación inicial (email y cédula)
    Route::get('/register/verify', [AuthController::class, 'showRegisterVerify'])->name('showRegisterVerify');

    // NUEVO: Procesar verificación de cliente
    Route::post('/register/verify', [AuthController::class, 'verifyClient'])->name('verifyClient');

    // NUEVO: Procesar registro de contraseña para cliente existente
    Route::post('/register/password', [AuthController::class, 'registerPassword'])->name('registerPassword');

    // Mostrar formulario de registro completo
    Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');

    // Procesar registro completo
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Validaciones AJAX (opcionales)
    Route::post('/check-email', [AuthController::class, 'checkEmail'])->name('checkEmail');
    Route::post('/check-ruc-cedula', [AuthController::class, 'checkRucCedula'])->name('checkRucCedula');
});

/* RUTAS DE PRODUCTOS - ÁREA PÚBLICA (nombres en singular) */
Route::resource('productos', ProductoController::class)->names([
    'index' => 'producto.index',
    'create' => 'producto.create',
    'store' => 'producto.store',
    'show' => 'producto.show',
    'edit' => 'producto.edit',
    'update' => 'producto.update',
    'destroy' => 'producto.destroy',
]);


/* RUTAS DE CONTACTO */
Route::resource('contacto', ContactoController::class);

/* ============================================
   RUTAS PROTEGIDAS (REQUIEREN AUTENTICACIÓN)
   ============================================ */

Route::middleware(['auth.check'])->group(function () {

    /* RUTAS DE CARRITO */
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/add', [CarritoController::class, 'add'])->name('carrito.add');
    Route::post('/carrito/update-cantidad', [CarritoController::class, 'updateCantidad'])->name('carrito.updateCantidad');
    Route::post('/carrito/remove-producto', [CarritoController::class, 'removeProducto'])->name('carrito.removeProducto');
    Route::post('/carrito/anular', [CarritoController::class, 'anular'])->name('carrito.anular');
    Route::get('/carrito/count', [CarritoController::class, 'count'])->name('carrito.count');
    Route::post('/carrito/aprobar', [CarritoController::class, 'aprobar'])->name('carrito.aprobar');
    Route::get('/carrito/resumen', [CarritoController::class, 'resumen'])->name('carrito.resumen');
    Route::get('/historial-compras', [HistorialComprasController::class, 'index'])->name('compras.historial');
    Route::get('/historial-compras/{idCarrito}/detalle', [HistorialComprasController::class, 'detalle'])->name('compras.detalle');
});

/* RUTAS DE LOGIN (LEGACY - Mantener por compatibilidad) */
Route::resource('login', LoginController::class);

/* ============================================
   GRUPO DE RUTAS ADMINISTRATIVAS
   Se utiliza para la administración de las clases independientes
   y dependientes. Esta sección se la trabaja en IS.
   ============================================ */

Route::prefix('admin')->name('admin.')->middleware(['auth.check'])->group(function () {
    Route::get('/', fn() => view('admin.dashboard'))->name('dashboard');

    Route::resource('clientes', ClienteController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('productos', ProductoController::class);
});
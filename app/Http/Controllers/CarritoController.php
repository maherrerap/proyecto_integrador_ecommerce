<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\ProxCar;

class CarritoController extends Controller
{
    /**
     * Muestra el carrito de compras
     */
    public function index(Request $request) {
        // Obtener cliente de la sesión
        $idCliente = session('idCliente', 'CLI0001');

        // Obtener criterio de búsqueda
        $criterio = trim((string) $request->get('criterio', ''));

        // Obtener o crear carrito
        $idCarrito = Carrito::obtenerOCrearCarrito($idCliente);

        // Obtener productos del carrito (con búsqueda si aplica)
        $items = ProxCar::obtenerProductosDelCarrito($idCarrito, $criterio);

        // Obtener totales del carrito
        $Carrito = Carrito::obtenerPorId($idCarrito);
        
        return view('carrito.index', compact('items', 'Carrito', 'idCarrito', 'criterio'));
    }

    /**
     * Agrega un producto al carrito
     */
    public function add(Request $request) {
        $request->validate([
            "id_producto" => "required",
            "cantidad" => "required|integer|min:1",
        ]);

        $idCliente = session('idCliente', 'CLI0001');

        // Obtener carrito del cliente
        $idCarrito = Carrito::obtenerOCrearCarrito($idCliente);

        // Agregar producto al carrito
        Carrito::agregarProducto($idCarrito, $request->id_producto, $request->cantidad);

        return response()->json([
            "ok" => true,
            "message" => "Producto añadido correctamente",
        ]);
    }

    /**
     * Actualiza la cantidad de un producto en el carrito
     */
    public function updateCantidad(Request $request) {
        $request->validate([
            "id_carrito" => "required",
            "id_producto" => "required",
            "cantidad" => "required|integer|min:1",
        ]);

        Carrito::actualizarCantidadProducto(
            $request->id_carrito, 
            $request->id_producto, 
            $request->cantidad
        );

        return response()->json(["ok" => true]);
    }

    /**
     * Elimina un producto del carrito
     */
    public function removeProducto(Request $request) {
        $request->validate([
            "id_carrito" => "required",
            "id_producto" => "required",
        ]);

        Carrito::eliminarProducto($request->id_carrito, $request->id_producto);

        return response()->json(["ok" => true]);
    }

    /**
     * Anula/vacía el carrito completo
     */
    public function anular(Request $request) {
        $request->validate([
            "id_carrito" => "required",
        ]);

        Carrito::anularCarrito($request->id_carrito);

        return response()->json([
            "ok" => true, 
            "message" => "Carrito anulado correctamente"
        ]);
    }

    /**
     * Retorna el contador de productos en el carrito (para navbar)
     */
    public function count() {
        $idCliente = session('idCliente', 'CLI0001');

        $total = Carrito::contarProductos($idCliente);

        return response()->json(['total' => $total]);
    }

    /**
     * Aprueba el carrito y genera la factura (realiza el pago)
     */
    public function aprobar(Request $request) {
        $request->validate([
            "id_carrito" => "required",
        ]);

        try {
            Carrito::aprobarYPagar($request->id_carrito);
            
            return response()->json([
                "ok" => true, 
                "message" => "Pago realizado correctamente"
            ]); 
        } catch (\Exception $e) {
            return response()->json([
                "ok" => false, 
                "message" => "Error al realizar el pago"
            ], 500); 
        }
    }

    /**
     * Retorna el resumen del carrito en HTML (para sidebar Ajax)
     */
    public function resumen() {
        $idCliente = session('idCliente', 'CLI0001');

        // Obtener resumen completo del carrito
        $resumen = Carrito::obtenerResumen($idCliente);

        // Renderizar vista parcial
        $html = view('carrito.resumen', [
            'items' => $resumen['items'],
            'Carrito' => $resumen['carrito'],
            'totalUnidades' => $resumen['totalUnidades']
        ])->render();

        return response()->json([
            'ok' => true,
            'html' => $html,
            'totalUnidades' => $resumen['totalUnidades'],
        ]);
    }
}
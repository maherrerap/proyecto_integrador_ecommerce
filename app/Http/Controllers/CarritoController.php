<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\ProxCar;
use App\Models\Producto;

class CarritoController extends Controller
{
    /**
     * Muestra el carrito de compras
     */
    public function index(Request $request)
    {
        // Obtener cliente de la sesión
        if (!session()->has('idCliente')) {
            return redirect()->route('auth.login')
                ->with('warning', 'Debes iniciar sesión para acceder a esta función');
        }

        $idCliente = session('idCliente');

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
    public function add(Request $request)
    {
        // Validar que el usuario esté autenticado
        if (!session()->has('idCliente')) {
            return response()->json([
                "ok" => false,
                "message" => "Debes iniciar sesión para agregar productos al carrito",
            ], 401);
        }

        $request->validate([
            "id_producto" => "required",
            "cantidad" => "required|integer|min:1",
        ]);

        $idCliente = session('idCliente');
        $idCarrito = Carrito::obtenerOCrearCarrito($idCliente);
        Carrito::agregarProducto($idCarrito, $request->id_producto, $request->cantidad);

        return response()->json([
            "ok" => true,
            "message" => "Producto añadido correctamente",
        ]);
    }

    /**
     * Actualiza la cantidad de un producto en el carrito
     */
    public function updateCantidad(Request $request)
    {
        $request->validate([
            "id_carrito" => "required",
            "id_producto" => "required",
            "cantidad" => "required|integer|min:1",
        ]);

        // Validar stock actual
        $stock = (int) Producto::where('id_producto', $request->id_producto)
            ->value('pro_saldo_final');

        if ($request->cantidad > $stock) {
            return response()->json([
                "ok" => false,
                "message" => "Stock insuficiente. Disponible: {$stock}.",
                "stock" => $stock
            ], 422);
        }

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
    public function removeProducto(Request $request)
    {
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
    public function anular(Request $request)
    {
        $request->validate([
            "id_carrito" => "required",
        ]);

        Carrito::anularCarrito($request->id_carrito);

        return response()->json([
            "ok" => true,
            "message" => "Carrito anulado correctamente"
        ]);
    }

    public function count()
    {
        if (!session()->has('idCliente')) {
            return response()->json(['total' => 0]);
        }

        $idCliente = session('idCliente');

        $total = Carrito::contarProductos($idCliente);

        return response()->json(['total' => $total]);
    }

    public function aprobar(Request $request)
    {
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
            
            \Log::error('Error al procesar pago', [
                'carrito_id' => $request->id_carrito,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                "ok" => false,
                "message" => "No pudimos procesar tu pago. Por favor 
                                verifica el stock de los productos. \nSi el problema 
                                persiste, contacta a soporte."
            ], 500);
        }
    }

    /**
     * Retorna el resumen del carrito en HTML (para sidebar Ajax)
     */
    public function resumen()
    {
        if (!session()->has('idCliente')) {
            return response()->json([
                'ok' => false,
                'message' => 'No autenticado'
            ], 401);
        }

        $idCliente = session('idCliente');

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
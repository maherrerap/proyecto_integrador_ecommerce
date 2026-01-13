<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Factura;
use App\Models\ProxFac;

class CarritoController extends Controller
{
    public function index() {

        // TODO: LOGIN CARRITO MATHEO (sesión temporal)
        $idCliente = session('idCliente', 'CLI0001');

        // 1. Obtener o crear carrito en estado ABI (con procedure)
        $idrow = DB::selectOne("SELECT fn_get_or_create_carrito(?) AS id_factura", [$idCliente]);
        $idFactura = $idrow?->id_factura;



        // 2. Obtener productos del carrito (Eloquent)
        $items = ProxFac::join('productos', 'productos.id_producto', '=', 'pro_x_fac.id_producto')
        ->where('pro_x_fac.id_factura', $idFactura)
        ->where('pro_x_fac.estado_pxf', 'ABI')
        ->select('productos.id_producto', 
            'productos.pro_descripcion', 
            'productos.pro_imagen',
            'pro_x_fac.pxf_cantidad', 
            'pro_x_fac.pxf_precio', 
            'pro_x_fac.pxf_subtotal')
        ->orderBy('productos.id_producto', 'asc')
        ->get();

        // 3. Totales del carrito
        $factura = Factura::where('id_factura', $idFactura) -> first();

        // E RETORNA VISTA
        return view('carrito.index', compact('items', 'factura', 'idFactura'));
    }

    // F7.1. REGISTRAR VENTA
    public function add(Request $request) {
        $request -> validate([
            "id_producto" => "required",
            "cantidad" => "required|integer|min:1",
        ]);

        $idCliente = session('idCliente', 'CLI0001');

        // Obtener Carrito
        $idFactura = DB::selectOne("SELECT fn_get_or_create_carrito(?) AS id_factura", [$idCliente]) -> id_factura;

        // Llama al sp_carrito_add_item()
        DB::selectOne("CALL sp_carrito_add_item(?, ?, ?)", [$idFactura, $request -> id_producto, $request -> cantidad]);

        return response()->json([
            "ok" => true,
            "message" => "Producto añadido correctamente",
        ]);
    }

    // F7.2. MODIFICACIÓN DE VENTA
    public function updateCantidad(Request $request) {
        $request -> validate([
            "id_factura" => "required",
            "id_producto" => "required",
            "cantidad" => "required|integer|min:1",
        ]);

        DB::statement("CALL sp_carrito_update_qty(?, ?, ?)",
        [$request -> id_factura, 
            $request -> id_producto, 
            $request -> cantidad
        ]
        );

        return response()->json(["ok" => true]);
    }

    // F7.2. MODIFICACIÓN DE VENTA (ELIMINAR PRODUCTO DEL CARRITO)
    public function removeProducto(Request $request) {
        DB::statement("CALL sp_carrito_remove_item(?, ?)", [$request -> id_factura, $request -> id_producto]);

        return response()->json(["ok" => true]);
    }

    // F7.3. INHABILITAR VENTA
    public function anular(Request $request) {
        DB::statement("CALL anular_factura(?)", 
        [$request -> id_factura]
        );

        return response()->json([
            "ok" => true, 
            "message" => "Carrito anulado correctamente"
        ]);
    }

    // CONTADOR DE PRODUCTOS EN NAVBAR
    public function count() {
        $idCliente = session('idCliente', 'CLI0001');

        $row = DB::selectOne(" 
            SELECT COUNT(*) AS total
            FROM pro_x_fac pxf
            JOIN facturas f ON f.id_factura = pxf.id_factura
            WHERE f.id_cliente = ?
              AND f.estado_fac = 'ABI'
              AND pxf.estado_pxf = 'ABI'
        ", [$idCliente]);

        return response()->json([
            'total' => $row->total ?? 0
        ]);
    }

    // APROBAR CARRITO DE COMPRAS (GENERA FACTURA EN APR Y ACTUALIZA EL STOCK)
    public function aprobar(Request $request) {
        $request -> validate([
            "id_factura" => "required",
        ]);

        try {
            DB::statement("CALL aprobar_factura(?)", [$request -> id_factura]);
            return response()->json(["ok" => true, "message" => "Pago realizado correctamente"]); 
        } catch (\Exception $e) {
            return response()->json(["ok" => false, "message" => "Error al realizar el pago"]); 
        }
    }

    // PARA MOSTRAR RESUMEN DEL CARRITO EN EL CATÁLOGO POR AJAX
    public function resumen() {
        $idCliente = session('idCliente', 'CLI0001');

        // Obtener o crear carrito en ABI
        $idrow = DB::selectOne("SELECT fn_get_or_create_carrito(?) AS id_factura", [$idCliente]);
        $idFactura = $idrow?->id_factura;

        // Obtener productos del carrito
        $items = ProxFac::join('productos', 'productos.id_producto', '=', 'pro_x_fac.id_producto')
        ->where('pro_x_fac.id_factura', $idFactura)
        ->where('pro_x_fac.estado_pxf', 'ABI')
        ->select('productos.id_producto', 
            'productos.pro_descripcion', 
            'productos.pro_imagen',
            'pro_x_fac.pxf_cantidad', 
            'pro_x_fac.pxf_precio', 
            'pro_x_fac.pxf_subtotal')
        ->orderBy('productos.id_producto', 'asc')
        ->get();

        $factura = Factura::where('id_factura', $idFactura) -> first();

        // Cantidad total de unidades (sumatoria de cantidades)
        $totalUnidades = $items -> sum('pxf_cantidad');

        // Renderizar un partial (HTML) para inyectarlo en el sidebar
        $html = view('carrito.resumen', compact('items', 'factura', 'totalUnidades'))->render();

        return response()->json([
            'ok' => true,
            'html' => $html,
            'totalUnidades' => $totalUnidades,
        ]);
    }
}



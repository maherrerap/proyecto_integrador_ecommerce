<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Carrito;
use App\Models\ProxCar;

class CarritoController extends Controller
{
    public function index(Request $request) {

        // TODO: LOGIN CARRITO MATHEO (sesión temporal)
        $idCliente = session('idCliente', 'CLI0001');

        // Obtener criterio de búsqueda
        $criterio = trim((string) $request->get('criterio', ''));

        // 1. Obtener o crear carrito en estado ABI (con procedure)
        $idrow = DB::selectOne("SELECT ecommerce.fn_get_or_create_carrito_ecom(?) AS id_carrito", [$idCliente]);
        $idCarrito = $idrow?->id_carrito;

        // 2. Obtener productos del carrito (Eloquent) con búsqueda
        $query = ProxCar::join('public.productos', 'public.productos.id_producto', '=', 'ecommerce.pro_x_car.id_producto')
            ->where('ecommerce.pro_x_car.id_carrito', $idCarrito)
            ->where('ecommerce.pro_x_car.estado_pxf', 'ABI')
            ->select('public.productos.id_producto', 
                'public.productos.pro_descripcion', 
                'public.productos.pro_imagen',
                'ecommerce.pro_x_car.pxf_cantidad', 
                'ecommerce.pro_x_car.pxf_precio', 
                'ecommerce.pro_x_car.pxf_subtotal');

        // Aplicar filtro de búsqueda si hay criterio
        if ($criterio !== '') {
            $like = '%' . $criterio . '%';
            
            $query->where(function ($q) use ($like) {
                $q->whereRaw("unaccent(public.productos.pro_descripcion) ILIKE unaccent(?)", [$like])
                ->orWhereRaw("unaccent(public.productos.id_producto) ILIKE unaccent(?)", [$like]);
            });
        }

        $items = $query->orderBy('public.productos.id_producto', 'asc')->get();

        // 3. Totales del carrito
        $Carrito = Carrito::where('id_carrito', $idCarrito)->first();
        
        return view('carrito.index', compact('items', 'Carrito', 'idCarrito', 'criterio'));
    }

    // F7.1. REGISTRAR VENTA
    public function add(Request $request) {
        $request -> validate([
            "id_producto" => "required",
            "cantidad" => "required|integer|min:1",
        ]);

        $idCliente = session('idCliente', 'CLI0001');

        // Obtener Carrito
        $idCarrito = DB::selectOne("SELECT ecommerce.fn_get_or_create_carrito_ecom(?) AS id_carrito", [$idCliente]) -> id_carrito;

        // Llama al sp_carrito_add_item()
        DB::selectOne("CALL ecommerce.sp_carrito_add_item_ecom(?, ?, ?)", [$idCarrito, $request -> id_producto, $request -> cantidad]);

        return response()->json([
            "ok" => true,
            "message" => "Producto añadido correctamente",
        ]);
    }

    // F7.2. MODIFICACIÓN DE VENTA
    public function updateCantidad(Request $request) {
        $request -> validate([
            "id_carrito" => "required",
            "id_producto" => "required",
            "cantidad" => "required|integer|min:1",
        ]);

        DB::statement("CALL ecommerce.sp_carrito_update_qty_ecom(?, ?, ?)",
        [$request -> id_carrito, 
            $request -> id_producto, 
            $request -> cantidad
        ]
        );

        return response()->json(["ok" => true]);
    }

    // F7.2. MODIFICACIÓN DE VENTA (ELIMINAR PRODUCTO DEL CARRITO)
    public function removeProducto(Request $request) {
        DB::statement("CALL ecommerce.sp_carrito_remove_item_ecom(?, ?)", [$request -> id_carrito, $request -> id_producto]);

        return response()->json(["ok" => true]);
    }

    // F7.3. INHABILITAR VENTA
    public function anular(Request $request) {
        DB::statement("CALL ecommerce.sp_anular_carrito_ecom(?)", 
        [$request -> id_carrito]
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
            FROM ecommerce.pro_x_car pxc
            JOIN ecommerce.carrito c ON c.id_carrito = pxc.id_carrito
            WHERE c.id_cliente = ?
              AND c.estado_fac = 'ABI'
              AND pxc.estado_pxf = 'ABI'
        ", [$idCliente]);

        return response()->json([
            'total' => $row->total ?? 0
        ]);
    }

    // APROBAR CARRITO DE COMPRAS (GENERA FACTURA EN PAG Y ACTUALIZA EL STOCK)
    public function aprobar(Request $request) {
        $request -> validate([
            "id_carrito" => "required",
        ]);

        try {
            DB::statement("CALL ecommerce.pagar_carrito_ecom(?)", [$request -> id_carrito]);
            return response()->json(["ok" => true, "message" => "Pago realizado correctamente"]); 
        } catch (\Exception $e) {
            return response()->json(["ok" => false, "message" => "Error al realizar el pago"]); 
        }
    }

    // PARA MOSTRAR RESUMEN DEL CARRITO EN EL CATÁLOGO POR AJAX
    public function resumen() {
        $idCliente = session('idCliente', 'CLI0001');

        // Obtener o crear carrito en ABI
        $idrow = DB::selectOne("SELECT ecommerce.fn_get_or_create_carrito_ecom(?) AS id_carrito", [$idCliente]);
        $idCarrito = $idrow?->id_carrito;

        // Obtener productos del carrito
        $items = ProxCar::join('public.productos', 'public.productos.id_producto', '=', 'ecommerce.pro_x_car.id_producto')
        ->where('ecommerce.pro_x_car.id_carrito', $idCarrito)
        ->where('ecommerce.pro_x_car.estado_pxf', 'ABI')
        ->select('public.productos.id_producto', 
            'public.productos.pro_descripcion', 
            'public.productos.pro_imagen',
            'ecommerce.pro_x_car.pxf_cantidad', 
            'ecommerce.pro_x_car.pxf_precio', 
            'ecommerce.pro_x_car.pxf_subtotal')
        ->orderBy('public.productos.id_producto', 'asc')
        ->get();

        $Carrito = Carrito::where('id_carrito', $idCarrito) -> first();

        // Cantidad total de unidades (sumatoria de cantidades)
        $totalUnidades = $items -> sum('pxf_cantidad');

        // Renderizar un partial (HTML) para inyectarlo en el sidebar
        $html = view('carrito.resumen', compact('items', 'Carrito', 'totalUnidades'))->render();

        return response()->json([
            'ok' => true,
            'html' => $html,
            'totalUnidades' => $totalUnidades,
        ]);
    }
}



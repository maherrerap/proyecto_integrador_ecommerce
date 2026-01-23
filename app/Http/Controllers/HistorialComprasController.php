<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\ProxCar;

class HistorialComprasController extends Controller
{
    public function index()
    {
        // Si no hay sesion abierta, manda al login
        if (!session()->has('idCliente')) {
            return redirect()->route('auth.login')
                ->with('warning', 'Debes iniciar sesión para acceder a esta función');
        }

        $idCliente = session('idCliente');

        $compras = Carrito::obtenerHistorialCompras($idCliente);

        // Tarjeta resumen para el total historico del cliente
        $totalCompras = Carrito::where('id_cliente', $idCliente)
            ->where('estado_fac', 'PAG')
            ->count();

        $totalGastado = (float) Carrito::where('id_cliente', $idCliente)
            ->where('estado_fac', 'PAG')
            ->sum('fac_total');

        return view('compras.historial', compact('compras', 'totalCompras', 'totalGastado'));
    }

    /**
     * Obtener el detalle de productos de un carrito específico
     */

    /**
     * Obtiene el detalle de productos de un carrito específico
     */
    public function detalle($idCarrito)
    {
        // Verificar autenticación
        if (!session()->has('idCliente')) {
            return response()->json([
                'ok' => false,
                'message' => 'No autenticado'
            ], 401);
        }

        $idCliente = session('idCliente');

        // Verificar que el carrito pertenezca al cliente y esté pagado
        $carrito = Carrito::where('id_carrito', $idCarrito)
            ->where('id_cliente', $idCliente)
            ->where('estado_fac', 'PAG')
            ->first();

        if (!$carrito) {
            return response()->json([
                'ok' => false,
                'message' => 'Carrito no encontrado'
            ], 404);
        }

        // Obtener los productos del carrito (sin importar el estado_pxf ya que está pagado)
        $productos = ProxCar::join('public.productos', 'public.productos.id_producto', '=', 'ecommerce.pro_x_car.id_producto')
            ->where('ecommerce.pro_x_car.id_carrito', $idCarrito)
            ->select(
                'public.productos.id_producto',
                'public.productos.pro_descripcion',
                'ecommerce.pro_x_car.pxf_cantidad',
                'ecommerce.pro_x_car.pxf_precio',
                'ecommerce.pro_x_car.pxf_subtotal'
            )
            ->orderBy('public.productos.pro_descripcion')
            ->get();

        return response()->json([
            'ok' => true,
            'carrito' => [
                'id' => $carrito->id_carrito,
                'fecha_pago' => $carrito->fac_fecha_pago,
                'subtotal' => $carrito->fac_subtotal,
                'iva' => $carrito->fac_iva,
                'total' => $carrito->fac_total
            ],
            'productos' => $productos
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;

class HistorialComprasController extends Controller
{
    public function index(Request $request)
    {
        // Si no hay sesion abierta, manda al login
        if (!session()->has('idCliente')) {
            return redirect()->route('auth.login')
                ->with('warning', 'Debes iniciar sesión para acceder a esta función');
        }

        $idCliente = session('idCliente');
        $criterio = trim((string) $request->get('criterio', ''));

        $compras = Carrito::obtenerHistorialCompras($idCliente, $criterio);

        // Tarjeta resumen para el total historico del cliente
        $totalCompras = Carrito::where('id_cliente', $idCliente)
            ->where('estado_fac', 'PAG')
            ->count();

        $totalGastado = (float) Carrito::where('id_cliente', $idCliente)
            ->where('estado_fac', 'PAG')
            ->sum('fac_total');

        return view('compras.historial', compact('compras', 'criterio', 'totalCompras', 'totalGastado'));
    }
}

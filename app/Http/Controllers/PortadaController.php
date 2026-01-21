<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class PortadaController extends Controller
{
    public function index()
    {
        // Obtener 4 productos aleatorios activos con su categoría
        $productosDestacados = Producto::where('estado_prod', 'ACT')
            ->with('categoria')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('portada.index', compact('productosDestacados'));
    }
}

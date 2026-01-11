<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index() {
        $productos = Producto::getProductos()->orderBy('id_producto')->paginate(20);
        return view('productos.index', compact('productos'));
    }

    public function create() {
        return view('productos.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'id_producto'       => 'required|string|max:7',
            'pro_descripcion'   => 'required|string|max:50',
            'pro_um_compra'     => 'required|string|max:3',
            'pro_um_venta'      => 'required|string|max:3',
            'pro_valor_compra'  => 'required|numeric|min:0',
            'pro_precio_venta'  => 'required|numeric|min:0',
            'pro_saldo_inicial' => 'required|integer|min:0',
            'id_categoria'      => 'required|string|max:7',
        ]);


        $data = [
            'id_producto'       => $validated['id_producto'],
            'pro_descripcion'   => $validated['pro_descripcion'],
            'pro_um_compra'     => $validated['pro_um_compra'],
            'pro_um_venta'      => $validated['pro_um_venta'],
            'pro_valor_compra'  => $validated['pro_valor_compra'],
            'pro_precio_venta'  => $validated['pro_precio_venta'],
            'pro_saldo_inicial' => $validated['pro_saldo_inicial'],
            'pro_qty_ingresos'  => 0,
            'pro_qty_egresos'   => 0,
            'pro_qty_ajustes'   => 0,
            'pro_saldo_final'   => $validated['pro_saldo_inicial'],
            'estado_prod'       => 'ACT',
            'id_categoria'      => $validated['id_categoria'],
        ];

        Producto::createProducto($data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto Registrado Exitosamente!');
    }

    public function update(Request $request, Producto $producto) {
        $validated = $request->validate([
            'pro_descripcion'   => 'required|string|max:50',
            'pro_um_compra'     => 'required|string|max:3',
            'pro_um_venta'      => 'required|string|max:3',
            'id_categoria'      => 'required|string|max:7',
        ]);

        $data = [
            'pro_descripcion'   => $validated['pro_descripcion'],
            'pro_um_compra'     => $validated['pro_um_compra'],
            'pro_um_venta'      => $validated['pro_um_venta'],
            'id_categoria'      => $validated['id_categoria'],
        ];

        Producto::updateProducto($producto, $data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado Exitosamente!');
    }

    public function destroy(Producto $producto) {
        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto Inhabilitado Exitosamente!');
    }


    public function show (Producto $producto) {

        // Para traer solo los productos activos
        if ($producto -> estado_prod !== 'ACT') {
            abort(404);
        }

        $stockActual = (int) $producto->pro_saldo_final;

        return view('productos.show', compact('producto', 'stockActual'));
    }

}

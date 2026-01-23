<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $criterio = trim((string) $request->get('criterio', ''));

        // Para el filtro de categorías seleccionadas
        $categoriasSeleccionadas = $request->input('categorias', []);
        if (!is_array($categoriasSeleccionadas)) {
            $categoriasSeleccionadas = [$categoriasSeleccionadas];
        }

        $categoriasSeleccionadas = array_values(array_filter(array_map('trim', $categoriasSeleccionadas)));

        $categoriasSeleccionadas = array_values(array_diff($categoriasSeleccionadas, ['ALL']));

        $query = Producto::getProductos()
            ->select('productos.*', 'c.cat_descripcion as cat_descripcion')
            ->leftJoin('categoria as c', 'productos.id_categoria', '=', 'c.id_categoria')
            ->orderBy('productos.id_producto');

        // Filtro por categoria (si se selecciona)
        if (!empty($categoriasSeleccionadas)) {
            $query->whereIn('productos.id_categoria', $categoriasSeleccionadas);
        }

        // Solo se filtra si hay texto
        if ($criterio !== '') {
            $like = '%' . $criterio . '%';

            $query->where(function ($q) use ($like) {
                $q->whereRaw("unaccent(productos.pro_descripcion) ILIKE unaccent(?)", [$like])
                    ->orWhereRaw("unaccent(productos.id_producto) ILIKE unaccent(?)", [$like])
                    ->orWhereRaw("unaccent(c.cat_descripcion) ILIKE unaccent(?)", [$like]);
            });
        }

        $productos = $query->paginate(20)->appends($request->query());

        // Categorias para la vista
        $categorias = Categoria::orderBy('cat_descripcion')
            ->get(['id_categoria', 'cat_descripcion']);


        return view('productos.index', compact('productos', 'categorias', 'categoriasSeleccionadas', 'criterio'));
    }


    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_producto' => 'required|string|max:7',
            'pro_descripcion' => 'required|string|max:50',
            'pro_um_compra' => 'required|string|max:3',
            'pro_um_venta' => 'required|string|max:3',
            'pro_valor_compra' => 'required|numeric|min:0',
            'pro_precio_venta' => 'required|numeric|min:0',
            'pro_saldo_inicial' => 'required|integer|min:0',
            'id_categoria' => 'required|string|max:7',
        ]);


        $data = [
            'id_producto' => $validated['id_producto'],
            'pro_descripcion' => $validated['pro_descripcion'],
            'pro_um_compra' => $validated['pro_um_compra'],
            'pro_um_venta' => $validated['pro_um_venta'],
            'pro_valor_compra' => $validated['pro_valor_compra'],
            'pro_precio_venta' => $validated['pro_precio_venta'],
            'pro_saldo_inicial' => $validated['pro_saldo_inicial'],
            'pro_qty_ingresos' => 0,
            'pro_qty_egresos' => 0,
            'pro_qty_ajustes' => 0,
            'pro_saldo_final' => $validated['pro_saldo_inicial'],
            'estado_prod' => 'ACT',
            'id_categoria' => $validated['id_categoria'],
        ];

        Producto::createProducto($data);

        // SECOND AUDIT FIX #8: Mejorar mensaje con acción sugerida
        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto registrado exitosamente. Ahora puedes verlo en el catálogo.');
    }

    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'pro_descripcion' => 'required|string|max:50',
            'pro_um_compra' => 'required|string|max:3',
            'pro_um_venta' => 'required|string|max:3',
            'id_categoria' => 'required|string|max:7',
        ]);

        $data = [
            'pro_descripcion' => $validated['pro_descripcion'],
            'pro_um_compra' => $validated['pro_um_compra'],
            'pro_um_venta' => $validated['pro_um_venta'],
            'id_categoria' => $validated['id_categoria'],
        ];

        Producto::updateProducto($producto, $data);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado Exitosamente!');
    }

    public function destroy(Producto $producto)
    {
        // FIFTH AUDIT FIX #2: Implementar lógica de inhabilitación
        $producto->update(['estado_prod' => 'INA']);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto inhabilitado exitosamente.');
    }


    public function show(Producto $producto)
    {

        // Para traer solo los productos activos
        if ($producto->estado_prod !== 'ACT') {
            abort(404);
        }

        $stockActual = (int) $producto->pro_saldo_final;

        $producto->load('unidadMedidaVenta');

        // Obtener productos relacionados de la misma categoría
        $productosRelacionados = Producto::where('estado_prod', 'ACT')
            ->where('id_categoria', $producto->id_categoria)
            ->where('id_producto', '!=', $producto->id_producto) // Excluir el producto actual
            ->with('categoria')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('productos.show', compact('producto', 'stockActual', 'productosRelacionados'));
    }

}

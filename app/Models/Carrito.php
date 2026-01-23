<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Carrito extends Model
{
    protected $table = 'ecommerce.carrito';
    protected $primaryKey = 'id_carrito';

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_carrito',
        'id_cliente',
        'fac_subtotal',
        'fac_iva',
        'estado_fac',
        'fac_descripcion',
        'fac_fecha_hora',
        'fac_fecha_pago',
        'fac_total',
        'id_factura_public'
    ];

    /**
     * Relación con los detalles del carito
     */

    public function detalles()
    {
        return $this->hasMany(ProxCar::class, 'id_carrito', 'id_carrito');
    }

    /**
     * Se obtiene o crea un carrito en estado ABI para un cliente
     */

    public static function obtenerOCrearCarrito($idCliente)
    {
        $resultado = DB::selectOne("SELECT ecommerce.fn_get_or_create_carrito_ecom(?) AS id_carrito", [$idCliente]);
        return $resultado->id_carrito;
    }

    /**
     * Obtiene el carrito activo de un cliente con sus totales
     */

    public static function obtenerPorId($idCarrito)
    {
        return self::where('id_carrito', $idCarrito)->first();
    }

    /**
     * Agrega un producto al carrito
     */

    public static function agregarProducto($idCarrito, $idProducto, $cantidad)
    {
        DB::selectOne("CALL ecommerce.sp_carrito_add_item_ecom(?, ?, ?)", [$idCarrito, $idProducto, $cantidad]);
    }

    /**
     * Actualiza la cantidad de un producto en el carrito
     */

    public static function actualizarCantidadProducto($idCarrito, $idProducto, $cantidad)
    {
        DB::statement("CALL ecommerce.sp_carrito_update_qty_ecom(?, ?, ?)", [$idCarrito, $idProducto, $cantidad]);
    }

    /**
     * Elimina un producto del carrito
     */

    public static function eliminarProducto($idCarrito, $idProducto)
    {
        DB::statement("CALL ecommerce.sp_carrito_remove_item_ecom(?, ?)", [$idCarrito, $idProducto]);
    }

    /**
     * Anula el carrito / Vaciar el Carrito
     */

    public static function anularCarrito($idCarrito)
    {
        DB::statement("CALL ecommerce.sp_anular_carrito_ecom(?)", [$idCarrito]);
    }

    /**
     * Cuenta el total de productos en el carrito activo de un cliente
     */
    public static function contarProductos($idCliente)
    {
        $resultado = DB::selectOne(" 
            SELECT COALESCE(SUM(pxc.pxf_cantidad), 0) AS total
            FROM ecommerce.pro_x_car pxc
            JOIN ecommerce.carrito c ON c.id_carrito = pxc.id_carrito
            WHERE c.id_cliente = ?
            AND c.estado_fac = 'ABI'
            AND pxc.estado_pxf = 'ABI'
        ", [$idCliente]);

        return (int) ($resultado->total ?? 0);
    }

    /**
     * Aprueba el carrito y genera la factura (realiza el pago)
     */
    public static function aprobarYPagar($idCarrito)
    {
        try {
            $result = DB::select(
                "SELECT ecommerce.pagar_carrito_ecom_fn(?) AS id_factura",
                [$idCarrito]
            );

            return $result[0]->id_factura;

        } catch (\Illuminate\Database\QueryException $e) {
            // Error controlado (stock insuficiente, carrito inválido, etc.)
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * Obtiene el resumen completo del carrito con productos y totales
     */
    public static function obtenerResumen($idCliente)
    {
        $idCarrito = self::obtenerOCrearCarrito($idCliente);

        $items = ProxCar::obtenerProductosDelCarrito($idCarrito);
        $carrito = self::obtenerPorId($idCarrito);
        $totalUnidades = $items->sum('pxf_cantidad');

        return [
            'items' => $items,
            'carrito' => $carrito,
            'totalUnidades' => $totalUnidades,
            'idCarrito' => $idCarrito
        ];
    }

    /**
     * Método para mostrar el historial de los carritos pagados del cliente
     */
    public static function obtenerHistorialCompras($idCliente) {
        return self::query()
            ->where('id_cliente', $idCliente)
            ->where('estado_fac', 'PAG')
            ->select('id_carrito', 'fac_subtotal', 'fac_iva', 'fac_fecha_pago', 'fac_total')
            ->orderByRaw('fac_fecha_pago DESC NULLS LAST')
            ->paginate(10);
    }
}

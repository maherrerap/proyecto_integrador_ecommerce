<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table='productos';
    protected $primaryKey='id_producto';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id_producto',
        'pro_descripcion',
        'pro_um_compra',
        'pro_um_venta',
        'pro_valor_compra',
        'pro_precio_venta',
        'pro_saldo_inicial',
        'pro_qty_ingreso',
        'pro_qty_egresos',
        'pro_qty_ajustes',
        'pro_saldo_final',
        'estado_prod',
        'id_categoria'

    ];

    public function getRouteKeyName() {
        return 'id_producto';
    }

    static public function getProductos() {
        return Producto::where('estado_prod','ACT');
    }
    static public function getProductoById(array $request) {
        return self::create($request);
    }
    static public function updateProducto(Producto $producto, array $data) {
        return $producto->update($data);
    }
}

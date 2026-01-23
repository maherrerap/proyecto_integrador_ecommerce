<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // MEDIUM FIX #16: Constantes de estado
    const STATUS_ACTIVE = 'ACT';
    const STATUS_INACTIVE = 'INA';

    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
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
        'pro_qty_ingresos',
        'pro_qty_egresos',
        'pro_qty_ajustes',
        'pro_saldo_final',
        'estado_prod',
        'id_categoria'

    ];

    public function getRouteKeyName()
    {
        return 'id_producto';
    }

    // CRITICAL FIX #8: Resolver TODO - método configurable para diferentes estados
    /**
     * Obtiene productos filtrados por estado(s)
     * 
     * @param array $estados Estados a filtrar (default: solo 'ACT')
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static public function getProductos(array $estados = ['ACT'])
    {
        return Producto::whereIn('estado_prod', $estados);
    }
    static public function getProductoById(array $request)
    {
        return self::create($request);
    }
    static public function updateProducto(Producto $producto, array $data)
    {
        return $producto->update($data);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function unidadMedidaVenta()
    {
        return $this->belongsTo(UnidadMedida::class, 'pro_um_venta', 'id_unidad_medida');
    }

    public function detallesCarrito()
    {
        return $this->hasMany(ProxCar::class, 'id_producto', 'id_producto');
    }
}

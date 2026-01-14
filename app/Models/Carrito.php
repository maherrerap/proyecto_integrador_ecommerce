<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function detalles() {
        return $this -> hasMany(ProxCar::class, 'id_carrito', 'id_carrito');
    }
}

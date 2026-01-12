<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'id_factura';
    
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_factura',
        'id_cliente',
        'fac_subtotal',
        'fac_iva',
        'estado_fac',
        'fac_descripcion',
        'fac_fecha_hora',
        'fac_fecha_pago',
        'fac_total'
    ];

    public function detalles() {
        return $this -> hasMany(ProxFac::class, 'id_factura', 'id_factura');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id_cliente',
        'cli_nombre',
        'cli_ruc_ced',
        'cli_telefono',
        'cli_mail',
        'cli_celular',
        'cli_direccion',
        'estado_cli',
        'id_ciudad'
    ];

    public function getRouteKeyName(){
        return 'id_cliente';
    }

    /* 1. CONSULTA GENERAL DE CLIENTES*/
    static public function getClientes(){
        return Cliente::where('estado_cli','ACT');
    }

    /*2. CONSULTA POR ID*/
    static public function getClienteByID($id) {
        return self::find($id);
    }

    /* 3. REGISTRAR CLIENTE */
    static public function createCliente(array $request) {
        return self::create($request);
    }

    /*4. ACTUALIZAR CLIENTE*/
    static public function updateCliente(Cliente $cliente, array $data) {
        return $cliente->update($data);
    }

}

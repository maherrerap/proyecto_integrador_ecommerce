<?php

namespace App\Http\Controllers;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /* 1. FUNCION PARA VER TODOS LOS CLIENTES*/
    public function index() {
        $clientes = Cliente::getClientes()->orderBy('id_cliente')->paginate(10);
        return view('admin.clientes.index', compact('clientes'));
    }

    /* 2. FUNCION PARA RETORNAR EL FORMUALRIO DE INGRESO DEL CLIENTE*/
    public function create() {
        return view('admin.clientes.create');
    }

    /* 3. FUNCION PARA CREAR EL CLIENTE LLAMANDO A LA FUNCION DEL MODELO*/
    public function store(Request $request) {
        // 3.1. Se validan los datos a ingresar
        $data = $request->validate([
            'id_cliente' => 'required|string|max:7',
            'cli_nombre' => 'required|string|max:40',
            'cli_ruc_ced' => 'required|string|max:13',
            'cli_telefono' => 'required|string|max:10',
            'cli_mail' => 'required|string|max:60',
            'cli_celular' => 'required|string|max:10',
            'cli_direccion' => 'required|string|max:60',
            'id_ciudad' => 'required|string|max:3',
        ]);

        $data['estado_cli'] = 'ACT';

        Cliente::createCliente($data);

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente Registrado Exitosamente!');
    }

    /* 4. FUNCION PARA MOSTRAR EL FORMULARIO DE EDICION*/

    public function edit(Cliente $cliente) {
        return view('admin.clientes.edit', compact('cliente'));
    }

    /* 5. FUNCION PARA EDITAR EL CLIENTE*/

    public function update(Request $request, Cliente $cliente) {
        $request->validate([
            'cli_nombre' => 'required|string|max:40',
            'cli_ruc_ced' => 'required|string|max:13',
            'cli_telefono' => 'required|string|max:10',
            'cli_mail' => 'required|string|max:60',
            'cli_celular' => 'required|string|max:10',
            'cli_direccion' => 'required|string|max:60',
        ]);

        Cliente::updateCliente($cliente, $request->all());

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente Actualizado Exitosamente!');
    }

    /*6. FUNCION PARA INHABILITAR AL CLIENTE*/
    public function destroy(Cliente $cliente) {
        $cliente -> update(['estado_cli'=>'INA']);

        return redirect() -> route('admin.clientes.index')->with('success', 'Cliente Inhabilitado Exitosamente!');
    }
}

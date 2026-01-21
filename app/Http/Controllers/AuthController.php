<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login
     */
    public function showLogin()
    {
        // Si ya está autenticado, redirigir al catálogo
        if (session()->has('idCliente')) {
            return redirect()->route('producto.index');
        }

        return view('auth.login');
    }

    /**
     * Procesa el inicio de sesión
     */
    public function login(Request $request)
    {
        // Validar datos de entrada
        $request->validate([
            'email' => 'required|email|max:120',
            'password' => 'required|string|min:10',
        ], [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Ingrese un correo electrónico válido',
            'email.max' => 'El correo electrónico no puede exceder 120 caracteres',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 10 caracteres',
        ]);

        // Validar credenciales
        $resultado = User::validarCredenciales(
            $request->email,
            $request->password
        );

        if (!$resultado['success']) {
            return back()->withErrors([
                'login_error' => $resultado['message']
            ])->withInput($request->only('email'));
        }

        // Guardar datos en sesión
        session([
            'idCliente' => $resultado['user']->id_cliente,
            'nombreCliente' => $resultado['user']->cli_nombre,
            'emailCliente' => $resultado['user']->email_login,
            'autenticado' => true
        ]);

        // Redirigir al catálogo de productos
        return redirect()->route('producto.index')->with('success', '¡Bienvenido ' . $resultado['user']->cli_nombre . '!');
    }

    /**
     * Muestra el formulario de registro
     */
    public function showRegister()
    {
        // Si ya está autenticado, redirigir al catálogo
        if (session()->has('idCliente')) {
            return redirect()->route('producto.index');
        }

        return view('auth.register');
    }

    /**
     * Procesa el registro de un nuevo usuario
     */
    public function register(Request $request)
    {
        // Validar datos de entrada
        $request->validate([
            'cli_nombre' => 'required|string|max:40',
            'cli_ruc_ced' => [
                'required',
                'string',
                'regex:/^[0-9]{10}$|^[0-9]{13}$/',
                function ($attribute, $value, $fail) {
                    if (User::rucCedulaExiste($value)) {
                        $fail('La cédula/RUC ya está registrada');
                    }
                },
            ],
            'cli_telefono' => [
                'nullable',
                'string',
                'regex:/^0[2-3][0-9]{7}$/',
            ],
            'cli_mail' => [
                'required',
                'email',
                'max:60',
                function ($attribute, $value, $fail) {
                    if (User::emailExiste($value)) {
                        $fail('El correo electrónico ya está registrado');
                    }
                },
            ],
            'cli_celular' => [
                'required',
                'string',
                'regex:/^09[0-9]{8}$/',
            ],
            'cli_direccion' => 'required|string|max:60',
            'id_ciudad' => 'nullable|string|max:3',
            'password' => [
                'required',
                'string',
                'min:10',
                'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                'confirmed',
            ],
        ], [
            // Mensajes personalizados
            'cli_nombre.required' => 'El nombre completo es obligatorio',
            'cli_nombre.max' => 'El nombre no puede exceder 40 caracteres',

            'cli_ruc_ced.required' => 'La cédula/RUC es obligatoria',
            'cli_ruc_ced.regex' => 'La cédula debe tener 10 dígitos o el RUC 13 dígitos',

            'cli_telefono.regex' => 'El teléfono debe iniciar con 02 o 03 y tener 9 dígitos en total',

            'cli_mail.required' => 'El correo electrónico es obligatorio',
            'cli_mail.email' => 'Ingrese un correo electrónico válido',
            'cli_mail.max' => 'El correo electrónico no puede exceder 60 caracteres',

            'cli_celular.required' => 'El celular es obligatorio',
            'cli_celular.regex' => 'El celular debe iniciar con 09 y tener 10 dígitos en total',

            'cli_direccion.required' => 'La dirección es obligatoria',
            'cli_direccion.max' => 'La dirección no puede exceder 60 caracteres',

            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 10 caracteres',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, un número y un carácter especial (@$!%*?&)',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        // Registrar usuario
        $resultado = User::registrarUsuario([
            'cli_nombre' => $request->cli_nombre,
            'cli_ruc_ced' => $request->cli_ruc_ced,
            'cli_telefono' => $request->cli_telefono,
            'cli_mail' => $request->cli_mail,
            'cli_celular' => $request->cli_celular,
            'cli_direccion' => $request->cli_direccion,
            'id_ciudad' => $request->id_ciudad ?? 'UIO',
            'password' => $request->password,
        ]);

        if (!$resultado['success']) {
            return back()->withErrors([
                'register_error' => $resultado['message']
            ])->withInput();
        }

        // Iniciar sesión automáticamente después del registro
        $usuarioRegistrado = User::obtenerPorIdCliente($resultado['id_cliente']);

        session([
            'idCliente' => $usuarioRegistrado->id_cliente,
            'nombreCliente' => $usuarioRegistrado->cli_nombre,
            'emailCliente' => $usuarioRegistrado->email_login,
            'autenticado' => true
        ]);

        // Redirigir al catálogo
        return redirect()->route('producto.index')->with('success', '¡Registro exitoso! Bienvenido ' . $usuarioRegistrado->cli_nombre);
    }

    /**
     * Cierra la sesión del usuario
     */
    public function logout()
    {
        // Limpiar sesión
        session()->flush();

        return redirect()->route('auth.login')->with('success', 'Sesión cerrada correctamente');
    }

    /**
     * Verifica si el email está disponible (para validación AJAX)
     */
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $existe = User::emailExiste($email);

        return response()->json([
            'disponible' => !$existe
        ]);
    }

    /**
     * Verifica si la cédula/RUC está disponible (para validación AJAX)
     */
    public function checkRucCedula(Request $request)
    {
        $rucCed = $request->input('ruc_cedula');
        $existe = User::rucCedulaExiste($rucCed);

        return response()->json([
            'disponible' => !$existe
        ]);
    }
}
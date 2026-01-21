<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    protected $table = 'ecommerce.web_clientes_auth';
    protected $primaryKey = 'id_auth';

    public $timestamps = false;

    protected $fillable = [
        'id_cliente',
        'email_login',
        'password_hash',
        'estado',
        'created_at',
        'last_login_at'
    ];

    protected $hidden = [
        'password_hash',
    ];

    /**
     * Obtiene el último número de cliente creado en el esquema public
     */
    public static function obtenerUltimoNumeroCliente()
    {
        $resultado = DB::selectOne("
            SELECT COALESCE(MAX(SUBSTRING(id_cliente FROM 4)::INTEGER), 0) + 1 AS siguiente
            FROM public.clientes
            WHERE id_cliente ~ '^CLI[0-9]{4}$'
        ");

        return $resultado->siguiente ?? 1;
    }

    public static function generarIdCliente()
    {
        $numero = self::obtenerUltimoNumeroCliente();
        return 'CLI' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Registra un nuevo usuario en el sistema
     * 
     * @param array $datos Datos del usuario
     * @return array ['success' => bool, 'message' => string, 'id_cliente' => string|null]
     */
    public static function registrarUsuario($datos)
    {
        try {
            DB::beginTransaction();

            // Generar ID de cliente
            $idCliente = self::generarIdCliente();

            // Insertar en la tabla clientes del esquema public PRIMERO
            DB::statement("
                INSERT INTO public.clientes (
                    id_cliente,
                    cli_nombre,
                    cli_ruc_ced,
                    cli_telefono,
                    cli_mail,
                    cli_celular,
                    cli_direccion,
                    estado_cli,
                    id_ciudad
                ) VALUES (?, ?, ?, ?, ?, ?, ?, 'ACT', ?)
            ", [
                $idCliente,
                $datos['cli_nombre'],
                $datos['cli_ruc_ced'],
                $datos['cli_telefono'] ?? null,
                $datos['cli_mail'],
                $datos['cli_celular'],
                $datos['cli_direccion'],
                $datos['id_ciudad'] ?? 'QUI'
            ]);

            // Insertar en web_clientes_auth DESPUÉS
            DB::statement("
                INSERT INTO ecommerce.web_clientes_auth (
                    id_cliente,
                    email_login,
                    password_hash,
                    estado,
                    created_at
                ) VALUES (?, ?, ?, 'ACT', NOW())
            ", [
                $idCliente,
                $datos['cli_mail'],
                Hash::make($datos['password'])
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Usuario registrado correctamente',
                'id_cliente' => $idCliente
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error al registrar usuario: ' . $e->getMessage(),
                'id_cliente' => null
            ];
        }
    }

    /**
     * Valida las credenciales del usuario (email y contraseña)
     * 
     * @param string $email
     * @param string $password
     * @return array ['success' => bool, 'message' => string, 'user' => object|null]
     */
    public static function validarCredenciales($email, $password)
    {
        try {
            // Buscar usuario por email
            $usuario = DB::selectOne("
                SELECT 
                    wa.id_auth,
                    wa.id_cliente,
                    wa.email_login,
                    wa.password_hash,
                    wa.estado,
                    c.cli_nombre
                FROM ecommerce.web_clientes_auth wa
                INNER JOIN public.clientes c ON c.id_cliente = wa.id_cliente
                WHERE wa.email_login = ?
                  AND wa.estado = 'ACT'
                LIMIT 1
            ", [$email]);

            // Validar si el usuario existe
            if (!$usuario) {
                return [
                    'success' => false,
                    'message' => 'Credenciales incorrectas',
                    'user' => null
                ];
            }

            // Validar contraseña
            if (!Hash::check($password, $usuario->password_hash)) {
                return [
                    'success' => false,
                    'message' => 'Credenciales incorrectas',
                    'user' => null
                ];
            }

            // Actualizar última fecha de login
            DB::statement("
                UPDATE ecommerce.web_clientes_auth
                SET last_login_at = NOW()
                WHERE id_auth = ?
            ", [$usuario->id_auth]);

            return [
                'success' => true,
                'message' => 'Inicio de sesión exitoso',
                'user' => $usuario
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al validar credenciales: ' . $e->getMessage(),
                'user' => null
            ];
        }
    }

    /**
     * Verifica si un email ya está registrado
     * 
     * @param string $email
     * @return bool
     */
    public static function emailExiste($email)
    {
        $resultado = DB::selectOne("
            SELECT COUNT(*) as total
            FROM ecommerce.web_clientes_auth
            WHERE email_login = ?
        ", [$email]);

        return $resultado->total > 0;
    }

    /**
     * Verifica si un RUC/Cédula ya está registrado
     * 
     * @param string $rucCed
     * @return bool
     */
    public static function rucCedulaExiste($rucCed)
    {
        $resultado = DB::selectOne("
            SELECT COUNT(*) as total
            FROM public.clientes
            WHERE cli_ruc_ced = ?
        ", [$rucCed]);

        return $resultado->total > 0;
    }

    /**
     * Obtiene un usuario por su ID de cliente
     * 
     * @param string $idCliente
     * @return object|null
     */
    public static function obtenerPorIdCliente($idCliente)
    {
        return DB::selectOne("
            SELECT 
                wa.id_auth,
                wa.id_cliente,
                wa.email_login,
                wa.estado,
                c.cli_nombre,
                c.cli_mail,
                c.cli_celular
            FROM ecommerce.web_clientes_auth wa
            INNER JOIN public.clientes c ON c.id_cliente = wa.id_cliente
            WHERE wa.id_cliente = ?
              AND wa.estado = 'ACT'
            LIMIT 1
        ", [$idCliente]);
    }
}
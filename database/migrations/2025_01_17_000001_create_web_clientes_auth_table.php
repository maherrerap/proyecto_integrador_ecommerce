<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Crear tabla web_clientes_auth en esquema ecommerce
        DB::statement("
            CREATE TABLE IF NOT EXISTS ecommerce.web_clientes_auth (
                id_auth BIGSERIAL PRIMARY KEY,
                id_cliente CHARACTER VARYING(20) NOT NULL UNIQUE,
                email_login CHARACTER VARYING(120) NOT NULL UNIQUE,
                password_hash TEXT NOT NULL,
                estado CHARACTER VARYING(3) DEFAULT 'ACT',
                created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
                last_login_at TIMESTAMP WITHOUT TIME ZONE
            )
        ");

        // Crear índices para mejorar el rendimiento
        DB::statement("CREATE INDEX idx_web_clientes_auth_email ON ecommerce.web_clientes_auth(email_login)");
        DB::statement("CREATE INDEX idx_web_clientes_auth_id_cliente ON ecommerce.web_clientes_auth(id_cliente)");
        DB::statement("CREATE INDEX idx_web_clientes_auth_estado ON ecommerce.web_clientes_auth(estado)");

        // Agregar comentarios a la tabla y columnas
        DB::statement("COMMENT ON TABLE ecommerce.web_clientes_auth IS 'Tabla de autenticación para clientes del e-commerce'");
        DB::statement("COMMENT ON COLUMN ecommerce.web_clientes_auth.id_auth IS 'ID autoincremental de autenticación'");
        DB::statement("COMMENT ON COLUMN ecommerce.web_clientes_auth.id_cliente IS 'ID del cliente relacionado'");
        DB::statement("COMMENT ON COLUMN ecommerce.web_clientes_auth.email_login IS 'Email para iniciar sesión'");
        DB::statement("COMMENT ON COLUMN ecommerce.web_clientes_auth.password_hash IS 'Contraseña hasheada con bcrypt'");
        DB::statement("COMMENT ON COLUMN ecommerce.web_clientes_auth.estado IS 'Estado: ACT=Activo, INA=Inactivo'");
        DB::statement("COMMENT ON COLUMN ecommerce.web_clientes_auth.created_at IS 'Fecha de creación del registro'");
        DB::statement("COMMENT ON COLUMN ecommerce.web_clientes_auth.last_login_at IS 'Última fecha de inicio de sesión'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar índices
        DB::statement("DROP INDEX IF EXISTS ecommerce.idx_web_clientes_auth_email");
        DB::statement("DROP INDEX IF EXISTS ecommerce.idx_web_clientes_auth_id_cliente");
        DB::statement("DROP INDEX IF EXISTS ecommerce.idx_web_clientes_auth_estado");
        
        // Eliminar tabla
        DB::statement("DROP TABLE IF EXISTS ecommerce.web_clientes_auth");
    }
};

# Cold Market - Tienda en Línea

Bienvenido a **Cold Market**, una plataforma de comercio electrónico moderna y fácil de usar para la venta de productos de ferretería y construcción.

---

## ¿Qué es Cold Market?

Cold Market es una tienda en línea donde los clientes pueden:
- Buscar y explorar productos por categorías
- Agregar productos al carrito de compras
- Realizar compras de forma segura
- Crear y gestionar su cuenta personal

---

## Características Principales

- **Diseño Moderno** - Interfaz atractiva y fácil de navegar
- **100% Seguro** - Protección de datos y transacciones seguras
- **Carrito Inteligente** - Gestiona tus compras antes de pagar
- **Búsqueda Rápida** - Encuentra lo que necesitas en segundos
- **Responsive** - Funciona en celular, tablet y computadora

---

## Requisitos Previos

Para usar este proyecto necesitas tener instalado:

- PHP 8.4 o superior
- PostgreSQL 14 o superior
- Composer (gestor de paquetes PHP)

---

## Instalación Rápida

### 1. Descarga el Proyecto
```bash
git clone [url-del-repositorio]
cd proyecto_integrador_ecommerce
```

### 2. Instala las Dependencias
```bash
composer install
```

### 3. Configura el Proyecto
```bash
# Copia el archivo de configuración
cp .env.example .env

# Genera la clave de seguridad
php artisan key:generate
```

### 4. Configura la Base de Datos
Abre el archivo `.env` y edita estas líneas con tus datos:
```
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 5. Inicia el Servidor
```bash
php artisan serve
```

Listo. Abre tu navegador en `http://localhost:8000`

---

## Usuarios de Prueba

Puedes registrarte como nuevo usuario o usar estos datos de prueba:

**Usuario de Ejemplo:**
- Email: crear nuevo usuario en el sistema
- Contraseña: mínimo 10 caracteres, incluye mayúscula, número y símbolo

---

## Cómo Usar la Plataforma

### Como Cliente:

1. **Registro/Login**
   - Crea tu cuenta con email y cédula
   - O inicia sesión si ya tienes cuenta

2. **Explorar Productos**
   - Usa el buscador o navega por categorías
   - Haz clic en cualquier producto para ver detalles

3. **Agregar al Carrito**
   - Pulsa "Ver Detalles" en el producto
   - Agrega los productos que necesites

4. **Realizar Compra**
   - Revisa tu carrito en el ícono del carrito
   - Confirma tu pedido y procede al pago

---

## Tecnologías Utilizadas

- **Laravel 12** - Framework PHP moderno
- **PostgreSQL** - Base de datos robusta
- **Bootstrap 5** - Diseño responsive
- **SweetAlert2** - Notificaciones elegantes

---

## Seguridad

Este proyecto incluye:
- Protección contra ataques de fuerza bruta
- Validación de todos los datos ingresados
- Encriptación de contraseñas
- Protección CSRF en formularios

---

## Características de UX

- Indicadores de carga en todas las acciones
- Mensajes claros de éxito o error
- Feedback visual inmediato
- Diseño adaptable a cualquier dispositivo

---

## Contacto y Soporte

Si tienes preguntas o encuentras algún problema:

- Email: [tu-email]
- Reportar problema: [link a issues]

---

## Licencia

Este proyecto es de uso académico. Desarrollado para el curso de Ingeniería de Software.

---

## Autores

- **Equipo Cold Market**
- Proyecto integrador - Ingeniería de Software
- [Año académico]

---

## Agradecimientos

Agradecemos a todos los que han contribuido al desarrollo y mejora de este proyecto.

---

**Versión:** 1.0.0  
**Última actualización:** Enero 2026

---

> **Tip**: Para obtener la mejor experiencia, usa navegadores modernos como Chrome, Firefox o Edge.

# Optimización de Imágenes - Guía de Uso

## 📦 Servicio de Optimización

Se ha creado `ImageOptimizerService` que optimiza automáticamente las imágenes.

### ✨ Características:
- ✅ Redimensiona imágenes grandes a 800px de ancho máximo
- ✅ Comprime con 85% de calidad (imperceptible al ojo humano)
- ✅ Soporta JPG, PNG y GIF
- ✅ Preserva transparencia en PNG
- ✅ Reduce peso de imágenes en 70-80% promedio

---

## 🔧 Uso del Servicio

### En Controladores (Para nuevas subidas):

```php
use App\Services\ImageOptimizerService;

class TuControlador extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            
            // Guardar imagen temporal
            $tempPath = $file->store('temp', 'public');
            $fullPath = storage_path('app/public/' . $tempPath);
            
            // Optimizar imagen
            $optimizer = new ImageOptimizerService();
            $optimizer->optimize($fullPath);
            
            // Mover a destino final
            $finalPath = public_path('images/productos/' . $nombreFinal);
            rename($fullPath, $finalPath);
        }
    }
}
```

---

## 🎯 Script de Optimización Manual (Opcional)

Para optimizar imágenes existentes, usa el script incluido:

### Paso 1: Abrir Tinker de Laravel
```bash
php artisan tinker
```

### Paso 2: Ejecutar el script
```php
include('scripts/optimize_product_images.php');
```

### Resultado esperado:
```
🚀 Iniciando optimización de 15 imagen(es)...
------------------------------------------------------------
📸 Procesando: PROD001.jpg
   Tamaño original: 650 KB
   ✅ Optimizada: 95 KB (Reducción: 85.38%)

📸 Procesando: PROD002.jpg
   Tamaño original: 480 KB
   ✅ Optimizada: 82 KB (Reducción: 82.92%)

...

============================================================
📊 RESUMEN:
   Total procesadas: 15
   Exitosas: 15
   Tamaño total original: 8.45 MB
   Tamaño total optimizado: 1.52 MB
   Reducción global: 82.01%
   Ahorro: 6.93 MB
============================================================
✅ Optimización completada!
```

---

## ⚠️ Importante

- El script optimiza **in-place** (sobreescribe las imágenes originales)
- Si quieres hacer backup primero, descomenta la línea en el script:
  ```php
  copy($imagePath, $imagePath . '.backup');
  ```
- La optimización es **irreversible** (a menos que tengas backup)
- Se recomienda probar primero con 1-2 imágenes

---

## 📊 Configuración

En `ImageOptimizerService.php`:
- `$maxWidth = 800` - Ancho máximo (cambia si necesitas imagen más grande)
- `$quality = 85` - Calidad de compresión (85 = óptimo, 100 = sin compresión)

---

## 🚀 Próximos Pasos

1. ✅ El servicio ya está listo para usar
2. ⚙️ Intégralo en tu sistema de subida de productos cuando lo implementes
3. 🎨 Opcionalmente ejecuta el script para optimizar imágenes existentes

---

## 💡 Ejemplo de Integración Futura

Cuando implementes upload de productos:

```php
// En tu formulario de admin
public function uploadProductImage(Request $request, $productId)
{
    $validator = $request->validate([
        'imagen' => 'required|image|max:10240' // Máx 10MB
    ]);

    if ($request->hasFile('imagen')) {
        $file = $request->file('imagen');
        $fileName = $productId . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('images/productos/' . $fileName);
        
        // Mover archivo
        $file->move(public_path('images/productos'), $fileName);
        
        // OPTIMIZAR
        $optimizer = new ImageOptimizerService();
        $optimizer->optimize($destinationPath);
        
        return redirect()->back()->with('success', 'Imagen optimizada y guardada');
    }
}
```

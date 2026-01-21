<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthentication
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado
        if (!session()->has('autenticado') || !session()->has('idCliente')) {

            // Si es una petición AJAX, responder con JSON
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.',
                    'redirect' => route('auth.login')
                ], 401);
            }

            // Si no es AJAX, guardar URL y redirigir
            session(['url.intended' => $request->url()]);

            return redirect()->route('auth.login')
                ->with('warning', 'Debes iniciar sesión para acceder al carrito');
        }

        return $next($request);
    }
}
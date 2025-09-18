<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetActiveCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Si no tiene empresa activa, establecer la primera disponible
            if (!$user->active_company_id) {
                $activeCompany = $user->getActiveCompany();
                if ($activeCompany) {
                    $user->update(['active_company_id' => $activeCompany->id]);
                }
            }
            
            // Compartir la empresa activa con todas las vistas
            $activeCompany = $user->getActiveCompany();
            if ($activeCompany) {
                view()->share('currentCompany', $activeCompany);
                
                // Establecer en sesión para uso en JavaScript
                session(['active_company_id' => $activeCompany->id]);
            }
        }

        return $next($request);
    }
}

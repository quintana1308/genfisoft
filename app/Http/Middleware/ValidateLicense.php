<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ValidateLicense
{
    /**
     * Rutas excluidas de la validación de licencia
     */
    protected $excludedRoutes = [
        'admin.*',
        'license.*',
        'logout',
        'profile.*',
        'switch.company',
        'accessible.companies'
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si la ruta actual está excluida
        foreach ($this->excludedRoutes as $pattern) {
            if ($request->routeIs($pattern)) {
                return $next($request);
            }
        }

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Los administradores globales (role = Administrador) no necesitan validación de licencia
        if ($user->role === 'Administrador') {
            return $next($request);
        }

        $company = $user->company;

        if (!$company) {
            return redirect()->route('setup.company')
                           ->with('error', 'Debe configurar una empresa primero.');
        }

        $license = $company->license;

        if (!$license) {
            return redirect()->route('license.required')
                           ->with('error', 'Su empresa no tiene una licencia válida.');
        }

        // Verificar si la licencia está activa
        if ($license->status !== 'active') {
            return redirect()->route('license.inactive')
                           ->with('error', 'Su licencia está inactiva. Contacte al administrador.');
        }

        // Verificar si la licencia ha expirado
        if ($license->isExpired()) {
            // Actualizar estado a expirado
            $license->update(['status' => 'expired']);
            
            return redirect()->route('license.expired')
                           ->with('error', 'Su licencia ha expirado. Renueve para continuar.');
        }

        // Verificar si está próxima a expirar (últimos 7 días)
        if ($license->isExpiringSoon(7)) {
            $daysRemaining = $license->getDaysRemaining();
            session()->flash('warning', "Su licencia expira en {$daysRemaining} días. Renueve pronto.");
        }

        // Actualizar última validación
        $license->updateLastValidation();

        // Compartir información de la empresa y licencia con todas las vistas
        view()->share('currentCompany', $company);
        view()->share('currentLicense', $license);

        return $next($request);
    }
}

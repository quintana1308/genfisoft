<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CompanySwitchController extends Controller
{
    /**
     * Cambiar la empresa activa del usuario
     */
    public function switchCompany(Request $request): JsonResponse
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id'
        ]);

        $user = Auth::user();
        $companyId = $request->company_id;

        // Verificar que el usuario tiene acceso a esta empresa
        if (!$user->hasAccessToCompany($companyId)) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes acceso a esta empresa'
            ], 403);
        }

        // Cambiar empresa activa
        if ($user->switchToCompany($companyId)) {
            return response()->json([
                'success' => true,
                'message' => 'Empresa cambiada exitosamente',
                'company' => $user->fresh()->getActiveCompany()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Error al cambiar de empresa'
        ], 500);
    }

    /**
     * Obtener empresas accesibles para el usuario
     */
    public function getAccessibleCompanies(): JsonResponse
    {
        $user = Auth::user();
        $companies = $user->getAccessibleCompanies();
        $activeCompany = $user->getActiveCompany();

        return response()->json([
            'companies' => $companies,
            'active_company' => $activeCompany
        ]);
    }
}

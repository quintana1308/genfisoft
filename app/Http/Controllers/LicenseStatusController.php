<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LicenseStatusController extends Controller
{
    /**
     * Mostrar página cuando no hay licencia
     */
    public function required()
    {
        return view('license.required');
    }

    /**
     * Mostrar página cuando la licencia está expirada
     */
    public function expired()
    {
        $user = Auth::user();
        $company = $user->company;
        $license = $company?->license;

        return view('license.expired', compact('company', 'license'));
    }

    /**
     * Mostrar página cuando la licencia está inactiva
     */
    public function inactive()
    {
        $user = Auth::user();
        $company = $user->company;
        $license = $company?->license;

        return view('license.inactive', compact('company', 'license'));
    }
}

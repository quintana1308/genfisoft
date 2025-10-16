<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\License;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    // ========== GESTIÓN DE EMPRESAS ==========

    /**
     * Mostrar lista de empresas
     */
    public function companies(): View
    {
        return view('admin.companies.index');
    }

    /**
     * Obtener datos de empresas para DataTable
     */
    public function getCompaniesData(): JsonResponse
    {
        $companies = Company::with(['license', 'users'])
            ->select(['id', 'name', 'business_name', 'tax_id', 'email', 'phone', 'status_id', 'created_at'])
            ->get()
            ->map(function ($company) {
                $license = $company->license;
                $usersCount = $company->users()->count();
                
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'business_name' => $company->business_name,
                    'tax_id' => $company->tax_id,
                    'email' => $company->email,
                    'phone' => $company->phone,
                    'users_count' => $usersCount,
                    'license_status' => $license ? $company->getLicenseStatus() : 'no_license',
                    'license_expires' => $license ? $license->end_date->format('d/m/Y') : 'N/A',
                    'status' => $company->isActive() ? 'Activa' : 'Inactiva',
                    'created_at' => $company->created_at->format('d/m/Y'),
                    'actions' => $company->id
                ];
            });

        return response()->json(['data' => $companies]);
    }

    /**
     * Mostrar formulario para crear empresa
     */
    public function createCompany(): View
    {
        return view('admin.companies.create');
    }

    /**
     * Guardar nueva empresa
     */
    public function storeCompany(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'tax_id' => 'required|string|max:50|unique:companies,tax_id',
            'email' => 'required|email|max:255|unique:companies,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $company = Company::create([
                'name' => $request->name,
                'business_name' => $request->business_name,
                'tax_id' => $request->tax_id,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country ?? 'Venezuela',
                'status_id' => 1
            ]);

            DB::commit();

            return redirect()->route('admin.companies')
                ->with('success', 'Empresa creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear la empresa: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Mostrar formulario para editar empresa
     */
    public function editCompany($id): View
    {
        $company = Company::with(['license', 'users'])->findOrFail($id);
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Actualizar empresa
     */
    public function updateCompany(Request $request, $id): RedirectResponse
    {
        $company = Company::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'tax_id' => 'required|string|max:50|unique:companies,tax_id,' . $id,
            'email' => 'required|email|max:255|unique:companies,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'status_id' => 'required|in:1,2'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $company->update($request->all());

            return redirect()->route('admin.companies')
                ->with('success', 'Empresa actualizada exitosamente.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar la empresa: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Obtener datos de una empresa específica
     */
    public function getCompany($id): JsonResponse
    {
        $company = Company::with(['license', 'users'])->findOrFail($id);
        
        return response()->json([
            'company' => $company,
            'users_count' => $company->users()->count(),
            'cattle_count' => $company->cattles()->count(),
            'license_status' => $company->getLicenseStatus(),
            'days_until_expiration' => $company->license ? $company->getDaysUntilExpiration() : null
        ]);
    }

    // ========== GESTIÓN DE LICENCIAS ==========

    /**
     * Mostrar gestión de licencias para una empresa
     */
    public function companyLicenses($companyId): View
    {
        $company = Company::with(['licenses' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($companyId);

        return view('admin.licenses.index', compact('company'));
    }

    /**
     * Crear nueva licencia para empresa
     */
    public function createLicense($companyId): View
    {
        $company = Company::findOrFail($companyId);
        $planTypes = ['basic', 'premium', 'enterprise'];
        
        return view('admin.licenses.create', compact('company', 'planTypes'));
    }

    /**
     * Guardar nueva licencia
     */
    public function storeLicense(Request $request, $companyId): RedirectResponse
    {
        $company = Company::findOrFail($companyId);

        $validator = Validator::make($request->all(), [
            'plan_type' => 'required|in:basic,premium,enterprise',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'price' => 'required|numeric|min:0',
            'payment_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Desactivar licencias anteriores
            License::where('company_id', $companyId)
                ->where('status', 'active')
                ->update(['status' => 'inactive']);

            // Obtener límites del plan
            $planLimits = License::getPlanLimits($request->plan_type);

            // Crear nueva licencia
            $license = License::create([
                'company_id' => $companyId,
                'license_key' => License::generateLicenseKey(),
                'plan_type' => $request->plan_type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'max_users' => $planLimits['max_users'],
                'max_cattle' => $planLimits['max_cattle'],
                'features' => $planLimits['features'],
                'status' => 'active',
                'price' => $request->price,
                'payment_reference' => $request->payment_reference,
                'notes' => $request->notes
            ]);

            DB::commit();

            return redirect()->route('admin.companies.licenses', $companyId)
                ->with('success', 'Licencia creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear la licencia: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Renovar licencia existente
     */
    public function renewLicense(Request $request, $licenseId): RedirectResponse
    {
        $license = License::findOrFail($licenseId);

        $validator = Validator::make($request->all(), [
            'months' => 'required|integer|min:1|max:36',
            'price' => 'required|numeric|min:0',
            'payment_reference' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $newEndDate = Carbon::parse($license->end_date)->addMonths($request->months);

            $license->update([
                'end_date' => $newEndDate,
                'status' => 'active',
                'price' => $license->price + $request->price,
                'payment_reference' => $request->payment_reference,
                'last_validated_at' => now()
            ]);

            return redirect()->route('admin.companies.licenses', $license->company_id)
                ->with('success', 'Licencia renovada exitosamente hasta ' . $newEndDate->format('d/m/Y'));

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al renovar la licencia: ' . $e->getMessage()]);
        }
    }

    /**
     * Cambiar estado de licencia
     */
    public function toggleLicenseStatus($licenseId): RedirectResponse
    {
        $license = License::findOrFail($licenseId);
        
        $newStatus = $license->status === 'active' ? 'suspended' : 'active';
        $license->update(['status' => $newStatus]);

        $message = $newStatus === 'active' ? 'Licencia activada' : 'Licencia suspendida';
        
        return back()->with('success', 'Estado de licencia actualizado');
    }

    // ========== GESTIÓN DE USUARIOS ==========

    /**
     * Mostrar lista de usuarios
     */
    public function users(): View
    {
        return view('admin.users.index');
    }

    /**
     * Obtener datos de usuarios para DataTable
     */
    public function getUsersData(): JsonResponse
    {
        $users = User::with('company')
            ->select(['id', 'name', 'email', 'role', 'is_active', 'company_id', 'last_login_at', 'created_at'])
            ->get();

        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'company' => $user->company ? $user->company->name : 'Sin empresa',
                'role' => $user->role,
                'is_active' => $user->is_active,
                'last_login' => $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca',
                'created_at' => $user->created_at->format('d/m/Y'),
                'actions' => $user->id
            ];
        });

        return response()->json(['data' => $data]);
    }

    /**
     * Mostrar formulario para crear usuario
     */
    public function createUser(): View
    {
        $companies = Company::orderBy('name')->get();
        return view('admin.users.create', compact('companies'));
    }

    /**
     * Almacenar nuevo usuario
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'company_id' => 'required|exists:companies,id',
            'additional_companies' => 'nullable|array',
            'additional_companies.*' => 'exists:companies,id',
            'role' => 'required|in:Administrador,Gerente,Operador',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'company_id' => $request->company_id,
            'active_company_id' => $request->company_id,
            'role' => $request->role,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Asignar empresa principal
        $user->companies()->attach($request->company_id, ['is_primary' => true]);

        // Asignar empresas adicionales si existen
        if ($request->additional_companies) {
            foreach ($request->additional_companies as $companyId) {
                if ($companyId != $request->company_id) {
                    $user->companies()->attach($companyId, ['is_primary' => false]);
                }
            }
        }

        return redirect()->route('admin.users')->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Mostrar formulario para editar usuario
     */
    public function editUser($id): View
    {
        $user = User::with(['company', 'companies'])->findOrFail($id);
        $companies = Company::orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'companies'));
    }

    /**
     * Actualizar usuario
     */
    public function updateUser(Request $request, $id): RedirectResponse
    {
        $user = User::with('companies')->findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'company_id' => 'required|exists:companies,id',
            'additional_companies' => 'nullable|array',
            'additional_companies.*' => 'exists:companies,id',
            'role' => 'required|in:Administrador,Gerente,Operador',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'company_id' => $request->company_id,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ];

        // Si cambió la empresa principal, actualizar empresa activa
        if ($user->company_id != $request->company_id) {
            $updateData['active_company_id'] = $request->company_id;
        }

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $user->update($updateData);

        // Actualizar relaciones de empresas
        $user->companies()->detach();
        
        // Asignar empresa principal
        $user->companies()->attach($request->company_id, ['is_primary' => true]);

        // Asignar empresas adicionales
        if ($request->additional_companies) {
            foreach ($request->additional_companies as $companyId) {
                if ($companyId != $request->company_id) {
                    $user->companies()->attach($companyId, ['is_primary' => false]);
                }
            }
        }

        return redirect()->route('admin.users')->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Obtener información de un usuario
     */
    public function getUser($id): JsonResponse
    {
        $user = User::with('company')->findOrFail($id);
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'company' => $user->company ? $user->company->name : 'Sin empresa',
            'is_active' => $user->is_active,
            'last_login' => $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca',
            'created_at' => $user->created_at->format('d/m/Y H:i'),
        ]);
    }

    /**
     * Alternar estado activo/inactivo del usuario
     */
    public function toggleUserStatus($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'activado' : 'desactivado';
        return response()->json(['success' => true, 'message' => "Usuario {$status} exitosamente"]);
    }

    /**
     * Eliminar usuario
     */
    public function deleteUser($id): JsonResponse
    {
        $user = User::findOrFail($id);
        
        // No permitir eliminar el usuario actual
        if ($user->id === Auth::id()) {
            return response()->json(['success' => false, 'message' => 'No puedes eliminar tu propio usuario']);
        }

        $user->delete();
        return response()->json(['success' => true, 'message' => 'Usuario eliminado exitosamente']);
    }

    // ========== DASHBOARD ADMIN ==========

    /**
     * Dashboard principal de administración
     */
    public function dashboard(): View
    {
        $stats = [
            'total_companies' => Company::count(),
            'active_companies' => Company::active()->count(),
            'total_licenses' => License::count(),
            'active_licenses' => License::active()->count(),
            'expiring_licenses' => License::expiringSoon(30)->count(),
            'total_users' => User::count(),
            'total_revenue' => License::sum('price')
        ];

        $recentCompanies = Company::with('license')
            ->latest()
            ->take(5)
            ->get();

        $expiringLicenses = License::with('company')
            ->expiringSoon(30)
            ->orderBy('end_date')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentCompanies', 'expiringLicenses'));
    }
}

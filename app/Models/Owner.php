<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;

class Owner extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'owners';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'company_id',
        'name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    //CONSULTAS
    public function getOwners($request)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $owners = Owner::with('status')->where('company_id', $activeCompanyId)->get();

        if ($owners->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($owners)
            ->addIndexColumn() // para el índice
            ->addColumn('name', function ($owner) {
                return $owner->name;
            })
            ->addColumn('status', function ($owner) {
                $statusName = $owner->status ? $owner->status->name : 'Sin estado';

                // Personalizar owneres
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-owner:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($owner) {
                $id = $owner->id;
                
                $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editOwner(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                return '<div class="text-center">' . $btnEdit . '</div>';
            })
            ->rawColumns(['name', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function createOwner($request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $activeCompanyId = $user->active_company_id;

        // Evitar duplicados
        if (Owner::where('company_id', $activeCompanyId)->where('name', $request->name)->exists()) {
            return response()->json(['status' => false, 'msg' => 'El propietario ya existe.']);
        }

        Owner::create([
            'name' => $request->name,
            'user_id' => $userId,
            'company_id' => $activeCompanyId,
        ]);

        return response()->json(['status' => true, 'msg' => 'Propietario creado correctamente.']);
    }

    public function getOwner($id)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $owner = Owner::with('status') // Cargar la relación
                ->where('id', $id)
                ->where('company_id', $activeCompanyId)
                ->first();

        if (!$owner) {
            return response()->json([
                'status' => false,
                'msg' => 'Datos no encontrados.'
            ]);
        }

        // Obtener todos los status
        $statuses = Status::orderBy('name')->get(['id', 'name']);

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $owner->id,
                'name' => $owner->name,
                'status_id' => $owner->status_id,
            ],
            'statuses' => $statuses
        ]);
    }

    public function updateOwner($request)
    {
        $owner = $this->find($request->id);
        if (!$owner) {
            return response()->json(['status' => false, 'msg' => 'Propietario no encontrado.']);
        }
        
        $owner->name = $request->name;

        if (isset($request->status) && $owner->status_id != $request->status) {
            $owner->status_id = $request->status;
        }

        if ($owner->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos guardados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron guardar los datos.']);
    }

}

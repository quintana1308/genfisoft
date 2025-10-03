<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;

class StatusProductive extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'status_productives';

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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /*public function tags()
    {
        return $this->belongsToMany(Tag::class, 'contact_tag', 'CONTACT_ID', 'TAG_ID');
    }*/

    //CONSULTAS
    public function getStatusProductives($request)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $statusProductives = StatusProductive::with('status')->where('company_id', $activeCompanyId)->get();

        if ($statusProductives->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($statusProductives)
            ->addIndexColumn() // para el índice
            ->addColumn('name', function ($statusProductive) {
                return $statusProductive->name;
            })
            ->addColumn('status', function ($statusProductive) {
                $statusName = $statusProductive->status ? $statusProductive->status->name : 'Sin estado';

                // Personalizar colores
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-color:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($statusProductive) {
                $id = $statusProductive->id;
                
                $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editStatusProductive(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                return '<div class="text-center">' . $btnEdit . '</div>';
            })
            ->rawColumns(['name', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function createStatusProductive($request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $activeCompanyId = $user->active_company_id;

        // Evitar duplicados
        if (StatusProductive::where('company_id', $activeCompanyId)->where('name', $request->name)->exists()) {
            return response()->json(['status' => false, 'msg' => 'El estado productivo ya existe.']);
        }

        StatusProductive::create([
            'name' => $request->name,
            'user_id' => $userId,
            'company_id' => $activeCompanyId,
        ]);

        return response()->json(['status' => true, 'msg' => 'Estado productivo creado correctamente.']);
    }

    public function getStatusProductive($id)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $statusProductive = StatusProductive::with('status') // Cargar la relación
                ->where('id', $id)
                ->where('company_id', $activeCompanyId)
                ->first();

        if (!$statusProductive) {
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
                'id' => $statusProductive->id,
                'name' => $statusProductive->name,
                'status_id' => $statusProductive->status_id,
            ],
            'statuses' => $statuses
        ]);
    }

    public function updateStatusProductive($request)
    {
        $statusProductive = $this->find($request->id);
        if (!$statusProductive) {
            return response()->json(['status' => false, 'msg' => 'Estado productivo no encontrado.']);
        }
        
        $statusProductive->name = $request->name;

        if (isset($request->status) && $statusProductive->status_id != $request->status) {
            $statusProductive->status_id = $request->status;
        }

        if ($statusProductive->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos guardados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron guardar los datos.']);
    }

}

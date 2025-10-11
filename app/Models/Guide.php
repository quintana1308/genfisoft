<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;

class Guide extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'guides';

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

    //CONSULTAS
    public function getGuides($request)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $guides = Guide::with('status')->where('company_id', $activeCompanyId)->get();

        if ($guides->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($guides)
            ->addIndexColumn() // para el índice
            ->addColumn('name', function ($guide) {
                return $guide->name;
            })
            ->addColumn('status', function ($guide) {
                $statusName = $guide->status ? $guide->status->name : 'Sin estado';

                // Personalizar colores
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-color:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($guide) {
                $id = $guide->id;
                
                $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editGuide(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                return '<div class="text-center">' . $btnEdit . '</div>';
            })
            ->rawColumns(['name', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function createGuide($request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $activeCompanyId = $user->active_company_id;

        // Evitar duplicados
        if (Guide::where('company_id', $activeCompanyId)->where('name', $request->name)->exists()) {
            return response()->json(['status' => false, 'msg' => 'La guía ya existe.']);
        }

        Guide::create([
            'name' => $request->name,
            'user_id' => $userId,
            'company_id' => $activeCompanyId,
        ]);

        return response()->json(['status' => true, 'msg' => 'Guía creada correctamente.']);
    }

    public function getGuide($id)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $guide = Guide::with('status') // Cargar la relación
                ->where('id', $id)
                ->where('company_id', $activeCompanyId)
                ->first();

        if (!$guide) {
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
                'id' => $guide->id,
                'name' => $guide->name,
                'status_id' => $guide->status_id,
            ],
            'statuses' => $statuses
        ]);
    }

    public function updateGuide($request)
    {
        $guide = $this->find($request->id);
        if (!$guide) {
            return response()->json(['status' => false, 'msg' => 'Guía no encontrada.']);
        }
        
        $guide->name = $request->name;

        if (isset($request->status) && $guide->status_id != $request->status) {
            $guide->status_id = $request->status;
        }

        if ($guide->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos guardados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron guardar los datos.']);
    }

}

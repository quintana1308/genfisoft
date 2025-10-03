<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;

class Classification extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'classifications';

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
    public function getClassifications($request)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $classifications = Classification::with('status')->where('company_id', $activeCompanyId)->get();

        if ($classifications->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($classifications)
            ->addIndexColumn() // para el índice
            ->addColumn('name', function ($classification) {
                return $classification->name;
            })
            ->addColumn('status', function ($classification) {
                $statusName = $classification->status ? $classification->status->name : 'Sin estado';

                // Personalizar classificationes
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-classification:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($classification) {
                $id = $classification->id;
                
                $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editClassification(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                return '<div class="text-center">' . $btnEdit . '</div>';
            })
            ->rawColumns(['name', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function createClassification($request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $activeCompanyId = $user->active_company_id;

        // Evitar duplicados
        if (Classification::where('company_id', $activeCompanyId)->where('name', $request->name)->exists()) {
            return response()->json(['status' => false, 'msg' => 'La Clasificación ya existe.']);
        }

        Classification::create([
            'name' => $request->name,
            'user_id' => $userId,
            'company_id' => $activeCompanyId,
        ]);

        return response()->json(['status' => true, 'msg' => 'Clasificación creada correctamente.']);
    }

    public function getClassification($id)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $classification = Classification::with('status') // Cargar la relación
                ->where('id', $id)
                ->where('company_id', $activeCompanyId)
                ->first();

        if (!$classification) {
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
                'id' => $classification->id,
                'name' => $classification->name,
                'status_id' => $classification->status_id,
            ],
            'statuses' => $statuses
        ]);
    }

    public function updateClassification($request)
    {
        $classification = $this->find($request->id);
        if (!$classification) {
            return response()->json(['status' => false, 'msg' => 'Clasificación no encontrada.']);
        }
        
        $classification->name = $request->name;

        if (isset($request->status) && $classification->status_id != $request->status) {
            $classification->status_id = $request->status;
        }

        if ($classification->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos guardados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron guardar los datos.']);
    }

}

<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;

class StatusReproductive extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'status_reproductives';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
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
    public function getStatusReproductives($request)
    {
        $userId = Auth::id();

        $statusReproductives = StatusReproductive::with('status')->where('user_id', $userId)->get();

        if ($statusReproductives->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($statusReproductives)
            ->addIndexColumn() // para el índice
            ->addColumn('name', function ($statusReproductive) {
                return $statusReproductive->name;
            })
            ->addColumn('status', function ($statusReproductive) {
                $statusName = $statusReproductive->status ? $statusReproductive->status->name : 'Sin estado';

                // Personalizar colores
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-color:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($statusReproductive) {
                $id = $statusReproductive->id;
                
                $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editStatusReproductive(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                return '<div class="text-center">' . $btnEdit . '</div>';
            })
            ->rawColumns(['name', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function createStatusReproductive($request)
    {
        $userId = auth()->id();

        // Evitar duplicados
        if (StatusReproductive::where('user_id', $userId)->where('name', $request->name)->exists()) {
            return response()->json(['status' => false, 'msg' => 'El estado reproductivo ya existe.']);
        }

        StatusReproductive::create([
            'name' => $request->name,
            'user_id' => $userId,
        ]);

        return response()->json(['status' => true, 'msg' => 'Estado reproductivo creado correctamente.']);
    }

    public function getStatusReproductive($id)
    {
        $userId = Auth::id();

        $statusReproductive = StatusReproductive::with('status') // Cargar la relación
                ->where('id', $id)
                ->where('user_id', $userId)
                ->first();

        if (!$statusReproductive) {
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
                'id' => $statusReproductive->id,
                'name' => $statusReproductive->name,
                'status_id' => $statusReproductive->status_id,
            ],
            'statuses' => $statuses
        ]);
    }

    public function updateStatusReproductive($request)
    {
        $statusReproductive = $this->find($request->id);
        if (!$statusReproductive) {
            return response()->json(['status' => false, 'msg' => 'Estado reproductivo no encontrado.']);
        }
        
        $statusReproductive->name = $request->name;

        if (isset($request->status) && $statusReproductive->status_id != $request->status) {
            $statusReproductive->status_id = $request->status;
        }

        if ($statusReproductive->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos guardados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron guardar los datos.']);
    }

}

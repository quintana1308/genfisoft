<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;

class CauseEntry extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'cause_entrys';

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
    public function getCauseEntrys($request)
    {
        $userId = Auth::id();

        $causeEntrys = CauseEntry::with('status')->where('user_id', $userId)->get();

        if ($causeEntrys->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($causeEntrys)
            ->addIndexColumn() // para el índice
            ->addColumn('name', function ($causeEntry) {
                return $causeEntry->name;
            })
            ->addColumn('status', function ($causeEntry) {
                $statusName = $causeEntry->status ? $causeEntry->status->name : 'Sin estado';

                // Personalizar colores
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-color:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($causeEntry) {
                $id = $causeEntry->id;
                
                $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editCauseEntry(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                return '<div class="text-center">' . $btnEdit . '</div>';
            })
            ->rawColumns(['name', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function createCauseEntry($request)
    {
        $userId = auth()->id();

        // Evitar duplicados
        if (CauseEntry::where('user_id', $userId)->where('name', $request->name)->exists()) {
            return response()->json(['status' => false, 'msg' => 'La causa de entrada ya existe.']);
        }

        CauseEntry::create([
            'name' => $request->name,
            'user_id' => $userId,
        ]);

        return response()->json(['status' => true, 'msg' => 'Causa de entrada creada correctamente.']);
    }

    public function getCauseEntry($id)
    {
        $userId = Auth::id();

        $causeEntry = CauseEntry::with('status') // Cargar la relación
                ->where('id', $id)
                ->where('user_id', $userId)
                ->first();

        if (!$causeEntry) {
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
                'id' => $causeEntry->id,
                'name' => $causeEntry->name,
                'status_id' => $causeEntry->status_id,
            ],
            'statuses' => $statuses
        ]);
    }

    public function updateCauseEntry($request)
    {
        $causeEntry = $this->find($request->id);
        if (!$causeEntry) {
            return response()->json(['status' => false, 'msg' => 'Causa de entrada no encontrado.']);
        }
        
        $causeEntry->name = $request->name;

        if (isset($request->status) && $causeEntry->status_id != $request->status) {
            $causeEntry->status_id = $request->status;
        }

        if ($causeEntry->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos guardados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron guardar los datos.']);
    }

}

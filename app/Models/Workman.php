<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;

class Workman extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'workmans';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'description',
        'date',
        'cost',
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
    public function getWorkmans($request)
    {
        $userId = Auth::id();
        
        $query = Workman::with('status')->where('user_id', $userId);

        // Si se envían las dos fechas
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('date', [$request->fecha_inicio, $request->fecha_fin]);
        }
        // Si solo se envía fecha_inicio
        elseif ($request->filled('fecha_inicio')) {
            $query->whereDate('date', '>=', $request->fecha_inicio);
        }
        // Si solo se envía fecha_fin
        elseif ($request->filled('fecha_fin')) {
            $query->whereDate('date', '<=', $request->fecha_fin);
        }

        $workmans = $query->get();

        if ($workmans->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($workmans)
            ->addIndexColumn() // para el índice
            ->addColumn('description', function ($workman) {
                return $workman->description;
            })
            ->addColumn('date', function ($workman) {
                return $workman->date;
            })
            ->addColumn('cost', function ($workman) {
                return '$ '.$workman->cost;
            })
            ->addColumn('status', function ($workman) {
                $statusName = $workman->status ? $workman->status->name : 'Sin estado';

                // Personalizar colores
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-color:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($workman) {
                $id = $workman->id;
                
                $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editWorkman(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                return '<div class="text-center">' . $btnEdit . '</div>';
            })
            ->rawColumns(['description', 'date', 'cost', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function createWorkman($request)
    {
        $userId = auth()->id();

        // Evitar duplicados
        if (Workman::where('user_id', $userId)->where('description', $request->description)->exists()) {
            return response()->json(['status' => false, 'msg' => 'La hechura ya existe.']);
        }

        Workman::create([
            'description' => $request->description,
            'date' => $request->date,
            'cost' => $request->cost,
            'user_id' => $userId,
        ]);

        return response()->json(['status' => true, 'msg' => 'Hechura creada correctamente.']);
    }

    public function getWorkman($id)
    {
        $userId = Auth::id();

        $workman = Workman::with('status') // Cargar la relación
                ->where('id', $id)
                ->where('user_id', $userId)
                ->first();

        if (!$workman) {
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
                'id' => $workman->id,
                'description' => $workman->description,
                'date' => $workman->date,
                'cost' => $workman->cost,
                'status_id' => $workman->status_id,
            ],
            'statuses' => $statuses
        ]);
    }

    public function updateWorkman($request)
    {
        $workman = $this->find($request->id);
        if (!$workman) {
            return response()->json(['status' => false, 'msg' => 'Hechura no encontrada.']);
        }
        
        $workman->description = $request->description;
        $workman->date = $request->date;
        $workman->cost = $request->cost;

        if (isset($request->status) && $workman->status_id != $request->status) {
            $workman->status_id = $request->status;
        }

        if ($workman->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos guardados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron guardar los datos.']);
    }

}

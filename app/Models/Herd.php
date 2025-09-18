<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;

class Herd extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'herds';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'code',
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
    public function getHerds($request)
    {
        $userId = Auth::id();

        $herds = Herd::with('status')->where('user_id', $userId)->get();

        if ($herds->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($herds)
            ->addIndexColumn() // para el índice
             ->addColumn('code', function ($herd) {
                return $herd->code;
            })
            ->addColumn('name', function ($herd) {
                return $herd->name;
            })
            ->addColumn('status', function ($herd) {
                $statusName = $herd->status ? $herd->status->name : 'Sin estado';

                // Personalizar herdes
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-herd:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($herd) {
                $id = $herd->id;
                
                $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editHerd(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                return '<div class="text-center">' . $btnEdit . '</div>';
            })
            ->rawColumns(['code', 'name', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function createHerd($request)
    {
        $userId = auth()->id();

        // Evitar duplicados
        if (Herd::where('user_id', $userId)->where('code', $request->code)->exists()) {
            return response()->json(['status' => false, 'msg' => 'El rebaño ya existe.']);
        }

        Herd::create([
            'code' => $request->code,
            'name' => $request->name,
            'user_id' => $userId,
        ]);

        return response()->json(['status' => true, 'msg' => 'Rebaño creado correctamente.']);
    }

    public function getHerd($id)
    {
        $userId = Auth::id();

        $herd = Herd::with('status') // Cargar la relación
                ->where('id', $id)
                ->where('user_id', $userId)
                ->first();

        if (!$herd) {
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
                'id' => $herd->id,
                'code' => $herd->code,
                'name' => $herd->name,
                'status_id' => $herd->status_id,
            ],
            'statuses' => $statuses
        ]);
    }

    public function updateHerd($request)
    {
        $herd = $this->find($request->id);
        if (!$herd) {
            return response()->json(['status' => false, 'msg' => 'Rebaño no encontrado.']);
        }
        
        $herd->name = $request->name;
        $herd->code = $request->code;

        if (isset($request->status) && $herd->status_id != $request->status) {
            $herd->status_id = $request->status;
        }

        if ($herd->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos guardados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron guardar los datos.']);
    }

}

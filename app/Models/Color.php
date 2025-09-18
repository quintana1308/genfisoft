<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;

class Color extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'colors';

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
    public function getColors($request)
    {
        $userId = Auth::id();

        $colors = Color::with('status')->where('user_id', $userId)->get();

        if ($colors->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($colors)
            ->addIndexColumn() // para el índice
            ->addColumn('name', function ($color) {
                return $color->name;
            })
            ->addColumn('status', function ($color) {
                $statusName = $color->status ? $color->status->name : 'Sin estado';

                // Personalizar colores
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-color:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($color) {
                $id = $color->id;
                
                $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editColor(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                return '<div class="text-center">' . $btnEdit . '</div>';
            })
            ->rawColumns(['name', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function createColor($request)
    {
        $userId = auth()->id();

        // Evitar duplicados
        if (Color::where('user_id', $userId)->where('name', $request->name)->exists()) {
            return response()->json(['status' => false, 'msg' => 'El color ya existe.']);
        }

        Color::create([
            'name' => $request->name,
            'user_id' => $userId,
        ]);

        return response()->json(['status' => true, 'msg' => 'Color creado correctamente.']);
    }

    public function getColor($id)
    {
        $userId = Auth::id();

        $color = Color::with('status') // Cargar la relación
                ->where('id', $id)
                ->where('user_id', $userId)
                ->first();

        if (!$color) {
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
                'id' => $color->id,
                'name' => $color->name,
                'status_id' => $color->status_id,
            ],
            'statuses' => $statuses
        ]);
    }

    public function updateColor($request)
    {
        $color = $this->find($request->id);
        if (!$color) {
            return response()->json(['status' => false, 'msg' => 'Color no encontrado.']);
        }
        
        $color->name = $request->name;

        if (isset($request->status) && $color->status_id != $request->status) {
            $color->status_id = $request->status;
        }

        if ($color->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos guardados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron guardar los datos.']);
    }

}

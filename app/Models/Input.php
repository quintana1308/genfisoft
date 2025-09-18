<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;
use App\Models\Owner;

class Input extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'inputs';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'owner_id',
        'description',
        'price',
        'date',
        'quantity',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }

    //CONSULTAS
    public function getInputs($request)
    {
        $userId = Auth::id();

        $query = Input::with('status')->where('user_id', $userId);

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

        $inputs = $query->get();
        
        if ($inputs->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($inputs)
            ->addIndexColumn() // para el índice
            ->addColumn('description', function ($input) {
                return $input->description;
            })
            ->addColumn('owner', function ($input) {
                return $input->owner->name;
            })
            ->addColumn('price', function ($input) {
                return '$ '.$input->price;
            })
            ->addColumn('quantity', function ($input) {
                return $input->quantity;
            })
            ->addColumn('date', function ($input) {
                return $input->date;
            })
            ->addColumn('status', function ($input) {
                $statusName = $input->status ? $input->status->name : 'Sin estado';

                // Personalizar colores
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-color:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($input) {
                $id = $input->id;
                
                $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editInput(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                return '<div class="text-center">' . $btnEdit . '</div>';
            })
            ->rawColumns(['description', 'owner', 'price', 'quantity', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function createInput($request)
    {
        $userId = auth()->id();

        // Evitar duplicados
        if (Input::where('user_id', $userId)->where('description', $request->description)->exists()) {
            return response()->json(['status' => false, 'msg' => 'El insumo ya existe.']);
        }

        Input::create([
            'description' => $request->description,
            'owner_id' => $request->owner,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'date' => $request->date,
            'user_id' => $userId,
        ]);

        return response()->json(['status' => true, 'msg' => 'Insumo creado correctamente.']);
    }

    public function getInput($id)
    {
        $userId = Auth::id();

        $input = Input::with('status') // Cargar la relación
                ->where('id', $id)
                ->where('user_id', $userId)
                ->first();

        if (!$input) {
            return response()->json([
                'status' => false,
                'msg' => 'Datos no encontrados.'
            ]);
        }

        // Obtener todos los status
        $statuses = Status::orderBy('name')->get(['id', 'name']);

        $owners = Owner::where('user_id', $userId)->orderBy('name')->whereNotIn('status_id', [2, 3])->get(['id', 'name']);

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $input->id,
                'description' => $input->description,
                'owner' => optional($input->owner)->id,
                'price' => $input->price,
                'quantity' => $input->quantity,
                'date' => $input->date,
                'status_id' => $input->status_id,
            ],
            'statuses' => $statuses,
            'owners' => $owners
        ]);
    }

    public function updateInput($request)
    {
        $input = $this->find($request->id);
        if (!$input) {
            return response()->json(['status' => false, 'msg' => 'Insumo no encontrado.']);
        }
        
        $input->description = $request->description;
        $input->owner_id = $request->owner;
        $input->price = $request->price;
        $input->quantity = $request->quantity;
        $input->date = $request->date;

        if (isset($request->status) && $input->status_id != $request->status) {
            $input->status_id = $request->status;
        }

        if ($input->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos guardados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron guardar los datos.']);
    }

}
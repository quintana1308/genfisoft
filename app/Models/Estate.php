<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;

class Estate extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'estates';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'company_id',
        'description',
        'date_purchase',
        'price',
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
    public function getEstates($request)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $query = Estate::with('status')->where('company_id', $activeCompanyId);

        // Si se envían las dos fechas
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('date_purchase', [$request->fecha_inicio, $request->fecha_fin]);
        }
        // Si solo se envía fecha_inicio
        elseif ($request->filled('fecha_inicio')) {
            $query->whereDate('date_purchase', '>=', $request->fecha_inicio);
        }
        // Si solo se envía fecha_fin
        elseif ($request->filled('fecha_fin')) {
            $query->whereDate('date_purchase', '<=', $request->fecha_fin);
        }

        $estates = $query->get();

        if ($estates->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($estates)
            ->addIndexColumn() // para el índice
            ->addColumn('description', function ($estate) {
                return $estate->description;
            })
            ->addColumn('date_purchase', function ($estate) {
                return $estate->date_purchase;
            })
            ->addColumn('price', function ($estate) {
                return '$ '.$estate->price;
            })
            ->addColumn('status', function ($estate) {
                $statusName = $estate->status ? $estate->status->name : 'Sin estado';

                // Personalizar colores
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-color:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($estate) {
                $id = $estate->id;
                
                $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editEstate(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                return '<div class="text-center">' . $btnEdit . '</div>';
            })
            ->rawColumns(['description', 'date_purchase', 'price', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function createEstate($request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $activeCompanyId = $user->active_company_id;

        // Evitar duplicados
        if (Estate::where('company_id', $activeCompanyId)->where('description', $request->description)->exists()) {
            return response()->json(['status' => false, 'msg' => 'El Recurso ya existe.']);
        }

        Estate::create([
            'description' => $request->description,
            'date_purchase' => $request->datePurchase,
            'price' => $request->price,
            'user_id' => $userId,
            'company_id' => $activeCompanyId,
        ]);

        return response()->json(['status' => true, 'msg' => 'Recurso creado correctamente.']);
    }

    public function getEstate($id)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $estate = Estate::with('status') // Cargar la relación
                ->where('id', $id)
                ->where('company_id', $activeCompanyId)
                ->first();

        if (!$estate) {
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
                'id' => $estate->id,
                'description' => $estate->description,
                'date_purchase' => $estate->date_purchase,
                'price' => $estate->price,
                'status_id' => $estate->status_id,
            ],
            'statuses' => $statuses
        ]);
    }

    public function updateEstate($request)
    {
        $estate = $this->find($request->id);
        if (!$estate) {
            return response()->json(['status' => false, 'msg' => 'Recurso no encontrado.']);
        }
        
        $estate->description = $request->description;
        $estate->date_purchase = $request->datePurchase;
        $estate->price = $request->price;

        if (isset($request->status) && $estate->status_id != $request->status) {
            $estate->status_id = $request->status;
        }

        if ($estate->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos guardados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron guardar los datos.']);
    }

}

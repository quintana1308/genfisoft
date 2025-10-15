<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;
use App\Models\Cattle;
use App\Models\Product;

class Veterinarian extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'veterinarians';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'company_id',
        'cattle_id',
        'product_id',
        'symptoms',
        'date_start',
        'date_end',
        'observation',
        'status_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function Cattle(): BelongsTo
    {
        return $this->belongsTo(Cattle::class, 'cattle_id', 'id');
    }

    public function Product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
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
    public function getVeterinarians($request)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $veterinarians = Veterinarian::with('status')->where('company_id', $activeCompanyId)->get();

        if ($veterinarians->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($veterinarians)
            ->addIndexColumn() // para el índice
             ->addColumn('cattle', function ($veterinarian) {
                return $veterinarian->cattle->code;
            })
            ->addColumn('product', function ($veterinarian) {
                return $veterinarian->product->name;
            })
            ->addColumn('symptoms', function ($veterinarian) {
                return $veterinarian->symptoms;
            })
            ->addColumn('date_start', function ($veterinarian) {
                return $veterinarian->date_start;
            })
            ->addColumn('date_end', function ($veterinarian) {
                return $veterinarian->date_end;
            })
            ->addColumn('status', function ($veterinarian) {
                $statusName = $veterinarian->status ? $veterinarian->status->name : 'Sin estado';

                // Personalizar
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-color:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($veterinarian) {
                $id = $veterinarian->id;
                $btnView = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="viewVeterinarian(`' . $id . '`)"><i class="fa-solid fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editVeterinarian(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                return '<div class="text-center">' . $btnView . ' ' . $btnEdit . '</div>';
            })
            ->rawColumns(['cattle', 'product', 'symptoms', 'date_start', 'date_end', 'status', 'options'])
            ->make(true);
            
        return $data;
    }

    public function newVeterinarians()
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;
        
        $status = Status::all();
        $cattles = Cattle::where('company_id', $activeCompanyId)->whereNotIn('status_id', [2, 3])->get();
        $products = Product::where('company_id', $activeCompanyId)->whereNotIn('status_id', [2, 3])->get();
        
        return [
            'status' => $status,
            'cattles' => $cattles,
            'products' => $products
        ];
    }

    public function createVeterinarian($request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $activeCompanyId = $user->active_company_id;

        Veterinarian::create([
            'user_id' => $userId,
            'company_id' => $activeCompanyId,
            'cattle_id' => $request->cattle,
            'product_id' => $request->product,
            'symptoms' => $request->symptoms ?: null,
            'date_start' => $request->dateStart,
            'date_end' => $request->dateEnd ?: null,
            'observation' => $request->observation ?: null,
            'status_id' => $request->status,
        ]);

        return response()->json(['status' => true, 'msg' => 'Servicio se ha creado correctamente.']);
    }

    public function getVeterinarian($id)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $veterinarian = Veterinarian::with('status') // Cargar la relación
                ->where('id', $id)
                ->where('company_id', $activeCompanyId)
                ->first();

        if (!$veterinarian) {
            return response()->json([
                'status' => false,
                'msg' => 'Datos no encontrados.'
            ]);
        }

        // Obtener todos los status
        $statuses = Status::orderBy('name')->get(['id', 'name']);
        $cattles = Cattle::where('company_id', $activeCompanyId)->orderBy('code')->whereNotIn('status_id', [2, 3])->get(['id', 'code']);
        $products = Product::where('company_id', $activeCompanyId)->orderBy('name')->whereNotIn('status_id', [2, 3])->get(['id', 'name']);

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $veterinarian->id,
                'symptoms' => $veterinarian->symptoms,
                'date_start' => $veterinarian->date_start,
                'date_end' => $veterinarian->date_end,
                'cattle' => $veterinarian->cattle_id,
                'product' => $veterinarian->product_id,
                'observation' => $veterinarian->observation,
            ],
            'cattles' => $cattles,
            'products' => $products,
            'statuses' => $statuses
        ]);
    }

    public function getVeterinarianView($id)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $veterinarian = Veterinarian::with(['Cattle',
                                'Product',
                                'status'])
                ->where('id', $id)
                ->where('company_id', $activeCompanyId)
                ->first();

        if (!$veterinarian) {
            $data = response()->json([
                'status' => false,
                'msg' => 'Datos no encontrados.'
            ]);
        }else{
            $data = response()->json([
                'status' => true,
                'veterinarian' => $veterinarian
            ]);
        }

        return $data;
    }

    public function updateVeterinarian($request)
    {   

        $veterinarian = $this->find($request->idEdit);
        if (!$veterinarian) {
            return response()->json(['status' => false, 'msg' => 'Servicio veterinario no encontrado.']);
        }
        
        $veterinarian->cattle_id= $request->cattleEdit;
        $veterinarian->product_id = $request->productEdit;
        $veterinarian->symptoms = $request->symptomsEdit ?: null;
        $veterinarian->date_start = $request->dateStartEdit;
        $veterinarian->date_end = $request->dateEndEdit ?: null;
        $veterinarian->observation = $request->observationEdit ?: null;

        if (isset($request->statusEdit) && $veterinarian->status_id != $request->statusEdit) {
            $veterinarian->status_id = $request->statusEdit;
        }

        if ($veterinarian->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos guardados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron guardar los datos.']);
    }

}

<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;

class Product extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'products';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'company_id',
        'name',
        'type',
        'status_id'
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
    public function getProducts($request)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $products = Product::with('status')->where('company_id', $activeCompanyId)->get();

        if ($products->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($products)
            ->addIndexColumn() // para el índice
            ->addColumn('name', function ($product) {
                return $product->name;
            })
            ->addColumn('type', function ($product) {
                return $product->type;
            })
            ->addColumn('status', function ($product) {
                $statusName = $product->status ? $product->status->name : 'Sin estado';

                // Personalizar colores
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-color:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($product) {
                $id = $product->id;
                
                $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editProduct(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                return '<div class="text-center">' . $btnEdit . '</div>';
            })
            ->rawColumns(['name', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function createProduct($request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $activeCompanyId = $user->active_company_id;

        // Evitar duplicados
        if (Product::where('company_id', $activeCompanyId)->where('name', $request->name)->exists()) {
            return response()->json(['status' => false, 'msg' => 'El producto ya existe.']);
        }

        Product::create([
            'name' => $request->name,
            'type' => $request->type,
            'user_id' => $userId,
            'company_id' => $activeCompanyId,
        ]);

        return response()->json(['status' => true, 'msg' => 'Producto creado correctamente.']);
    }

    public function getProduct($id)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $product = Product::with('status') // Cargar la relación
                ->where('id', $id)
                ->where('company_id', $activeCompanyId)
                ->first();

        if (!$product) {
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
                'id' => $product->id,
                'name' => $product->name,
                'type' => $product->type,
                'status_id' => $product->status_id,
            ],
            'statuses' => $statuses
        ]);
    }

    public function updateProduct($request)
    {
        $product = $this->find($request->id);
        if (!$product) {
            return response()->json(['status' => false, 'msg' => 'Producto no encontrado.']);
        }
        
        $product->name = $request->name;

        if (isset($request->status) && $product->status_id != $request->status) {
            $product->status_id = $request->status;
        }

        if ($product->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos guardados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron guardar los datos.']);
    }

}

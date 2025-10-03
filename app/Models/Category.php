<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;

class Category extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'categorys';

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
    public function getCategorys($request)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $categorys = Category::with('status')->where('company_id', $activeCompanyId)->get();

        if ($categorys->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($categorys)
            ->addIndexColumn() // para el índice
            ->addColumn('name', function ($category) {
                return $category->name;
            })
            ->addColumn('status', function ($category) {
                $statusName = $category->status ? $category->status->name : 'Sin estado';

                // Personalizar colores
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-color:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($category) {
                $id = $category->id;
                
                $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editCategory(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                return '<div class="text-center">' . $btnEdit . '</div>';
            })
            ->rawColumns(['name', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function createCategory($request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $activeCompanyId = $user->active_company_id;

        // Evitar duplicados
        if (Category::where('company_id', $activeCompanyId)->where('name', $request->name)->exists()) {
            return response()->json(['status' => false, 'msg' => 'La categoría ya existe.']);
        }

        Category::create([
            'name' => $request->name,
            'user_id' => $userId,
            'company_id' => $activeCompanyId,
        ]);

        return response()->json(['status' => true, 'msg' => 'Categoría creada correctamente.']);
    }

    public function getCategory($id)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $category = Category::with('status') // Cargar la relación
                ->where('id', $id)
                ->where('company_id', $activeCompanyId)
                ->first();

        if (!$category) {
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
                'id' => $category->id,
                'name' => $category->name,
                'status_id' => $category->status_id,
            ],
            'statuses' => $statuses
        ]);
    }

    public function updateCategory($request)
    {
        $category = $this->find($request->id);
        if (!$category) {
            return response()->json(['status' => false, 'msg' => 'Categoría no encontrado.']);
        }
        
        $category->name = $request->name;

        if (isset($request->status) && $category->status_id != $request->status) {
            $category->status_id = $request->status;
        }

        if ($category->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos guardados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron guardar los datos.']);
    }

}

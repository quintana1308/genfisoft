<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class Sale extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'sales';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'company_id',
        'cattle_id',
        'sale_price',
        'sale_date',
        'observations',
        'status_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function cattle(): BelongsTo
    {
        return $this->belongsTo(Cattle::class, 'cattle_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    // CONSULTAS
    public function getSales($request)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $sales = Sale::with(['cattle', 'status'])
            ->where('company_id', $activeCompanyId)
            ->get();

        if ($sales->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($sales)
            ->addIndexColumn()
            ->addColumn('cattle_code', function ($sale) {
                return $sale->cattle ? $sale->cattle->code : 'N/A';
            })
            ->addColumn('sale_price', function ($sale) {
                return '$' . number_format($sale->sale_price, 2);
            })
            ->addColumn('sale_date', function ($sale) {
                return date('d/m/Y', strtotime($sale->sale_date));
            })
            ->addColumn('options', function ($sale) {
                $id = $sale->id;
                $btnView = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="viewSale(`' . $id . '`)"><i class="fa-solid fa-eye"></i></button>';
                return '<div class="text-center">' . $btnView . '</div>';
            })
            ->rawColumns(['cattle_code', 'sale_price', 'sale_date', 'options'])
            ->make(true);

        return $data;
    }

    public function createSale($request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $activeCompanyId = $user->active_company_id;

        // Verificar que el animal no esté ya vendido
        $cattle = Cattle::find($request->cattle_id);
        if (!$cattle) {
            return response()->json(['status' => false, 'msg' => 'Animal no encontrado.']);
        }

        if ($cattle->status_id == 4) {
            return response()->json(['status' => false, 'msg' => 'Este animal ya está vendido.']);
        }

        DB::beginTransaction();
        try {
            // Crear la venta
            Sale::create([
                'user_id' => $userId,
                'company_id' => $activeCompanyId,
                'cattle_id' => $request->cattle_id,
                'sale_price' => $request->sale_price,
                'sale_date' => $request->sale_date,
                'observations' => $request->observations,
                'status_id' => 1
            ]);

            // Cambiar el estado del animal a "Vendido" (status_id = 4)
            $cattle->status_id = 4;
            $cattle->save();

            DB::commit();
            return response()->json(['status' => true, 'msg' => 'Venta registrada correctamente.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'msg' => 'Error al registrar la venta: ' . $e->getMessage()]);
        }
    }

    public function getSale($id)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $sale = Sale::with(['cattle', 'status'])
            ->where('id', $id)
            ->where('company_id', $activeCompanyId)
            ->first();

        if (!$sale) {
            return response()->json([
                'status' => false,
                'msg' => 'Datos no encontrados.'
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $sale->id,
                'cattle_code' => $sale->cattle ? $sale->cattle->code : 'N/A',
                'sale_price' => $sale->sale_price,
                'sale_date' => $sale->sale_date,
                'observations' => $sale->observations,
                'status' => $sale->status ? $sale->status->name : 'N/A'
            ]
        ]);
    }
}

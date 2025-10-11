<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class MilkProduction extends Model
{
    use HasFactory;

    protected $table = 'milk_production';

    protected $fillable = [
        'user_id',
        'company_id',
        'cattle_id',
        'production_date',
        'liters',
        'price_per_liter',
        'total_price',
        'observations'
    ];

    // Relaciones
    public function cattle()
    {
        return $this->belongsTo(Cattle::class, 'cattle_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Obtener producción diaria
    public function getDailyProduction($request)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $productions = MilkProduction::with('cattle')
            ->where('company_id', $activeCompanyId)
            ->orderBy('production_date', 'desc')
            ->orderBy('cattle_id')
            ->get();

        if ($productions->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($productions)
            ->addIndexColumn()
            ->addColumn('production_date', function ($production) {
                return $production->production_date;
            })
            ->addColumn('cattle_code', function ($production) {
                return $production->cattle ? $production->cattle->code : 'N/A';
            })
            ->addColumn('liters', function ($production) {
                return number_format($production->liters, 2) . ' L';
            })
            ->addColumn('price_per_liter', function ($production) {
                return '$' . number_format($production->price_per_liter, 2);
            })
            ->addColumn('total_price', function ($production) {
                return '$' . number_format($production->total_price, 2);
            })
            ->addColumn('options', function ($production) {
                $id = $production->id;
                $btnView = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="viewProduction(`' . $id . '`)"><i class="fa-solid fa-eye"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-link btn-sm btn-icon" onClick="deleteProduction(`' . $id . '`)"><i class="fa-solid fa-trash"></i></button>';
                return '<div class="text-center">' . $btnView . $btnDelete . '</div>';
            })
            ->rawColumns(['options'])
            ->make(true);

        return $data;
    }

    // Crear registro de producción
    public function createProduction($request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $activeCompanyId = $user->active_company_id;

        // Verificar si ya existe un registro para esta vaca en esta fecha
        $exists = MilkProduction::where('cattle_id', $request->cattle_id)
            ->where('production_date', $request->production_date)
            ->where('company_id', $activeCompanyId)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'msg' => 'Ya existe un registro de producción para esta vaca en esta fecha.'
            ]);
        }

        // Calcular total
        $totalPrice = $request->liters * $request->price_per_liter;

        $production = new MilkProduction();
        $production->user_id = $userId;
        $production->company_id = $activeCompanyId;
        $production->cattle_id = $request->cattle_id;
        $production->production_date = $request->production_date;
        $production->liters = $request->liters;
        $production->price_per_liter = $request->price_per_liter;
        $production->total_price = $totalPrice;
        $production->observations = $request->observations;

        if ($production->save()) {
            return response()->json([
                'status' => true,
                'msg' => 'Producción registrada exitosamente.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Error al registrar la producción.'
            ]);
        }
    }

    // Obtener detalle de producción
    public function getProduction($id)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $production = MilkProduction::with('cattle')
            ->where('id', $id)
            ->where('company_id', $activeCompanyId)
            ->first();

        if (!$production) {
            return response()->json([
                'status' => false,
                'msg' => 'Registro no encontrado.'
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $production
        ]);
    }

    // Eliminar registro
    public function deleteProduction($id)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $production = MilkProduction::where('id', $id)
            ->where('company_id', $activeCompanyId)
            ->first();

        if (!$production) {
            return response()->json([
                'status' => false,
                'msg' => 'Registro no encontrado.'
            ]);
        }

        if ($production->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Registro eliminado exitosamente.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Error al eliminar el registro.'
            ]);
        }
    }

    // Obtener reporte semanal
    public function getWeeklyReport($request)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $report = MilkProduction::select(
                'cattle_id',
                DB::raw('SUM(liters) as total_liters'),
                DB::raw('SUM(total_price) as total_price'),
                DB::raw('AVG(price_per_liter) as avg_price_per_liter'),
                DB::raw('COUNT(*) as days_produced')
            )
            ->with('cattle')
            ->where('company_id', $activeCompanyId)
            ->whereBetween('production_date', [$startDate, $endDate])
            ->groupBy('cattle_id')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $report,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }
}

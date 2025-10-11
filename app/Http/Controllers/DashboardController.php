<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Cattle;
use App\Models\StatusReproductive;
use App\Models\StatusProductive;
use App\Models\Category;
use App\Models\Death;
use App\Models\Estate;
use App\Models\Input;
use Carbon\Carbon;
use App\Models\Workman;

class DashboardController extends Controller
{
    public function dashboard()
    {   
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $totalCost = Workman::where('company_id', $activeCompanyId)->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('cost');

        $totalEstate = Estate::where('company_id', $activeCompanyId)->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('price');

        $totalNursing = Cattle::where('company_id', $activeCompanyId)->where('classification_id', 4)->count();

        $totalInput = Input::where('company_id', $activeCompanyId)->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('price');

        $totalDeath = Death::where('company_id', $activeCompanyId)->count();

        return view('dashboard', compact('totalCost', 'totalEstate', 'totalNursing', 'totalInput', 'totalDeath'));
    }

    public function getReproductiveStats()
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        // Total de animales con estado reproductivo (sin NULL) de la empresa
        $total = Cattle::where('company_id', $activeCompanyId)->whereNotNull('status_reproductive_id')->count();

        if ($total == 0) {
            return response()->json([
                'labels' => [],
                'counts' => [],
                'total' => 0
            ]);
        }

        // Agrupar por estado reproductivo filtrado por empresa
        $data = Cattle::selectRaw('status_reproductive_id, COUNT(*) as total')
            ->where('company_id', $activeCompanyId)
            ->whereNotNull('cattles.status_reproductive_id')
            ->groupBy('status_reproductive_id')
            ->pluck('total', 'status_reproductive_id');

        $labels = [];
        $counts = [];
        foreach ($data as $statusId => $count) {
            $statusName = StatusReproductive::find($statusId)->name ?? 'Desconocido';
            $labels[] = $statusName;
            $counts[] = $count; // cantidad real
        }

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
            'total' => $total
        ]);
    }

    public function getProductiveStats()
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        // Total de animales con estado productivo (sin NULL) de la empresa
        $total = Cattle::where('company_id', $activeCompanyId)->whereNotNull('status_productive_id')->count();

        if ($total == 0) {
            return response()->json([
                'labels' => [],
                'counts' => [],
                'total' => 0
            ]);
        }

        // Agrupar por estado productivo filtrado por empresa
        $data = Cattle::selectRaw('status_productive_id, COUNT(*) as total')
            ->where('company_id', $activeCompanyId)
            ->whereNotNull('cattles.status_productive_id')
            ->groupBy('status_productive_id')
            ->pluck('total', 'status_productive_id');

        $labels = [];
        $counts = [];
        foreach ($data as $statusId => $count) {
            $statusName = StatusProductive::find($statusId)->name ?? 'Desconocido';
            $labels[] = $statusName;
            $counts[] = $count; // cantidad real
        }

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
            'total' => $total
        ]);
    }

    public function getCategoryStats()
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        // Total de animales con categoría (sin NULL) de la empresa
        $total = Cattle::where('company_id', $activeCompanyId)->whereNotNull('category_id')->count();

        if ($total == 0) {
            return response()->json([
                'labels' => [],
                'counts' => [],
                'total' => 0
            ]);
        }

        // Agrupar por categoría filtrado por empresa
        $data = Cattle::selectRaw('category_id, COUNT(*) as total')
            ->where('company_id', $activeCompanyId)
            ->whereNotNull('cattles.category_id')
            ->groupBy('category_id')
            ->pluck('total', 'category_id');

        $labels = [];
        $counts = [];
        foreach ($data as $statusId => $count) {
            $statusName = Category::find($statusId)->name ?? 'Desconocido';
            $labels[] = $statusName;
            $counts[] = $count; // cantidad real
        }

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
            'total' => $total
        ]);
    }

    public function getInputsByOwner()
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $inputs = Input::with('owner')
            ->where('company_id', $activeCompanyId)
            ->selectRaw('owner_id, SUM(quantity) as total_quantity, SUM(price) as total_spent')
            ->groupBy('owner_id')
            ->get();

        if ($inputs->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($inputs)
            ->addIndexColumn()
            ->addColumn('owner', function ($input) {
                return $input->owner ? $input->owner->name : 'Sin propietario';
            })
            ->addColumn('total_quantity', function ($input) {
                return $input->total_quantity;
            })
            ->addColumn('total_spent', function ($input) {
                return '$ ' . number_format($input->total_spent, 2);
            })
            ->make(true);

        return $data;
    }

    public function getCategoriesBySex()
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        // Obtener todas las categorías con conteo de machos y hembras
        $categories = Category::select('categorys.id', 'categorys.name')
            ->leftJoin('cattles', function($join) use ($activeCompanyId) {
                $join->on('categorys.id', '=', 'cattles.category_id')
                     ->where('cattles.company_id', '=', $activeCompanyId);
            })
            ->selectRaw('
                COUNT(CASE WHEN cattles.sexo = "Macho" THEN 1 END) as machos,
                COUNT(CASE WHEN cattles.sexo = "Hembra" THEN 1 END) as hembras,
                COUNT(cattles.id) as total
            ')
            ->groupBy('categorys.id', 'categorys.name')
            ->having('total', '>', 0)
            ->orderBy('categorys.name')
            ->get();

        if ($categories->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('category', function ($category) {
                return $category->name;
            })
            ->addColumn('machos', function ($category) {
                return $category->machos;
            })
            ->addColumn('hembras', function ($category) {
                return $category->hembras;
            })
            ->addColumn('total', function ($category) {
                return $category->total;
            })
            ->make(true);

        return $data;
    }

}

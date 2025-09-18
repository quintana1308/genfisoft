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
        $totalCost = Workman::where('user_id', Auth::id())->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('cost');

        $totalEstate = Estate::where('user_id', Auth::id())->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('price');

        $totalNursing = Cattle::where('user_id', Auth::id())->where('classification_id', 4)->count();

        $totalInput = Input::where('user_id', Auth::id())->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('price');

        $totalDeath = Death::where('user_id', Auth::id())->count();

        return view('dashboard', compact('totalCost', 'totalEstate', 'totalNursing', 'totalInput', 'totalDeath'));
    }

    public function getReproductiveStats()
    {
        // Total de animales con estado reproductivo (sin NULL)
        $total = Cattle::whereNotNull('status_reproductive_id')->count();

        if ($total == 0) {
            return response()->json([
                'labels' => [],
                'counts' => [],
                'total' => 0
            ]);
        }

        // Agrupar por estado reproductivo (ya tenías whereNotNull)
        $data = Cattle::selectRaw('status_reproductive_id, COUNT(*) as total')
            ->whereNotNull('cattles.status_reproductive_id')
            ->groupBy('status_reproductive_id')
            ->pluck('total', 'status_reproductive_id');

        $labels = [];
        $counts = [];
        foreach ($data as $statusId => $count) {
            $statusName = StatusReproductive::find($statusId)->name ?? 'Desconocido';
            $labels[] = $statusName;
            $counts[] = round(($count / $total) * 100, 2); // porcentaje respecto al total filtrado
        }

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
            'total' => $total
        ]);
    }

    public function getProductiveStats()
    {
        // Total de animales con estado reproductivo (sin NULL)
        $total = Cattle::whereNotNull('status_productive_id')->count();

        if ($total == 0) {
            return response()->json([
                'labels' => [],
                'counts' => [],
                'total' => 0
            ]);
        }

        // Agrupar por estado reproductivo (ya tenías whereNotNull)
        $data = Cattle::selectRaw('status_productive_id, COUNT(*) as total')
            ->whereNotNull('cattles.status_productive_id')
            ->groupBy('status_productive_id')
            ->pluck('total', 'status_productive_id');

        $labels = [];
        $counts = [];
        foreach ($data as $statusId => $count) {
            $statusName = StatusProductive::find($statusId)->name ?? 'Desconocido';
            $labels[] = $statusName;
            $counts[] = round(($count / $total) * 100, 2); // porcentaje respecto al total filtrado
        }

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
            'total' => $total
        ]);
    }

    public function getCategoryStats()
    {
        // Total de animales con estado reproductivo (sin NULL)
        $total = Cattle::whereNotNull('category_id')->count();

        if ($total == 0) {
            return response()->json([
                'labels' => [],
                'counts' => [],
                'total' => 0
            ]);
        }

        // Agrupar por estado reproductivo (ya tenías whereNotNull)
        $data = Cattle::selectRaw('category_id, COUNT(*) as total')
            ->whereNotNull('cattles.category_id')
            ->groupBy('category_id')
            ->pluck('total', 'category_id');

        $labels = [];
        $counts = [];
        foreach ($data as $statusId => $count) {
            $statusName = Category::find($statusId)->name ?? 'Desconocido';
            $labels[] = $statusName;
            $counts[] = round(($count / $total) * 100, 2); // porcentaje respecto al total filtrado
        }

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
            'total' => $total
        ]);
    }

    public function getInputsByOwner()
    {
        $userId = Auth::id();

        $inputs = Input::with('owner')
            ->where('user_id', $userId)
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

}

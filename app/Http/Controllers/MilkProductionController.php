<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MilkProduction;
use App\Models\Cattle;
use Illuminate\Support\Facades\Auth;

class MilkProductionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        // Obtener solo vacas (hembras) activas
        $cattles = Cattle::where('company_id', $activeCompanyId)
            ->where('sexo', 'Hembra')
            ->whereNotIn('status_id', [2, 4]) // Excluir muertos y vendidos
            ->whereNotNull('code')
            ->orderBy('code')
            ->get(['id', 'code']);

        return view('milk.index', compact('cattles'));
    }

    public function getDailyProduction(Request $request)
    {
        $model = new MilkProduction();
        return $model->getDailyProduction($request);
    }

    public function create(Request $request)
    {
        $request->validate([
            'cattle_id' => 'required',
            'production_date' => 'required|date',
            'liters' => 'required|numeric|min:0',
            'price_per_liter' => 'required|numeric|min:0'
        ]);

        $model = new MilkProduction();
        return $model->createProduction($request);
    }

    public function getProduction($id)
    {
        $model = new MilkProduction();
        return $model->getProduction($id);
    }

    public function delete($id)
    {
        $model = new MilkProduction();
        return $model->deleteProduction($id);
    }

    public function report()
    {
        return view('milk.report');
    }

    public function getWeeklyReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $model = new MilkProduction();
        return $model->getWeeklyReport($request);
    }
}

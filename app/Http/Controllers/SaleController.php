<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Cattle;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        // Obtener solo animales que NO estén vendidos (status_id != 4) y que NO estén muertos (status_id != 2)
        $cattles = Cattle::where('company_id', $activeCompanyId)
            ->whereNotIn('status_id', [2, 4]) // Excluir muertos y vendidos
            ->whereNotNull('code')
            ->orderBy('code')
            ->get(['id', 'code']);

        return view('sale.index', compact('cattles'));
    }

    public function getSales(Request $request)
    {
        $modelSale = new Sale();
        $data = $modelSale->getSales($request);
        return $data;
    }

    public function getAvailableCattles()
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        // Obtener solo animales que NO estén vendidos (status_id != 4) y que NO estén muertos (status_id != 2)
        $cattles = Cattle::where('company_id', $activeCompanyId)
            ->whereNotIn('status_id', [2, 4]) // Excluir muertos y vendidos
            ->whereNotNull('code')
            ->orderBy('code')
            ->get(['id', 'code']);

        return response()->json(['status' => true, 'cattles' => $cattles]);
    }

    public function createSale(Request $request)
    {
        $request->validate([
            'cattle_id' => 'required|exists:cattles,id',
            'sale_price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
        ]);

        $modelSale = new Sale();
        $response = $modelSale->createSale($request);
        return $response;
    }

    public function getSale($id)
    {
        $modelSale = new Sale();
        $data = $modelSale->getSale($id);
        return $data;
    }
}

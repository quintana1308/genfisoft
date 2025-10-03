<?php

namespace App\Http\Controllers;

use App\Models\Cattle;
use Illuminate\Http\Request;
use App\Models\Death;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Support\Facades\Auth;

class DeathController extends Controller
{
    public function index()
    {    
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;
        
        // Filtrar animales por empresa activa (solo animales vivos)
        $cattles = Cattle::where('company_id', $activeCompanyId)
            ->whereNotIn('status_id', [2, 3])
            ->orderBy('code')
            ->get(['id', 'code']);
            
        return view('death.index', compact('cattles'));
    }

    public function getDeaths(Request $request)
    {   
        $modelDeaths = new Death();
        $data = $modelDeaths->getDeaths($request);

        return $data;
    }

    public function createDeath(Request $request)
    {
        $modelDeath = new Death();
        $response = $modelDeath->createDeath($request);

        return $response;
    }

    public function deleteDeath($id)
    {   
  
        $modelDeath = new Death();
        $data = $modelDeath->deleteDeath($id);

        return $data;
    }
}

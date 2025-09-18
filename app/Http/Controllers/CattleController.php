<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cattle;
use PhpParser\Node\Stmt\Catch_;

class CattleController extends Controller
{
    public function index()
    {    
        return view('cattle.index');
    }

    public function create()
    {    
        $modelCattles = new Cattle();
        $data = $modelCattles->newCattles();

        return view('cattle.create', compact('data'));
    }

    public function edit()
    {    
        return view('cattle.edit');
    }

    public function getCattles(Request $request)
    {   
        $modelCattles = new Cattle();
        $data = $modelCattles->getCattles($request);

        return $data;
    }

    public function createCattle(Request $request)
    {   

        $modelCattle = new Cattle();
        $response = $modelCattle->createCattle($request);

        return $response;
    }

    public function getCattle($id)
    {   
        $modelCattle = new Cattle();
        $data = $modelCattle->getCattle($id);

        return $data;
    }

    public function getCattleView($id)
    {   
        $modelCattle = new Cattle();
        $data = $modelCattle->getCattleView($id);

        return $data;
    }

    public function updateCattle(Request $request)
    {
        $modelCattle = new Cattle();
        $response = $modelCattle->updateCattle($request);

        return $response;
    }

    public function servicesVeterinarian($id)
    {
        // Obtener la información del ganado (opcional si la quieres mostrar en la vista)
        $modelCattle = new Cattle();
        $data = $modelCattle->servicesVeterinarian($id);

        // Retornar vista con datos
        return view('cattle.medical', compact('data'));
    }

    public function getServicesVeterinarian(Request $request)
    {   
        $modelCattles = new Cattle();
        $data = $modelCattles->getServicesVeterinarian($request->cattle_id);

        return $data;
    }

    public function getCattleServicesView($id)
    {   
        $modelCattle = new Cattle();
        $data = $modelCattle->getCattleServicesView($id);

        return $data;
    }



}

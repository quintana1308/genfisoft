<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estate;
use PhpParser\Node\Stmt\Catch_;

class EstateController extends Controller
{
    public function index()
    {    
        return view('estate.index');
    }

    public function getEstates(Request $request)
    {   
        $modelEstates = new Estate();
        $data = $modelEstates->getEstates($request);

        return $data;
    }

    public function createEstate(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:100',
        ]);

        $modelEstate = new Estate();
        $response = $modelEstate->createEstate($request);

        return $response;
    }

    public function getEstate($id)
    {   
  
        $modelEstate = new Estate();
        $data = $modelEstate->getEstate($id);

        return $data;
    }

    public function updateEstate(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:100',
        ]);

        $modelEstate = new Estate();
        $response = $modelEstate->updateEstate($request);

        return $response;
    }

}

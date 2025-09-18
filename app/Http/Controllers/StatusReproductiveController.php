<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusReproductive;
use PhpParser\Node\Stmt\Catch_;

class StatusReproductiveController extends Controller
{
    public function index()
    {    
        return view('statusReproductive.index');
    }

    public function getStatusReproductives(Request $request)
    {   
        $modelStatusReproductives = new StatusReproductive();
        $data = $modelStatusReproductives->getStatusReproductives($request);

        return $data;
    }

    public function createStatusReproductive(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelStatusReproductive = new StatusReproductive();
        $response = $modelStatusReproductive->createStatusReproductive($request);

        return $response;
    }

    public function getStatusReproductive($id)
    {   
  
        $modelStatusReproductive = new StatusReproductive();
        $data = $modelStatusReproductive->getStatusReproductive($id);

        return $data;
    }

    public function updateStatusReproductive(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelStatusReproductive = new StatusReproductive();
        $response = $modelStatusReproductive->updateStatusReproductive($request);

        return $response;
    }

}

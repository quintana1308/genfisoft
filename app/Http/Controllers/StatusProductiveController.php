<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusProductive;
use PhpParser\Node\Stmt\Catch_;

class StatusProductiveController extends Controller
{
    public function index()
    {    
        return view('statusProductive.index');
    }

    public function getStatusProductives(Request $request)
    {   
        $modelStatusProductives = new StatusProductive();
        $data = $modelStatusProductives->getStatusProductives($request);

        return $data;
    }

    public function createStatusProductive(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelStatusProductive = new StatusProductive();
        $response = $modelStatusProductive->createStatusProductive($request);

        return $response;
    }

    public function getStatusProductive($id)
    {   
  
        $modelStatusProductive = new StatusProductive();
        $data = $modelStatusProductive->getStatusProductive($id);

        return $data;
    }

    public function updateStatusProductive(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelStatusProductive = new StatusProductive();
        $response = $modelStatusProductive->updateStatusProductive($request);

        return $response;
    }

}

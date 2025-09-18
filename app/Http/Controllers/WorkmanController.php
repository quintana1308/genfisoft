<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workman;
use PhpParser\Node\Stmt\Catch_;

class WorkmanController extends Controller
{
    public function index()
    {    
        return view('workman.index');
    }

    public function getWorkmans(Request $request)
    {   
        $modelWorkmans = new Workman();
        $data = $modelWorkmans->getWorkmans($request);

        return $data;
    }

    public function createWorkman(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:100',
        ]);

        $modelWorkman = new Workman();
        $response = $modelWorkman->createWorkman($request);

        return $response;
    }

    public function getWorkman($id)
    {   
  
        $modelWorkman = new Workman();
        $data = $modelWorkman->getWorkman($id);

        return $data;
    }

    public function updateWorkman(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:100',
        ]);

        $modelWorkman = new Workman();
        $response = $modelWorkman->updateWorkman($request);

        return $response;
    }

}

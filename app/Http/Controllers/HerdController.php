<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Herd;
use PhpParser\Node\Stmt\Catch_;

class HerdController extends Controller
{
    public function index()
    {    
        return view('herd.index');
    }

    public function getHerds(Request $request)
    {   
        $modelHerds = new Herd();
        $data = $modelHerds->getHerds($request);

        return $data;
    }

    public function createHerd(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:5|min:3',
            'name' => 'required|string|max:100'
        ]);

        $modelHerd = new Herd();
        $response = $modelHerd->createHerd($request);

        return $response;
    }

    public function getHerd($id)
    {   
  
        $modelHerd = new Herd();
        $data = $modelHerd->getHerd($id);

        return $data;
    }

    public function updateHerd(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:5|min:3',
            'name' => 'required|string|max:100',
        ]);

        $modelHerd = new Herd();
        $response = $modelHerd->updateHerd($request);

        return $response;
    }

}

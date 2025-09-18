<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use PhpParser\Node\Stmt\Catch_;

class ColorController extends Controller
{
    public function index()
    {    
        return view('color.index');
    }

    public function getColors(Request $request)
    {   
        $modelColors = new Color();
        $data = $modelColors->getColors($request);

        return $data;
    }

    public function createColor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelColor = new Color();
        $response = $modelColor->createColor($request);

        return $response;
    }

    public function getColor($id)
    {   
  
        $modelColor = new Color();
        $data = $modelColor->getColor($id);

        return $data;
    }

    public function updateColor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelColor = new Color();
        $response = $modelColor->updateColor($request);

        return $response;
    }

}

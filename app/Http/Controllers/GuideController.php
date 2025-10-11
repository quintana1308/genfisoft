<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guide;

class GuideController extends Controller
{
    public function index()
    {    
        return view('guide.index');
    }

    public function getGuides(Request $request)
    {   
        $modelGuides = new Guide();
        $data = $modelGuides->getGuides($request);

        return $data;
    }

    public function createGuide(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelGuide = new Guide();
        $response = $modelGuide->createGuide($request);

        return $response;
    }

    public function getGuide($id)
    {   
  
        $modelGuide = new Guide();
        $data = $modelGuide->getGuide($id);

        return $data;
    }

    public function updateGuide(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelGuide = new Guide();
        $response = $modelGuide->updateGuide($request);

        return $response;
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classification;
use PhpParser\Node\Stmt\Catch_;

class ClassificationController extends Controller
{
    public function index()
    {    
        return view('classification.index');
    }

    public function getClassifications(Request $request)
    {   
        $modelClassifications = new Classification();
        $data = $modelClassifications->getClassifications($request);

        return $data;
    }

    public function createClassification(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelClassification = new Classification();
        $response = $modelClassification->createClassification($request);

        return $response;
    }

    public function getClassification($id)
    {   
  
        $modelClassification = new Classification();
        $data = $modelClassification->getClassification($id);

        return $data;
    }

    public function updateClassification(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelClassification = new Classification();
        $response = $modelClassification->updateClassification($request);

        return $response;
    }

}

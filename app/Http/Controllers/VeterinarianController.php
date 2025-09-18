<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Veterinarian;
use PhpParser\Node\Stmt\Catch_;

class VeterinarianController extends Controller
{
    public function index()
    {    
        return view('veterinarian.index');
    }

    public function create()
    {    
        $modelVeterinarians = new Veterinarian();
        $data = $modelVeterinarians->newVeterinarians();

        return view('veterinarian.create', compact('data'));
    }

    public function edit()
    {    
        return view('veterinarian.edit');
    }

    public function getVeterinarians(Request $request)
    {   
        $modelVeterinarians = new Veterinarian();
        $data = $modelVeterinarians->getVeterinarians($request);

        return $data;
    }

    public function createVeterinarian(Request $request)
    {   

        $modelVeterinarian = new Veterinarian();
        $response = $modelVeterinarian->createVeterinarian($request);

        return $response;
    }

    public function getVeterinarian($id)
    {   
        $modelVeterinarian = new Veterinarian();
        $data = $modelVeterinarian->getVeterinarian($id);

        return $data;
    }

    public function getVeterinarianView($id)
    {   
        $modelVeterinarian = new Veterinarian();
        $data = $modelVeterinarian->getVeterinarianView($id);

        return $data;
    }

    public function updateVeterinarian(Request $request)
    {
        $modelVeterinarian = new Veterinarian();
        $response = $modelVeterinarian->updateVeterinarian($request);

        return $response;
    }

}

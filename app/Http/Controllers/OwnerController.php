<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;
use PhpParser\Node\Stmt\Catch_;

class OwnerController extends Controller
{
    public function index()
    {    
        return view('owner.index');
    }

    public function getOwners(Request $request)
    {   
        $modelOwners = new Owner();
        $data = $modelOwners->getOwners($request);

        return $data;
    }

    public function createOwner(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelOwner = new Owner();
        $response = $modelOwner->createOwner($request);

        return $response;
    }

    public function getOwner($id)
    {   
  
        $modelOwner = new Owner();
        $data = $modelOwner->getOwner($id);

        return $data;
    }

    public function updateOwner(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelOwner = new Owner();
        $response = $modelOwner->updateOwner($request);

        return $response;
    }

}

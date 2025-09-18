<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Input;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Support\Facades\Auth;
use App\Models\Owner;

class InputController extends Controller
{
    public function index()
    {    
        $userId = Auth::id();
        $owners = Owner::where('user_id', $userId)->whereNotIn('status_id', [2, 3])->orderBy('name')->get(['id', 'name']);
        return view('input.index', compact('owners'));
    }

    public function getInputs(Request $request)
    {   
        $modelInputs = new Input();
        $data = $modelInputs->getInputs($request);

        return $data;
    }

    public function createInput(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:100',
        ]);

        $modelInput = new Input();
        $response = $modelInput->createInput($request);

        return $response;
    }

    public function getInput($id)
    {   
  
        $modelInput = new Input();
        $data = $modelInput->getInput($id);

        return $data;
    }

    public function updateInput(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:100',
        ]);

        $modelInput = new Input();
        $response = $modelInput->updateInput($request);

        return $response;
    }

}

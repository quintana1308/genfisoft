<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CauseEntry;
use PhpParser\Node\Stmt\Catch_;

class CauseEntryController extends Controller
{
    public function index()
    {    
        return view('causeEntry.index');
    }

    public function getCauseEntrys(Request $request)
    {   
        $modelCauseEntrys = new CauseEntry();
        $data = $modelCauseEntrys->getCauseEntrys($request);

        return $data;
    }

    public function createCauseEntry(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelCauseEntry = new CauseEntry();
        $response = $modelCauseEntry->createCauseEntry($request);

        return $response;
    }

    public function getCauseEntry($id)
    {   
  
        $modelCauseEntry = new CauseEntry();
        $data = $modelCauseEntry->getCauseEntry($id);

        return $data;
    }

    public function updateCauseEntry(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelCauseEntry = new CauseEntry();
        $response = $modelCauseEntry->updateCauseEntry($request);

        return $response;
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use PhpParser\Node\Stmt\Catch_;

class CategoryController extends Controller
{
    public function index()
    {    
        return view('category.index');
    }

    public function getCategorys(Request $request)
    {   
        $modelCategorys = new Category();
        $data = $modelCategorys->getCategorys($request);

        return $data;
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelCategory = new Category();
        $response = $modelCategory->createCategory($request);

        return $response;
    }

    public function getCategory($id)
    {   
  
        $modelCategory = new Category();
        $data = $modelCategory->getCategory($id);

        return $data;
    }

    public function updateCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelCategory = new Category();
        $response = $modelCategory->updateCategory($request);

        return $response;
    }

}

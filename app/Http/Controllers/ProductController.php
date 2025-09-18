<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use PhpParser\Node\Stmt\Catch_;

class ProductController extends Controller
{
    public function index()
    {    
        return view('product.index');
    }

    public function getProducts(Request $request)
    {   
        $modelProducts = new Product();
        $data = $modelProducts->getProducts($request);

        return $data;
    }

    public function createProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelProduct = new Product();
        $response = $modelProduct->createProduct($request);

        return $response;
    }

    public function getProduct($id)
    {   
  
        $modelProduct = new Product();
        $data = $modelProduct->getProduct($id);

        return $data;
    }

    public function updateProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $modelProduct = new Product();
        $response = $modelProduct->updateProduct($request);

        return $response;
    }

}

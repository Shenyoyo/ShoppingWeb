<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        
        $products = Product::productDisplay()->get();
        return view('shop.index', ['products' => $products]);
    }

    public function show($id)
    {
        $product = Product::productDisplay()->where('id', $id)->firstOrFail();
        $interested = Product::productDisplay()->where('id', '!=', $id)->get()->random(4);
        return view('shop.product', ['product' => $product, 'interested' => $interested]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::productDisplay()->where('name', 'LIKE', '%'.$query.'%')->get();
        return view('shop.index', ['products' => $products]);
    }
}

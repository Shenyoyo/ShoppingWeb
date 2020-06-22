<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('shop.index', ['products' => $products]);
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->firstOrFail();
        $interested = Product::where('id', '!=', $id)->get()->random(4);
        return view('shop.product', ['product' => $product, 'interested' => $interested]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $id='';
        $categories = Category::CategoryDisplay()->get(); 
        $products = Product::productDisplay()->get();
        return view('shop.index', ['products' => $products,'categories' => $categories,'id' =>$id]);
    }

    public function show($id)
    {
        $product = Product::productDisplay()->where('id', $id)->firstOrFail();
        $interested = Product::productDisplay()->where('id', '!=', $id)->get()->random(4);
        return view('shop.product', ['product' => $product, 'interested' => $interested]);
    }

    public function search(Request $request)
    {
        $id='';
        $query = $request->input('query');
        $products = Product::productDisplay()->where('name', 'LIKE', '%'.$query.'%')->get();
        $categories = Category::CategoryDisplay()->get(); 
        return view('shop.index', ['products' => $products,'categories' => $categories,'id' =>$id]);
    }
    public function orderbyPorduct($sort){
        $id='';
        $categories = Category::CategoryDisplay()->get(); 
        $products = Product::productDisplay()->orderBy('price', $sort)->get();
        return view('shop.index', ['products' => $products,'categories' => $categories,'id' =>$id]);
    }
    public function categoryProduct($id){
        $products = Category::find($id)->product;
        $categories = Category::CategoryDisplay()->get(); 
        return view('shop.index', ['products' => $products,'categories' => $categories,'id' =>$id]);
       
      
    }
}

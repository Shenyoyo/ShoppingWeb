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
        $products = Product::productDisplay()->paginate(8);
        return view('shop.index', ['products' => $products,'categories' => $categories,'id' =>$id]);
    }
   
    public function show($id)
    {
        $products = Product::productDisplay()->get();
        $product = Product::productDisplay()->where('id', $id)->firstOrFail();
        $productQuantity = (count($products) < 5 ) ? count($products)-1 : 4 ;
        $interested = Product::productDisplay()->where('id', '!=', $id)->get()->random($productQuantity);
        return view('shop.product', ['product' => $product, 'interested' => $interested]);
    }

    public function search(Request $request)
    {
        $id='';
        $query = $request->input('query');
        $products = Product::productDisplay()->where('name', 'LIKE', '%'.$query.'%')->paginate(8);
        $categories = Category::CategoryDisplay()->get(); 
        return view('shop.index', ['products' => $products,'categories' => $categories,'id' =>$id]);
    }
    public function orderbyPorduct($sort){
        $id='';
        $categories = Category::CategoryDisplay()->get(); 
        $products = Product::productDisplay()->orderBy('price', $sort)->paginate(8);
        return view('shop.index', ['products' => $products,'categories' => $categories,'id' =>$id]);
    }
    public function categoryProduct($id,$orderby){
        $products = Category::find($id)->product()->orderBy('price',$orderby)->paginate(8);
        $categories = Category::CategoryDisplay()->get(); 
        return view('shop.index', ['products' => $products,'categories' => $categories,'id' =>$id]);
    }
}

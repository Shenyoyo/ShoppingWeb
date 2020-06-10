<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Storage;
use File;

class ProductController extends Controller
{
    public function getIndex()
    {
        $products = Product::all();
        return view('admin.products', ['products' => $products]);
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('admin.products');
    }
    public function newProduct()
    {
        return view('admin.new');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view('admin.edit')->with('product', $product);
        ;
    }

    public function update(Request $request)
    {
        $product = Product::find($request->input('id'));
        $product->name =$request->input('name');
        $product->description =$request->input('description');
        $product->price =$request->input('price');
        $product->image =$request->input('image');

        $product->save();

        return redirect()->route('admin.products');
    }

    public function add(Request $request)
    {
        $file =  $request->file('file');
        $extension = $file->getClientOriginalExtension(); //取得副檔名
        Storage::disk('local')->put($file->getFilename().'.'.$extension, File::get($file));

        $entry = new \App\File();
        $entry->mime = $file->getClientMimeType();
        $entry->original_filename = $file->getClientOriginalName();
        $entry->filename = $file->getFilename().'.'.$extension;

        $entry->save();

        $product = new Product();
        $product->file_id = $entry->id;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->image = $request->input('image');

        $product->save();

        return redirect()->route('admin.products');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'LIKE', '%'.$query.'%')->get();

        return view('admin.products')->with('products', $products);
    }
}

<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Storage;
use File;

class ProductController extends Controller
{
    public function getIndex()
    {
        $products = Product::where('enable', '!=','0')->get();
        return view('admin.products', ['products' => $products]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->enable = '0';
        $product->save();
        return redirect()->route('admin.products');
    }
    public function newProduct()
    {
        $categories = Category::all();
        return view('admin.new', ['categories' => $categories]);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('admin.edit',['product' => $product ,'categories' => $categories]);
    }

    public function update(Request $request)
    {
        // $file =  $request->file('file');
        // $extension = $file->getClientOriginalExtension(); //取得副檔名
        // Storage::disk('local')->put($file->getFilename().'.'.$extension, File::get($file));

        // $entry = new \App\File();
        // $entry->mime = $file->getClientMimeType();
        // $entry->original_filename = $file->getClientOriginalName();
        // $entry->filename = $file->getFilename().'.'.$extension;

        // $entry->save();

        $product = Product::find($request->input('id'));
        $product->name =$request->input('name');
        $product->description =$request->input('description');
        $product->price =$request->input('price');
        $product->imageurl =$request->input('imageurl');
        $product->amount = $request->input('amount');
        if (!empty($request->input('display_yn'))) {
            $product->display_yn =$request->input('display_yn');
        } else { 
            $product->display_yn = "N";
        }
        if (!empty($request->input('buy_yn'))) {
            $product->buy_yn = $request->input('buy_yn');
        } else {
            $product->buy_yn = "N";
        }
        // $product->file_id = $entry->id;

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
        $product->amount = $request->input('amount');
        $product->imageurl = $request->input('imageurl');
        if (!empty($request->input('buy_yn'))) {
            $product->buy_yn = $request->input('buy_yn');
        } else {
            $product->buy_yn = 'N';
        }
        if (!empty($request->input('display_yn'))) {
            $product->display_yn = $request->input('display_yn');
        } else {
            $product->display_yn = 'N';
        }
        $product->category_id = $request->input('category_id');
        $product->enable = '1'; //紀錄商品狀態 不在使用:0 正在使用:1

        $product->save();

        return redirect()->route('admin.products');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'LIKE', '%'.$query.'%')->get();

        return view('admin.products',['products' => $products]);
    }
}

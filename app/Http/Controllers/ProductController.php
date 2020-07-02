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
        $products = Product::productEnable()->paginate(10);
        return view('admin/stock.products', ['products' => $products]);
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
        return view('admin/stock.new', ['categories' => $categories]);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if (count($product->category) != 0) {
            foreach ($product->category as $categorys) {
                $category_id[] = $categorys->id;
            }
        } else {
            $category_id[] ='0';
        }
        
        
        $categories = Category::all();
        return view('admin/stock.edit', ['product' => $product ,'categories' => $categories,'category_id'=> $category_id]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'file'  => 'mimes:jpeg,jpg,png',
            'price' => 'required|integer',

        ], [
            'file.mimes' => '上傳檔案格式必須是.jpg .png .jpeg',
            'price.integer' => '價格只能輸入數字',
        ]);
        if(!empty ($request->file('file'))){
            $file =  $request->file('file');
            $extension = $file->getClientOriginalExtension(); //取得副檔名
            Storage::disk('public')->put($file->getFilename().'.'.$extension, File::get($file));
            $entry = new \App\File();
            $entry->mime = $file->getClientMimeType();
            $entry->original_filename = $file->getClientOriginalName();
            $entry->filename = $file->getFilename().'.'.$extension;
            $entry->save();
        }
       

        $product = Product::find($request->input('id'));
        $product->name =$request->input('name');
        $product->description =$request->input('description');
        $product->price =$request->input('price');
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

        if(!empty ($request->file('file'))){
           $product->file_id = $entry->id;
        }
        

        $product->save();

        $categories = Category::all();
        $product->category()->detach();//清除相關後在新增
        foreach ($categories as $category) {
            $product->category()->attach($request->input($category->name));
        }

        return redirect()->route('admin.products');
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'file'  => 'required|mimes:jpeg,jpg,png',
            'price' => 'required|integer',
        ], [
            'file.required' => '請上傳圖片',
            'file.mimes' => '上傳檔案格式必須是.jpg .png .jpeg',
            'price.integer' => '價格只能輸入數字'
        ]);
        $file =  $request->file('file');
        $extension = $file->getClientOriginalExtension(); //取得副檔名
        Storage::disk('public')->put($file->getFilename().'.'.$extension, File::get($file));

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
        $product->enable = '1'; //紀錄商品狀態 不在使用:0 正在使用:1
        $product->save();
        $categories = Category::all();
        foreach ($categories as $category) {
            $product->category()->attach($request->input($category->name));
        }
        return redirect()->route('admin.products');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'LIKE', '%'.$query.'%')->paginate(10);

        return view('admin/stock.products', ['products' => $products]);
    }
}

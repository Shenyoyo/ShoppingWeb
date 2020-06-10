<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function getIndex()
    {
        $categories = Category::all();
        return view('admin/category.index', ['categories' => $categories]);
    }

    public function newCategory()
    {
        return view('admin/category.new');
    }

    public function editCategory($id)
    {
        $category = Category::find($id);
        return view('admin/category.edit', ['category' => $category]);
    }

    public function add(Request $request)
    {
        $category = new Category();
        $category->name = $request->input('name');
        if (!empty($request->input('display_yn'))) {
            $category->display_yn = $request->input('display_yn');
        } else {
            $category->display_yn = 'N';
        }
        $category->save();

        return redirect()->route('category.index');
    }

    public function update(Request $request)
    {
        $category = Category::find($request->input('id'));
        $category->name = $request->input('name');
        if (!empty($request->input('display_yn'))) {
            $category->display_yn = $request->input('display_yn');
        } else {
            $category->display_yn = 'N';
        }
        $category->save();

        return redirect()->route('category.index');
    }
    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('category.index');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        $categories = Category::where('name', 'LIKE', '%'.$query.'%')->get();

        return view('admin/category.index',['categories' => $categories]);
    }
}

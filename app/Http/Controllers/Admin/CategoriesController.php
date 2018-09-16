<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\Image;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    public function index()
    {
    	$categories = Category::all();

    	return view('admin.categories.index', ['categories'	=>	$categories]);
    }

    public function create()
    {
    	return view('admin.categories.create');
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name'	=>	'required' //обязательно
    	]);

    	Category::create($request->all());
    	return redirect()->route('admin.categories');
    }

    public function edit($id)
    {
    	$category = Category::find($id);
    	return view('admin.categories.edit', ['category'=>$category]);
    }

    public function update(Request $request, $id)
    {
    	$this->validate($request, [
    		'name'	=>	'required' //обязательно
    	]);

    	$category = Category::find($id);
        
        
    	$category->update(['name' => $request->name]);

    	return redirect()->route('admin.categories');
    }

    public function destroy($id)
    {
        Category::deleteCategory($id);
       
    	return redirect()->route('admin.categories');
    }
}

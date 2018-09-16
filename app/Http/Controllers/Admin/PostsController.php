<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Image;
use App\Category;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;


class PostsController extends Controller
{
    private $imageClass;
 
    public function __construct(Image $imageClass) { 
        $this->imageClass = $imageClass; 
    }
    
    public function index()
    {  
        $posts = Image::with("categories")->get();
        return view('admin.posts.index', ['posts'=>$posts]);
    }

    public function create()
    {
        $category = Category::all();
        return view('admin.posts.create', [
            'category' => $category,
        ]);
    }
 
    public function store(Request $request)
    {
       $rules = [
           'description' => 'min:4',
           'image' => 'required|image|mimes:jpg,jpeg,png',
           'choose-category' => 'array|required'
           ];
    
        $messages = [
            'description.min' => 'Название должно содержать минимум :min символа.',
            'image.required' => 'Изображение загружать обязательно.',
            'image.image' => 'Вы загрузили не изображение.',
            'image.mimes' => 'Допустимые форматы: jpg, jpeg, png.',
            'choose-category.required' => 'Выберите категорию'
         ];
    
        Validator::make(
            $request->all(), 
            $rules ,
            $messages
              )->validate(); 
     
        $image = $request->file('image');
      
        $description = $request->input('description');
      
        $this->imageClass->add($image, $description);
        
        $this->imageClass->save();
      
        $idNewImage = $this->imageClass->id;
        $categories = $request->input('choose-category');
      
        $this->imageClass->addRelation($categories, $idNewImage);

        return redirect()->route('admin.posts');
    }
   
    public function edit($id)
    {
        $post = Image::find($id);
        $category = Category::all();
      
        return view('admin.posts.edit', compact(
            'category',       
            'post'
        ));
    }

    public function update(Request $request, $id)
    {  
        $rules = [
           'description' => 'min:4',
           ];
    
        $messages = [
            'description.min' => 'Название должно содержать минимум :min символа.',
            'image.required' => 'Изображение загружать обязательно.',
            'choose-category.required' => 'Выберите категорию'
         ];
    
        Validator::make(
            $request->all(), 
            $rules ,
            $messages
              )->validate(); 
        
         $imgOld = $this->imageClass::find($id);
         $imgOld->updateImage($request->image, $imgOld);
         $imgOld->description = $request->description;
         $imgOld->save();
         
         DB::table('category_image')->where('image_id', $id)->delete();

         $categories = $request->input('choose-category');
      
        $this->imageClass->addRelation($categories, $id);
         
        return redirect()->route('admin.posts');
    }

    public function destroy($id)
    {
        $image = Image::find($id);
        (new Image())->deleteImage($image);
        return redirect()->action('Admin\PostsController@index');
    }
}

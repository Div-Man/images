<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

use App\Services\Image;
use App\Category;
use App\User;

use Illuminate\Support\Facades\Auth;

class ImagesController extends Controller 
{
    private $imageClass;
    private $role;
    
    public function __construct(Image $imageClass, User $role) { 
        $this->imageClass = $imageClass;
        $this->role = $role;
    }
    
    public function index()      
    {
        $userRole = $this->role->isRole();
        
        $allCategory = Category::all();
         
       return view('welcome', [
           'imagesInView' =>  $this->imageClass::paginate(2),
           'allCategory' => $allCategory,
           'userRole' => $userRole
               ]);
    }
    
    public function categoryShow($id)
    {
        $userRole = $this->role->isRole();
        $allCategory = Category::all();
        $targetCateory = Category::find($id)->article()->paginate(2);
        
       
       return view('welcome', [
           'imagesInView' =>  $targetCateory,
           'allCategory' => $allCategory,
           'userRole' => $userRole
               ]);
    }
    
    public function create()
    { 
        $userRole = $this->role->isRole();
        $category = Category::all();
       
        return view('create', [
            'category' => $category,
            'userRole' => $userRole
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
        
      return redirect('/');
    }
    
    public function show($id)
    {
         $userRole = $this->role->isRole();
        $myImage = $this->imageClass::find($id);
        return view('show', [
            'imageInView' => $myImage,
             'userRole' => $userRole
                ]);
    }
    
    public function edit($id)
    {
        $userRole = $this->role->isRole();
        $myImage = $this->imageClass::find($id);
         return view('edit', [
             'imageInView' => $myImage,
             'userRole' => $userRole
                 ]);
    }
    
    public function update(Request $request, $id)
    { 
        $imgOld = $this->imageClass::find($id);
        
        //Назвать метод update нелья, так как будет конфликт с ларавеловскими готовыми методами. 
        
        $imgOld->updateImage($request->image, $imgOld);
        $imgOld->description = $request->description;
        $imgOld->save();
        
         return redirect('/');
    }
    
     public function delete($id) {
       
      $currentImage = $this->imageClass::find($id);
      $this->imageClass->deleteImage($currentImage);
    
     return redirect('/');
    }
}


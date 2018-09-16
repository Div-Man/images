<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{   
     protected $fillable = ['name'];
     public $timestamps = false;
     
     
     public function article()
    {
        return $this->belongsToMany('App\Services\Image');
    }
    
    public static function deletePivot($categoryId, $imageId)
    {
         DB::table('category_image')->where([
            ['category_id', '=', $categoryId],
            ['image_id', '=', $imageId],
            ])->delete();
    }
     
    public static function deleteCategory($id)
    {
         $posts = DB::table('category_image')->select('image_id')->
                where('category_id', $id)->get();
        
        

        $posts->each(function ($item, $key) use (&$id) {
            
            //потом надо посчитать, сколько таких одинаковых статей
            
            $countPosts = DB::table('category_image')->where('image_id', $item->image_id)->count();        
            
            //если есть ещё эта статья в другой категории
            //то удалить только дубликаты
            
             if($countPosts != 1) {    
                self::deletePivot($id, $item->image_id);
                if(Category::find($id)) {
                     Category::find($id)->delete(); 
                }  
            }  
           else { 
                self::deletePivot($id, $item->image_id);
                Storage::delete(Image::find($item->image_id)->image);               
                Image::destroy($item->image_id);
                
                if(Category::find($id)) {
                     Category::find($id)->delete(); 
                } 
            } 
          
        });
        
	if(Category::find($id)) {
           Category::find($id)->delete(); 
        }; 
    }
     
}

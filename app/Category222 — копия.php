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
     
    public static function deleteCategory($id)
    {
         $posts = DB::table('category_image')->select('image_id')->
                where('category_id', $id)->get();
        
        //потом надо посчитать, сколько таких одинаковых статей
       
        $several = [];
        
        $posts->each(function ($item, $key) use (&$several) {
            array_push( $several, $item->image_id);
          
        });
        
        foreach($several as $post){     
        
            $countPosts = DB::table('category_image')->where('image_id', $post)->count();
            
            //если есть ещё эта статья в другой категории
            //то удалить только дубликаты
            
             if($countPosts != 1) {
                  DB::table('category_image')->where([
                        ['category_id', '=', $id],
                        ['image_id', '=', $post],
                        ])->delete();
                
                if(Category::find($id)) {
                     Category::find($id)->delete(); 
                }  
            }  
           else { 
                DB::table('category_image')->where([
                        ['category_id', '=', $id],
                        ['image_id', '=', $post],
                        ])->delete();
                Storage::delete(Image::find($post)->image);
                Image::destroy($post);
                
                if(Category::find($id)) {
                     Category::find($id)->delete(); 
                } 
            } 
        }   
        
	if(Category::find($id)) {
           Category::find($id)->delete(); 
        }; 
    }
     
}

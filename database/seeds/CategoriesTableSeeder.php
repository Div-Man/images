<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
         Category::insert([
            ['name' => 'лыжи'],
            ['name' => 'php'],
            ['name' => 'природа'],
            ['name' => 'футбол'],
            ['name' => 'музыка'],
            ['name' => 'город'],
         ] 
       );
        
    }
}

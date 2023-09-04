<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['categoryName'=>'AngularJs']);
        Category::create(['categoryName'=>'ReactJs']);
        Category::create(['categoryName'=>'VueJs']);

    }
}

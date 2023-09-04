<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create(['tagName'=>'Css']);
        Tag::create(['tagName'=>'Html']);
        Tag::create(['tagName'=>'Bootstrap']);
        Tag::create(['tagName'=>'JavaScript']);
    }
}

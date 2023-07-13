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
        Tag::create(['tagName'=>'Clothes']);
        Tag::create(['tagName'=>'Shoes']);
        Tag::create(['tagName'=>'Watches']);
        Tag::create(['tagName'=>'Electronics']);
        Tag::create(['tagName'=>'Men']);
        Tag::create(['tagName'=>'Women']);
        Tag::create(['tagName'=>'Boys']);
        Tag::create(['tagName'=>'Girls']);

    }
}

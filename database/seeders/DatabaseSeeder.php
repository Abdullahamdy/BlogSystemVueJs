<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TagSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(UserAdminSeeder::class);
        $this->call(RoleSeeder::class);
    }
}

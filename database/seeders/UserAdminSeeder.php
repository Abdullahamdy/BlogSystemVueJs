<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'fullName'=>'AbdullahHamdy',
            'email'=>'abdo@gmail.com',
            'password'=>bcrypt(11111111),
            'userType'=>'Admin',
        ]);
        User::create([
            'fullName'=>'User',
            'email'=>'user@gmail.com',
            'password'=>bcrypt(11111111),
            'userType'=>'User',
        ]);
    }
}

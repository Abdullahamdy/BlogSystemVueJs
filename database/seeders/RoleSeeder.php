<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'roleName' => 'Admin',
            'permission' =>
            "[{ resourceName: 'Home', read: true, write: true, update: true, delete: true, name: '/' },
        { resourceName: 'Tags', read: true, write: true, update: true, delete: true, name: 'tags' },
        { resourceName: 'Role', read: true, write: true, update: true, delete: true, name: 'role' },
        { resourceName: 'Create Blog', read: true, write: true, update: true, delete: true, name: 'createblogs' },
        { resourceName: 'Assign Role', read: true, write: true, update: true, delete: true, name: 'assignRole' },
        { resourceName: 'Adminusers', read: true, write: true, update: true, delete: true, name: 'adminusers' },
        { resourceName: 'Category', read: true, write: true, update: true, delete: true, name: 'category' },
        { resourceName: 'Blogs', read: false, write: false, update: false, delete: false, name: 'blogs' }]",
        'isAdmin' => 1,

        ]);
        Role::create(['roleName' => 'Editor', 'permission' => null]);
    }
}

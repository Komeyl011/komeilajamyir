<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\PermissionFactory;
use Database\Factories\RoleFactory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//         \App\Models\User::factory(10)->create();

        $role_admin = Role::create([
            'name' => 'admin',
        ]);
        $role_user = Role::create([
            'name' => 'user',
        ]);
        $role_content = Role::create([
            'name' => 'content_admin',
        ]);

        $perm_admin_access = Permission::create([
            'name' => 'admin.access',
        ]);
        $perm_admin_index = Permission::create([
            'name' => 'admin.index',
        ]);

        $role_admin->givePermissionTo($perm_admin_index);

        $role_content->givePermissionTo($perm_admin_access);

         $admin = \App\Models\User::factory()->create([
             'name' => 'Timmy',
             'email' => 'komeil0205@protonmail.com',
             'password' => 'password',
         ]);
         $admin->assignRole($role_admin);
    }
}

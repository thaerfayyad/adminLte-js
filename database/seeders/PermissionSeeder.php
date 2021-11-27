<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //***************************Admin ****************************/
        Permission::create(['name' => 'create-permission', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'read-permissions', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'update-permission', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'delete-permission', 'guard_name'=> 'admin']);

        Permission::create(['name' => 'create-city', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'read-cities', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'update-city', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'delete-city', 'guard_name'=> 'admin']);

        Permission::create(['name' => 'create-role', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'read-roles', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'update-role', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'delete-role', 'guard_name'=> 'admin']);

        Permission::create(['name' => 'create-category', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'read-categories', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'update-category', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'delete-category', 'guard_name'=> 'admadminsin']);

        Permission::create(['name' => 'create-admin', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'read-admins', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'update-admin', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'delete-admin', 'guard_name'=> 'admin']);

        Permission::create(['name' => 'create-broker', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'read-brokers', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'update-broker', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'delete-broker', 'guard_name'=> 'admin']);

        Permission::create(['name' => 'create-user', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'read-users', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'update-user', 'guard_name'=> 'admin']);
        Permission::create(['name' => 'delete-user', 'guard_name'=> 'admin']);
        //******************************Broker **********************/
        Permission::create(['name' => 'read-categories', 'guard_name'=> 'broker']);
        Permission::create(['name' => 'read-cities', 'guard_name'=> 'broker']);
        // Permission::create(['name' => 'read-', 'guard_name'=> 'broker']);
        // Permission::create(['name' => 'read-', 'guard_name'=> 'broker']);
        //******************************User **********************/
        Permission::create(['name' => 'read-categories', 'guard_name'=> 'user-api']);
        Permission::create(['name' => 'read-cities', 'guard_name'=> 'user-api']);


    }
}

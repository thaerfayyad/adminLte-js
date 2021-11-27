<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //************************Admin ***********************/
        Role::create(['name' => 'super_admin' , 'guard_name'=>'admin']);
        // Role::create(['name' => 'Content-Manger' , 'guard_name'=>'admin']);
        // Role::create(['name' => 'Human-Resources' , 'guard_name'=>'admin']);

        //************************Admin ***********************/

        // Role::create(['name' => 'Broker' , 'guard_name'=>'broker']);


    }
}

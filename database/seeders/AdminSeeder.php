<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       $user = Admin::create([
            'name' => 'super_admin',
            'email'=> 'admin@app.com',
            'password' => Hash::make(10201020),

        ]);
        $user ->assignRole('super_admin');
    }
}

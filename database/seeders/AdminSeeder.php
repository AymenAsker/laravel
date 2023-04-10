<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Admin::create([
            'name' =>  'admin',
            'email' => 'nu@gmail.com',
            'username' => 'a_admin',
            'super_admin' => 0,
            'password' => Hash::make('a_nalut1234560'),
        ]);

        Admin::create([
            'name' =>  'admin',
            'email' => 'na@gmail.com',
            'username' => 'na_admin',
            'super_admin' => 0,
            'password' => Hash::make('na_adminNalut'),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
         'name' => 'Abdul Waheed',
         'email' => 'waheedbajeed@gmail.com',
         'role' => 'admin',
         'email_verified_at' => date('Y-m-d'),
         'status' => 1,
         'password' => Hash::make('waheed@786')
        ]);
    }
}

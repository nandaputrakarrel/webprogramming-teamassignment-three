<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'name' => 'testing',
            'email' => 'testing@gmail.com',
            'gender' => 'male',
            'birthdate' => '2000-01-01',
            'password' => '$2y$10$Cp67YzXZti91I29gzEGYXuIYPIUDnfjIQ3c8liSKAbznrXNiLveNS', // password
            'roleId' => 1
        ]);
    }
}

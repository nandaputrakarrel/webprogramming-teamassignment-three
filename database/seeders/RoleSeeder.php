<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Roles::truncate();
        
        Roles::create([
            'id' => 1,
            'name' => 'Admin'
        ]);

        Roles::create([
            'id' => 2,
            'name' => 'User'
        ]);
    }
}

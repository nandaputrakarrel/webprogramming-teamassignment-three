<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Products::truncate();

        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 1; $i <= 10; $i++) {
            Products::create([
                'name' => "Product number {$i}",
                'description' => "Description for Product {$i}",
                'buyPrice' => mt_rand(1000000, 100000000),
                'sellPrice' => mt_rand(15000000, 20000000),
            ]);
        }
    }
}

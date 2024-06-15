<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create(['code' => 'FR1', 'name' => 'Fruit tea', 'price' => 3.11]);
        Product::create(['code' => 'SR1', 'name' => 'Strawberries', 'price' => 5.00]);
        Product::create(['code' => 'CF1', 'name' => 'Coffee', 'price' => 11.23]);
    }
}

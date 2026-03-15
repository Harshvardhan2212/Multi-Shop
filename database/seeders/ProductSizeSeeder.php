<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSizeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_sizes')->insert([
            [
                'size' => 'S',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'size' => 'M',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'size' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'size' => 'XL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'size' => 'XXL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

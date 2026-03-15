<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductColorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_colors')->insert([
            [
                'color' => 'Red',
                'hex_code' => '#FF0000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'color' => 'Blue',
                'hex_code' => '#0000FF',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'color' => 'Green',
                'hex_code' => '#008000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'color' => 'Black',
                'hex_code' => '#000000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'color' => 'White',
                'hex_code' => '#FFFFFF',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

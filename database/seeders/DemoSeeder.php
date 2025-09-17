<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // admin user
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $faker = Faker::create();
        for ($i = 1; $i <= 20; $i++) {
            $name = ucfirst($faker->words(3, true));
            $id = DB::table('products')->insertGetId([
                'name' => $name,
                'slug' => Str::slug($name) . "-$i",
                'sku'  => 'SKU' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'price'=> $faker->randomFloat(2, 100, 3000),
                'stock'=> $faker->numberBetween(5, 100),
                'description' => $faker->sentence(12),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('product_images')->insert([
                'product_id' => $id,
                'path' => "products/{$id}.jpg",
                'sort_order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

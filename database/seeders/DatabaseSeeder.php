<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@gmail.com',
        ]);
        $categories = [
            'Fashion',
            'Electronics',
            'Beauty',
            'Sports'
        ];
        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }

        Product::factory(50)->create();

        ProductImage::factory(500)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiction', 'description' => 'Novel dan cerita fiksi'],
            ['name' => 'Romance', 'description' => 'Buku bertema percintaan'],
            ['name' => 'Technology', 'description' => 'Buku teknologi dan pemrograman'],
            ['name' => 'Education', 'description' => 'Buku pembelajaran dan referensi'],
            ['name' => 'Science', 'description' => 'Buku sains dan pengetahuan umum'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Teknologi',     'slug' => 'teknologi'],
            ['name' => 'Bisnis',        'slug' => 'bisnis'],
            ['name' => 'Desain',        'slug' => 'desain'],
            ['name' => 'Produktivitas', 'slug' => 'produktivitas'],
            ['name' => 'Pendidikan',    'slug' => 'pendidikan'],
            ['name' => 'Pemrograman',   'slug' => 'pemrograman'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
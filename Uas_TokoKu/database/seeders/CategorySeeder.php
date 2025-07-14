<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Gadget',
                'slug' => 'gadget',
                'description' => 'Berbagai macam gadget terbaru dan berkualitas',
                'image' => null
            ],
            [
                'name' => 'Gaming',
                'slug' => 'gaming',
                'description' => 'Peralatan gaming untuk para gamer profesional',
                'image' => null
            ],
            [
                'name' => 'Elektronik',
                'slug' => 'elektronik',
                'description' => 'Elektronik rumah tangga dan peralatan elektronik',
                'image' => null
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

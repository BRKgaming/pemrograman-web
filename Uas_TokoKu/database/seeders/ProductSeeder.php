<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gadgetCategory = Category::where('slug', 'gadget')->first();
        $gamingCategory = Category::where('slug', 'gaming')->first();
        $elektronikCategory = Category::where('slug', 'elektronik')->first();

        $products = [
            [
                'category_id' => $gadgetCategory->id,
                'name' => 'Smartphone XYZ',
                'slug' => 'smartphone-xyz',
                'description' => 'Smartphone terbaru dengan teknologi canggih',
                'price' => 4000000,
                'original_price' => 5000000,
                'image' => 'img/iphones-7479304_1280.jpg',
                'stock' => 50,
                'is_featured' => true,
                'badge' => '-20%',
                'specifications' => '128GB, 8GB RAM, 5G'
            ],
            [
                'category_id' => $gadgetCategory->id,
                'name' => 'Headphone ABC',
                'slug' => 'headphone-abc',
                'description' => 'Headphone dengan kualitas suara jernih',
                'price' => 1500000,
                'original_price' => null,
                'image' => 'img/headphone.jpg',
                'stock' => 30,
                'is_featured' => true,
                'badge' => null,
                'specifications' => 'Wireless, Noise Cancelling'
            ],
            [
                'category_id' => $gadgetCategory->id,
                'name' => 'Smartwatch Pro',
                'slug' => 'smartwatch-pro',
                'description' => 'Smartwatch untuk aktivitas sehari-hari',
                'price' => 2800000,
                'original_price' => null,
                'image' => 'img/smartwatch.jpg',
                'stock' => 25,
                'is_featured' => true,
                'badge' => 'Baru',
                'specifications' => 'Water Resistant, HR Monitor'
            ],
            [
                'category_id' => $gadgetCategory->id,
                'name' => 'Tablet Pro',
                'slug' => 'tablet-pro',
                'description' => 'Tablet untuk produktivitas dan hiburan',
                'price' => 6500000,
                'original_price' => null,
                'image' => 'img/ipad.webp',
                'stock' => 15,
                'is_featured' => true,
                'badge' => null,
                'specifications' => '10 inch, 256GB Storage'
            ],
            // Gaming Products
            [
                'category_id' => $gamingCategory->id,
                'name' => 'Gaming Laptop Pro',
                'slug' => 'gaming-laptop-pro',
                'description' => 'Laptop gaming dengan performa tinggi',
                'price' => 15000000,
                'original_price' => 18000000,
                'image' => 'img/Screenshot 2025-05-10 223743.png',
                'stock' => 10,
                'is_featured' => false,
                'badge' => '-17%',
                'specifications' => 'RTX 4060, 16GB RAM, 512GB SSD'
            ],
            [
                'category_id' => $gamingCategory->id,
                'name' => 'Gaming Mouse Wireless',
                'slug' => 'gaming-mouse-wireless',
                'description' => 'Mouse gaming wireless dengan RGB lighting',
                'price' => 750000,
                'original_price' => null,
                'image' => 'img/user.png',
                'stock' => 25,
                'is_featured' => false,
                'badge' => null,
                'specifications' => 'RGB, 12000 DPI, Wireless'
            ],
            // Electronics Products
            [
                'category_id' => $elektronikCategory->id,
                'name' => 'Smart TV 55 inch',
                'slug' => 'smart-tv-55-inch',
                'description' => 'Smart TV dengan kualitas 4K Ultra HD',
                'price' => 8500000,
                'original_price' => null,
                'image' => 'img/barang-elektronik.jpg',
                'stock' => 8,
                'is_featured' => false,
                'badge' => null,
                'specifications' => '4K Ultra HD, Smart OS, HDR'
            ],
            [
                'category_id' => $elektronikCategory->id,
                'name' => 'Air Conditioner 1 PK',
                'slug' => 'air-conditioner-1-pk',
                'description' => 'AC hemat energi dengan teknologi inverter',
                'price' => 4200000,
                'original_price' => 4800000,
                'image' => 'img/elektronik-2.jpeg',
                'stock' => 12,
                'is_featured' => false,
                'badge' => '-13%',
                'specifications' => '1 PK, Inverter, R32 Refrigerant'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

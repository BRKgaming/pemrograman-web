<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dapatkan semua pesanan yang telah selesai
        $orders = Order::where('status', 'completed')->get();
        
        // Tetapkan rating acak untuk setiap pesanan yang telah selesai
        foreach ($orders as $order) {
            // Rating acak antara 3.0 dan 5.0 (pelanggan cenderung puas)
            $rating = round(mt_rand(30, 50) / 10, 1);
            $order->rating = $rating;
            $order->save();
        }

        // Jika tidak ada pesanan sebelumnya, buat beberapa contoh untuk demo
        if ($orders->count() == 0) {
            // Dapatkan semua order apapun statusnya
            $allOrders = Order::all();
            
            if ($allOrders->count() > 0) {
                foreach ($allOrders->take(10) as $order) {
                    $rating = round(mt_rand(30, 50) / 10, 1);
                    $order->rating = $rating;
                    $order->save();
                }
            }
        }
        
        $this->command->info('Ratings telah ditambahkan ke pesanan yang telah selesai!');
    }
}

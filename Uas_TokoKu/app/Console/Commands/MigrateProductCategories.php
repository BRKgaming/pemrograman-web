<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class MigrateProductCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:migrate-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing products to use the new product_categories table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting product categories migration...');
        
        $products = Product::all();
        $count = 0;
        
        foreach ($products as $product) {
            // If the product has a category_id and it doesn't exist in the pivot table yet
            if ($product->category_id && !$product->categories()->where('categories.id', $product->category_id)->exists()) {
                // Attach the category as primary
                $product->categories()->attach($product->category_id, ['is_primary' => true]);
                $count++;
            }
        }
        
        $this->info("Migration completed! {$count} products updated with categories in the new table.");
        
        return 0;
    }
}

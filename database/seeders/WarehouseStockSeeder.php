<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\WarehouseStock;

class WarehouseStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeds initial stock into existing warehouses (type = 'warehouse' only).
     * Does NOT create any warehouse — WarehouseSeeder must run first.
     */
    public function run(): void
    {
        $products = Product::all();

        // Only seed into proper warehouses (not shops — shop stock comes through sales)
        $warehouses = Warehouse::where('type', 'warehouse')->get();

        if ($warehouses->isEmpty()) {
            $this->command->warn('WarehouseStockSeeder: No warehouses found. Run WarehouseSeeder first.');
            return;
        }

        foreach ($warehouses as $warehouse) {
            foreach ($products as $product) {
                // Skip if stock record already exists
                $exists = WarehouseStock::where('warehouse_id', $warehouse->id)
                    ->where('product_id', $product->id)
                    ->exists();

                if ($exists) {
                    continue;
                }

                WarehouseStock::create([
                    'branch_id'      => $warehouse->branch_id,
                    'warehouse_id'   => $warehouse->id,
                    'product_id'     => $product->id,
                    'quantity'       => 0,   // Start at zero — real stock added via Opening Stock/Purchases
                    'total_pieces'   => 0,
                    'remarks'        => 'Initial record — seeded via WarehouseStockSeeder',
                ]);
            }
        }

        $this->command->info(
            "WarehouseStockSeeder: Created stock records for {$warehouses->count()} warehouses × {$products->count()} products."
        );
    }
}

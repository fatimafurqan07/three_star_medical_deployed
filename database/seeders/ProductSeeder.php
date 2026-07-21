<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = base_path('products_raw.csv');
        if (!file_exists($csvPath)) {
            $this->command->error("CSV file not found at: $csvPath");
            return;
        }

        // Disable foreign key constraints and truncate tables
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\WarehouseStock::truncate();
        \App\Models\Product::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $file = fopen($csvPath, 'r');
        $header = fgetcsv($file);
        $header = array_map('trim', $header);

        $catIdx = array_search('CATEGORY', $header);
        $subCatIdx = array_search('SUBCATEGORY', $header);
        $brandIdx = array_search('BRAND', $header);
        $nameIdx = array_search('PRODUCT NAME', $header);
        $codeIdx = array_search('ITEM CODE', $header);
        $hsIdx = array_search('HS CODE', $header);
        $modelIdx = array_search('MODEL SERIES', $header);
        $mdrIdx = array_search('MDR', $header);
        $colorIdx = array_search('COLOR/TAGS', $header);
        $pcsIdx = array_search('PCS PER PACK', $header);

        // Default Unit
        $unit = \App\Models\Unit::firstOrCreate(['name' => 'Piece']);

        // Default Warehouse
        $warehouse = \App\Models\Warehouse::first();
        if (!$warehouse) {
            $this->command->error("No warehouses found. Ensure WarehouseSeeder runs before ProductSeeder.");
            return;
        }

        $importedCount = 0;
        $autoCodeCounter = 1;

        while (($row = fgetcsv($file)) !== false) {
            if (empty(array_filter($row))) {
                continue;
            }

            $catName = trim($row[$catIdx] ?? '');
            $subName = trim($row[$subCatIdx] ?? '');
            $brandName = trim($row[$brandIdx] ?? '');
            $itemName = trim($row[$nameIdx] ?? '');
            $itemCode = trim($row[$codeIdx] ?? '');
            $hsCode = trim($row[$hsIdx] ?? '');
            $model = trim($row[$modelIdx] ?? '');
            $mdr = trim($row[$mdrIdx] ?? '');
            $colorVal = trim($row[$colorIdx] ?? '');
            $pcsPerPack = trim($row[$pcsIdx] ?? '');

            // Resolve Category
            $categoryId = null;
            if ($catName !== '') {
                $category = \App\Models\Category::where('name', $catName)->first();
                if ($category) {
                    $categoryId = $category->id;
                }
            }

            // Resolve Subcategory
            $subCategoryId = null;
            if ($categoryId && $subName !== '') {
                $subcategory = \App\Models\Subcategory::where('category_id', $categoryId)
                    ->where('name', $subName)
                    ->first();
                if ($subcategory) {
                    $subCategoryId = $subcategory->id;
                }
            }

            // Resolve Brand
            $brandId = null;
            if ($brandName !== '') {
                $brand = \App\Models\Brand::where('name', $brandName)->first();
                if ($brand) {
                    $brandId = $brand->id;
                }
            }

            // Handle empty item code
            if ($itemCode === '') {
                $itemCode = 'AUTO-' . str_pad($autoCodeCounter++, 5, '0', STR_PAD_LEFT);
            }

            // Parse pieces per box
            $piecesPerBox = (int) $pcsPerPack;
            if ($piecesPerBox <= 0) {
                $piecesPerBox = 1;
            }

            // Format color tags as JSON array
            $colorJson = $colorVal !== '' ? json_encode([$colorVal]) : json_encode([]);

            // Create Product
            $product = \App\Models\Product::create([
                'creater_id' => 1,
                'category_id' => $categoryId,
                'sub_category_id' => $subCategoryId,
                'brand_id' => $brandId,
                'is_part' => 0,
                'is_assembled' => 0,
                'item_code' => $itemCode,
                'unit_id' => $unit->id,
                'item_name' => $itemName,
                'size_mode' => 'by_cartons',
                'pieces_per_box' => $piecesPerBox,
                'sale_price_per_box' => 0,
                'sale_price_per_piece' => 0,
                'purchase_price_per_piece' => 0,
                'purchase_price_per_box' => 0,
                'color' => $colorJson,
                'barcode_path' => rand(100000000000, 999999999999),
                'model' => $model,
                'mdr' => $mdr,
                'hs_code' => $hsCode,
                'is_fridge' => 0,
                'is_non_fridge' => 0,
                'is_fast_moving' => 0,
                'is_slow_moving' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Seed initial warehouse stock
            \App\Models\WarehouseStock::create([
                'branch_id' => $warehouse->branch_id,
                'warehouse_id' => $warehouse->id,
                'product_id' => $product->id,
                'quantity' => 100,
                'total_pieces' => 100 * $piecesPerBox,
                'remarks' => 'Seeded via CSV',
            ]);

            $importedCount++;
        }

        fclose($file);
    }
}

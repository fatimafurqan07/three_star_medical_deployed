<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Models\WarehouseStock;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$csvPath = 'products_raw.csv';
if (!file_exists($csvPath)) {
    die("CSV file not found at: $csvPath\n");
}

echo "Starting product import process...\n";

// Disable foreign key constraints and truncate tables
Schema::disableForeignKeyConstraints();
WarehouseStock::truncate();
Product::truncate();
Schema::enableForeignKeyConstraints();
echo "Truncated products and warehouse_stocks tables.\n";

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
$packIdx = array_search('PACK NAME', $header);
$pcsIdx = array_search('PCS PER PACK', $header);

// Default Unit
$unit = Unit::firstOrCreate(['name' => 'Piece']);

// Default Warehouse
$warehouse = Warehouse::first();
if (!$warehouse) {
    $warehouse = Warehouse::create([
        'branch_id' => 1,
        'warehouse_name' => 'Main Store',
        'creater_id' => 1,
        'location' => 'HQ',
    ]);
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
        $category = Category::where('name', $catName)->first();
        if ($category) {
            $categoryId = $category->id;
        }
    }
    
    // Resolve Subcategory
    $subCategoryId = null;
    if ($categoryId && $subName !== '') {
        $subcategory = Subcategory::where('category_id', $categoryId)
            ->where('name', $subName)
            ->first();
        if ($subcategory) {
            $subCategoryId = $subcategory->id;
        }
    }
    
    // Resolve Brand
    $brandId = null;
    if ($brandName !== '') {
        $brand = Brand::where('name', $brandName)->first();
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
        $piecesPerBox = 1; // sensible default
    }
    
    // Format color tags as JSON array
    $colorJson = $colorVal !== '' ? json_encode([$colorVal]) : json_encode([]);
    
    // Create Product
    $product = Product::create([
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
    
    // Seed initial warehouse stock (e.g. 100 boxes)
    WarehouseStock::create([
        'warehouse_id' => $warehouse->id,
        'product_id' => $product->id,
        'quantity' => 100, // 100 boxes
        'total_pieces' => 100 * $piecesPerBox,
        'remarks' => 'Imported via CSV script',
    ]);
    
    $importedCount++;
}

fclose($file);
echo "Successfully imported $importedCount products and created their warehouse stocks!\n";

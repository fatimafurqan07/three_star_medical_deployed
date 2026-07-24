<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->make('Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables')->bootstrap($app);
$app->make('Illuminate\Foundation\Bootstrap\LoadConfiguration')->bootstrap($app);
$app->make('Illuminate\Foundation\Bootstrap\RegisterFacades')->bootstrap($app);
$app->make('Illuminate\Foundation\Bootstrap\RegisterProviders')->bootstrap($app);
$app->make('Illuminate\Foundation\Bootstrap\BootProviders')->bootstrap($app);

use App\Models\ProductBatch;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Branch;

echo "--- BRANCHES ---\n";
foreach (Branch::all() as $b) {
    echo "Branch ID: {$b->id} | Name: {$b->name}\n";
}

echo "\n--- WAREHOUSES ---\n";
foreach (Warehouse::all() as $w) {
    echo "Warehouse ID: {$w->id} | Name: {$w->warehouse_name} | Type: {$w->type} | Branch ID: {$w->branch_id}\n";
}

echo "\n--- MALARIA PRODUCT BATCHES ---\n";
$prods = Product::where('item_name', 'like', '%MALARIA%')->get();
foreach ($prods as $p) {
    $batches = ProductBatch::where('product_id', $p->id)->get();
    if ($batches->count() > 0) {
        echo "Product ID: {$p->id} | Name: {$p->item_name}\n";
        foreach ($batches as $b) {
            echo "   Batch ID: {$b->id} | Lot: {$b->batch_number} | Branch ID: {$b->branch_id} | Warehouse ID: {$b->warehouse_id} | Qty Rem: {$b->qty_remaining}\n";
        }
    }
}

<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== receipts_vouchers ===\n";
$count = DB::table('receipts_vouchers')->count();
echo "Count: $count\n";
$last = DB::table('receipts_vouchers')->orderBy('id','desc')->limit(2)->get();
foreach($last as $r) { echo json_encode($r) . "\n"; }

echo "\n=== vouchers table ===\n";
$count2 = DB::table('vouchers')->count();
echo "Count: $count2\n";
$last2 = DB::table('vouchers')->orderBy('id','desc')->limit(2)->get();
foreach($last2 as $r) { echo json_encode($r) . "\n"; }

echo "\n=== payment_vouchers ===\n";
$count3 = DB::table('payment_vouchers')->count();
echo "Count: $count3\n";

echo "\n=== expense_vouchers ===\n";
$count4 = DB::table('expense_vouchers')->count();
echo "Count: $count4\n";

echo "\n=== voucher_masters ===\n";
$count5 = DB::table('voucher_masters')->count();
echo "Count: $count5\n";

echo "\n=== receipts_vouchers STRUCTURE ===\n";
$cols = DB::select('DESCRIBE receipts_vouchers');
foreach($cols as $c) {
    echo $c->Field . ' | ' . $c->Type . "\n";
}

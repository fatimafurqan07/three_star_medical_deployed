<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$vouchers = DB::table('voucher_masters')->where('date', '2026-06-06')->get();
foreach ($vouchers as $v) {
    echo "ID: {$v->id} | Date: {$v->date} | Type: {$v->voucher_type} | Voucher No: {$v->voucher_no} | Party Type: {$v->party_type} | Party ID: {$v->party_id} | Branch: '{$v->branch_id}' | Amount: {$v->total_amount}\n";
}

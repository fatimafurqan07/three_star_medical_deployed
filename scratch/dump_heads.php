<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$heads = DB::table('account_heads')->limit(5)->get();
foreach ($heads as $h) {
    echo "ID: {$h->id} | Name: {$h->name} | Branch: '{$h->branch_id}'\n";
}

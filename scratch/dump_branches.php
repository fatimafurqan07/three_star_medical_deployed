<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$branches = DB::table('branches')->get();
foreach ($branches as $b) {
    echo "ID: {$b->id} | Name: {$b->name}\n";
}

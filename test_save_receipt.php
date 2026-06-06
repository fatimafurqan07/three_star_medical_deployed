<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Log in user 1 (super admin) so auth()->id() works
$user = \App\Models\User::first();
auth()->login($user);

// Setup Request inputs
$requestData = [
    'rvid' => 'RVID-999',
    'payment_mode' => 'cash',
    'receipt_date' => '2026-06-06',
    'entry_date' => '2026-06-06',
    'remarks' => 'Test Receipt Voucher',
    'vendor_type' => 'customer',
    'vendor_id' => 1, // PIC
    'tel' => '12345678',
    'narration_id' => [null],
    'narration_text' => ['Test Narration'],
    'narration_type_text' => ['Manual'],
    'reference_no' => ['REF-999'],
    'row_account_head' => [1],
    'row_account_id' => [1], // Cash in hand
    'discount_value' => [0],
    'rate' => [0],
    'amount' => [1500],
    'total_amount' => 1500,
];

$request = new \Illuminate\Http\Request();
$request->replace($requestData);

$controller = app(\App\Http\Controllers\VoucherController::class);

try {
    echo "Calling store_rec_vochers...\n";
    
    // We will bypass session redirection check by capturing the exception inside or intercepting the response
    // But since there is DB transaction and try/catch inside the controller, let's see what happens.
    // To make sure we capture any exceptions, let's temporarily modify VoucherController or see what response is returned.
    $response = $controller->store_rec_vochers($request);
    
    echo "Response class: " . get_class($response) . PHP_EOL;
    if ($response instanceof \Illuminate\Http\RedirectResponse) {
        echo "Redirecting to: " . $response->getTargetUrl() . PHP_EOL;
        echo "Session errors: " . json_encode(session()->get('errors')) . PHP_EOL;
        echo "Session error message: " . session()->get('error') . PHP_EOL;
        echo "Session success message: " . session()->get('success') . PHP_EOL;
    }
} catch (\Exception $e) {
    echo "CAUGHT EXCEPTION: " . $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}

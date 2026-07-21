<?php
require 'vendor/autoload.php';
if ($xlsx = \Shuchkin\SimpleXLSX::parse('test_output.xlsx')) {
    echo "SUCCESS!\n";
    print_r($xlsx->rows());
} else {
    echo "ERROR: " . \Shuchkin\SimpleXLSX::parseError() . "\n";
}

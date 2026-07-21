<?php
$csvPath = 'products_raw.csv';
if (!file_exists($csvPath)) {
    die("CSV file not found!\n");
}

$file = fopen($csvPath, 'r');
$header = fgetcsv($file);
$header = array_map('trim', $header);

$catIdx = array_search('CATEGORY', $header);
$subCatIdx = array_search('SUBCATEGORY', $header);
$brandIdx = array_search('BRAND', $header);

echo "Indices - Category: $catIdx, Subcategory: $subCatIdx, Brand: $brandIdx\n";

$categories = [];
$subcategories = [];
$brands = [];
$totalRows = 0;

while (($row = fgetcsv($file)) !== false) {
    // skip empty rows
    if (empty(array_filter($row))) {
        continue;
    }
    $totalRows++;
    
    $cat = trim($row[$catIdx] ?? '');
    $sub = trim($row[$subCatIdx] ?? '');
    $brand = trim($row[$brandIdx] ?? '');
    
    if ($cat !== '') {
        $categories[$cat] = true;
        if ($sub !== '') {
            $subcategories[$cat][$sub] = true;
        }
    }
    if ($brand !== '') {
        $brands[$brand] = true;
    }
}
fclose($file);

echo "Total product rows in CSV: $totalRows\n\n";

echo "Categories and Subcategories in CSV:\n";
ksort($categories);
foreach (array_keys($categories) as $c) {
    echo "- $c\n";
    if (isset($subcategories[$c])) {
        $subs = array_keys($subcategories[$c]);
        sort($subs);
        foreach ($subs as $s) {
            echo "  * $s\n";
        }
    }
}

echo "\nBrands in CSV:\n";
$brandList = array_keys($brands);
sort($brandList);
foreach ($brandList as $b) {
    echo "- $b\n";
}

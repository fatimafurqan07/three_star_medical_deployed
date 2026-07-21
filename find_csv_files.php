<?php
function findFiles($dir) {
    $it = new RecursiveDirectoryIterator($dir);
    $display = array('csv', 'xlsx', 'txt', 'sql');
    foreach (new RecursiveIteratorIterator($it) as $file) {
        if ($file->isFile()) {
            $ext = strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
            if (in_array($ext, $display)) {
                $path = $file->getRealPath();
                // Exclude vendor, node_modules, storage/framework
                if (strpos($path, 'vendor') === false && strpos($path, 'node_modules') === false && strpos($path, 'storage\\framework') === false) {
                    echo "$path (" . $file->getSize() . " bytes)\n";
                }
            }
        }
    }
}

findFiles('c:\\xampp-new-latest\\htdocs\\threestar-old');

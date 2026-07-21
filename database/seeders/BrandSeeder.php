<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Safely truncate brands table
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Brand::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $brands = [
            'ABBOTT',
            'ATLAS',
            'BIO-VAC',
            'BIOANALYSE',
            'BIOPRO',
            'BIORESEARCH',
            'BIOSCIEN',
            'CHINA',
            'CRESCENT',
            'DFI',
            'DIACHEM',
            'DIAGAST',
            'DIAMOND',
            'GERMANY',
            'GMBH',
            'HEALGEN',
            'HELENA',
            'IMMUMED',
            'JMS',
            'LAB KITS',
            'MARIENFIELD',
            'MAXLIFE',
            'MISSION',
            'OTHER',
            'OXOID',
            'RIGHTSIGN',
            'ROCHE',
            'RSB',
            'SBIO',
            'SYSMEX',
            'WEGO',
            'XINLE',
            'YBK',
        ];

        foreach ($brands as $brandName) {
            Brand::create(['name' => $brandName]);
        }
    }
}



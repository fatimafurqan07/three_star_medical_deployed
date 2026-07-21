<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate existing categories and subcategories safely
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Subcategory::truncate();
        Category::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $data = [
            'BIOCHEMISTRY KITS' => ['ATLAS', 'BIORESEARCH', 'BIOSCIEN', 'CRESCENT', 'DIAGAST', 'HELENA', 'LAB KITS', 'OTHERS', 'SBIO'],
            'BLOOD COLLECTION' => ['BIO-VAC', 'XINLE', 'YBK'],
            'CULTURE MEDIA' => ['SBIO'],
            'DISC' => ['SESITIVITY DISC'],
            'DISPOSSABLE' => ['BLOOD BAG', 'GLASS WARE', 'MISC', 'MISCLINEOUS', 'NEEDLES', 'PLASTIC', 'PLASTIC WARE'],
            'EQUIPMENT' => ['MACHINES'],
            'INSTRUMENT' => ['ALERE', 'EQUIPMENT'],
            'PIPETTE' => ['MICRO PIPETTE'],
            'RAPID DEVICES' => ['ABBOTT', 'HEALGEN', 'OTHER', 'RIGHTSIGN'],
            'REAGENTS' => ['ALERE', 'CONTROLS', 'PROLYTE', 'SYSMEX'],
            'STAINS' => ['DIACHEM'],
            'URINE STRIPS' => ['ABBOTT', 'DFI', 'HEALGEN', 'ROCHE'],
        ];

        foreach ($data as $categoryName => $subcategories) {
            $category = Category::create(['name' => $categoryName]);

            foreach ($subcategories as $sub) {
                Subcategory::create([
                    'category_id' => $category->id,
                    'name' => $sub,
                ]);
            }
        }
    }
}

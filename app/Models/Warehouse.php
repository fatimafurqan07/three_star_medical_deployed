<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'creater_id');
    }
public function products() {
    return $this->belongsToMany(Product::class, 'product_warehouse')
                ->withPivot('stock');
}
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public static function ensureShopWarehousesExists()
    {
        $branches = \App\Models\Branch::all();
        if ($branches->isEmpty()) {
            self::firstOrCreate(
                ['type' => 'shop'],
                [
                    'warehouse_name' => 'Main Shop',
                    'branch_id' => 1,
                    'location' => 'Main Address',
                    'creater_id' => auth()->id() ?? 1,
                ]
            );
        } else {
            foreach ($branches as $branch) {
                self::firstOrCreate(
                    ['type' => 'shop', 'branch_id' => $branch->id],
                    [
                        'warehouse_name' => $branch->name . ' – Shop',
                        'location' => $branch->address,
                        'creater_id' => auth()->id() ?? 1,
                    ]
                );
            }
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_distributor', 'name', 'price', 'category', 'description', 'stock', 'image'
    ];

    public function flashSales()
    {
        return $this->hasMany(FlashSale::class);
    }
}

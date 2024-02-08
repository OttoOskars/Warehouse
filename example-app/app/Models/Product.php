<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'name',
        'description',
        'price',
        'manufacturer_id',
    ];
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id');
    }
    public function storage_products()
    {
        return $this->hasMany(StorageProduct::class, 'product_id');
    }
    public function shelf_products()
    {
        return $this->hasMany(ShelfProduct::class, 'product_id');
    }
    
}

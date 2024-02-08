<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageProduct extends Model
{
    use HasFactory;
    protected $table = 'storage_product';
    protected $primaryKey = 'storage_product_id';
    protected $fillable = [
        'product_id',
        'storage_id',
        'quantity',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function storage()
    {
        return $this->belongsTo(Storage::class, 'storage_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShelfProduct extends Model
{
    use HasFactory;
    protected $table = 'shelf_product';
    protected $primaryKey = 'shelf_product_id';
    protected $fillable = [
        'product_id',
        'shelf_id',
        'quantity',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function shelf()
    {
        return $this->belongsTo(Shelf::class, 'shelf_id');
    }
}

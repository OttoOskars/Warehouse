<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $primaryKey = 'order_id';
    protected $fillable = [
        'user_id',
        'product_id',
        'storage_id',
        'status_id',
        'quantity',
        'total_price',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function storage()
    {
        return $this->belongsTo(Storage::class, 'storage_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    
}

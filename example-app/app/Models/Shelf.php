<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;
    protected $table = 'shelf';
    protected $primaryKey = 'shelf_id';
    protected $fillable = [
        'name',
        'location',
        'capacity',
    ];
    public function shelf_products()
    {
        return $this->hasMany(ShelfProduct::class, 'shelf_id');
    }
}

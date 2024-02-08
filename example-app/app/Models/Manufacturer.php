<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use HasFactory;
    protected $table = 'manufacturer';
    protected $primaryKey = 'manufacturer_id';
    protected $fillable = [
        'name',
        'description',
        'location',
        'contact',
    ];
    public function products()
    {
        return $this->hasMany(Product::class, 'manufacturer_id');
    }
}

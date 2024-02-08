<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;
    protected $table = 'storage';
    protected $primaryKey = 'storage_id';
    protected $fillable = [
        'name',
        'location',
        'description',
    ];
    public function storage_products()
    {
        return $this->hasMany(StorageProduct::class, 'storage_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = 'status';
    protected $primaryKey = 'status_id';
    protected $fillable = [
        'name',
        'description',
        'color',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class, 'status_id');
    }
}

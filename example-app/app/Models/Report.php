<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = 'report';
    protected $primaryKey = 'report_id';
    protected $fillable = [
        'user_id',
        'description',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

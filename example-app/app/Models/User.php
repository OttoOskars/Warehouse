<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
    ];
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function reports()
    {
        return $this->hasMany(Report::class, 'user_id');
    }
    public function orders()
    {
        return $this->belongsTo(Order::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Mass assignable fields
    protected $fillable = ['name', 'mobile', 'password', 'role'];

    // Hidden fields
    protected $hidden = ['password', 'remember_token'];

    // Attribute casting
    protected $casts = [
        'password' => 'hashed',
    ];

    // Relationship
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // Helper
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Authentication identifier
    public function getAuthIdentifierName()
    {
        return 'name'; // use 'name' instead of 'email' for login
    }
}


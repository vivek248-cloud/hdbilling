<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FullSemiType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rate'];

    // ✅ Relationship
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

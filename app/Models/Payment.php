<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['project_id', 'amount', 'payment_mode', 'date'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['project_id', 'description', 'spec', 'area', 'unit', 'rate', 'length', 'width', 'date'];
    protected $dates = ['date'];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

        // Dynamically calculate amount
    public function getAmountAttribute()
    {
        return $this->area * $this->rate;
    }

    public function expenses() {
        return $this->hasMany(Expense::class);
    }

}


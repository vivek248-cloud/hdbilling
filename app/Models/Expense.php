<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'description', 'spec', 'area', 'unit', 'rate', 
        'length', 'width', 'date', 'floor_type_id', 'room_type_id'
        ,'group','group2',
    ];

    protected $dates = ['date'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // ✅ Calculate total value dynamically
    public function getAmountAttribute()
    {
        return $this->area * $this->rate;
    }

    // ✅ Floor Type Relation
    public function floorType()
    {
        return $this->belongsTo(\App\Models\FloorType::class, 'group', 'id');
    }

    public function roomType()
    {
        return $this->belongsTo(\App\Models\RoomType::class, 'group2', 'id');
    }

}

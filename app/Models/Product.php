<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_name',
        'entity',
        'specification',
        'unit',
        'length',
        'width',
        'area',
        'rate',
        'type',             // Full/Semi
        'core_material',
        'finish_material',
        'brand',
        'price',
    ];


    // 🔗 Relationship: Each product belongs to a customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // 🔗 Relationship: Each product belongs to a FullSemiType

    public function fullSemiType()
    {
        return $this->belongsTo(FullSemiType::class, 'type');
    }


}

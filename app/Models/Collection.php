<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $table = "collections";

    protected $appends = ['seller', 'collector','status'];

    // Accessor method to retrieve seller data
    public function getSellerAttribute()
    {
        return $this->seller()->first(); // assuming you have a 'seller' relationship
    }

    // Accessor method to retrieve collector data
    public function getCollectorAttribute()
    {
        return $this->collector()->first(); // assuming you have a 'collector' relationship
    }

    public function getStatusAttribute()
    {
        return $this->status()->first();
    }


    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // Relationship: Collection belongs to a collector (belongsTo)
    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function images()
    {
        return $this->hasMany(Collection::class);
    }
}

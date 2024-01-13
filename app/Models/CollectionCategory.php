<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionCategory extends Model
{
    use HasFactory;

    protected $table = "category_collections";


    protected $appends = ['category'];


    public function getCategoryAttribute()
    {
        return $this->category()->first(); 
    }

    public function collections()
    {
        return $this->belongsTo(Collections::class, 'collection_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionImage extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $table = "collection_images";

    protected $appends = [];

    public function collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id');
    }
}

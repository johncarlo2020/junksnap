<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $table = "collections";

    protected $appends = ['seller', 'collector','status','images','imageName','category'];

    protected $hidden = ['categories'];

    public function getSellerAttribute()
    {
        return $this->seller()->first(); 
    }

    public function getCollectorAttribute()
    {
        return $this->collector()->first(); 
    }

    public function getStatusAttribute()
    {
        return $this->status()->first();
    }

    public function getCategoryAttribute()
    {
        return $this->categories;
    }

    public function getImageNameAttribute()
    {
        return $this->getAttributes()['images'] ?? '';
    }

    public function getImagesAttribute()
    {
        $file = $this->getAttributes()['images'] ?? '';

        return  asset('storage/' . $file);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_collections');
    }

    public function images()
    {
        return $this->hasMany(Collection::class);
    }
}

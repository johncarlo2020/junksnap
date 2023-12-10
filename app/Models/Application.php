<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $table = "applications";

    protected $appends = ['images','status'];

    protected $fillable = [
        'status_id', 'comment'
    ];
    

    public function getImagesAttribute()
    {

        $imageUrls = [];

        $images = $this->images()->get();
        
        foreach ($images as $key => $image) {
            $imageUrls[$key] = asset('storage/' . $image->image);
        }

        return $imageUrls;
    }

    public function getStatusAttribute()
    {
        return $this->status()->first();
    }


    public function status()
    {
        return $this->belongsTo(ApplicationStatus::class, 'status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(ApplicationImage::class);
    }
}

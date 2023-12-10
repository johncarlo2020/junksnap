<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationImage extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $table = "application_images";

    protected $appends = [];

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}

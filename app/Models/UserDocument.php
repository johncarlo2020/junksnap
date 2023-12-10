<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $table = "user_documents";

    protected $appends = [];

    public function images()
    {
        return $this->belongsTo(User::class);
    }
}

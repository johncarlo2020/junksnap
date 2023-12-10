<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;


	protected $guarded = [];
    
    protected $table = "status";

    protected $appends = [];

    public function collections()
    {
        return $this->hasMany(Collections::class, 'status_id');
    }
   
}

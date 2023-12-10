<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use HasFactory;


	protected $guarded = [];
    
    protected $table = "application_status";

    protected $appends = [];

    public function application()
    {
        return $this->hasMany(Application::class, 'status_id');
    }
}

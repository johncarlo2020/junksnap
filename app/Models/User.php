<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ,HasRoles, HasPanelShield;

    protected $appends = ['role','image','personalInformation','application'];

    public function getRoleAttribute()
    {
        // Assuming a user has only one role, you can adjust this logic based on your requirements
        $role = $this->roles->first();

        return $role ? $role->name : null;
    }

    public function getImageAttribute()
    {
        $file = $this->getAttributes()['image'] ?? '';

        return  asset('storage/' . $file);
    }

    public function getPersonalInformationAttribute():bool
    {
        $attributes = $this->getAttributes();

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'mobile_number' => 'required',
            'bday' => 'required',
            'range' => 'required',
            'address' => 'required',
            'image' => 'required',
        ];
    
        $validator = validator($attributes, $rules);
    
        return !$validator->fails();
    
    }

    public function getApplicationAttribute()
    {
        return $this->application()->orderBy('id','desc')->first();
    }

     // Relationship with collections as a collector
     public function collectionsAsSeller()
     {
         return $this->hasMany(Collection::class, 'seller_id');
     }
 
     // Relationship: User as a collector (hasMany)
     public function collectionsAsCollector()
     {
         return $this->hasMany(Collection::class, 'collector_id');
     }

     public function application()
     {
         return $this->hasMany(Application::class, 'user_id');
     }


     protected $fillable = [
        'name', 'email','password','verified','fcm_token'
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'verified' => 'boolean',
        'active' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        
    ];

}

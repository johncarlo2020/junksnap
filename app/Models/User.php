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

    protected $appends = ['role','image','documents'];

    public function getRoleAttribute()
    {
        // Assuming a user has only one role, you can adjust this logic based on your requirements
        $role = $this->roles->first();

        return $role ? $role->name : null;
    }

    public function getImageAttribute()
    {

        $file = $this->getAttributes()['image'];

        return  asset('storage/' . $file);
    }

    public function getDocumentsAttribute()
    {
        $imageUrls = [];

        $documents =  $this->documents()->get();

        foreach ($documents as $key => $image) {
            $imageUrls[$key] = asset('storage/' . $image->image) ?? '';
        }

        return $imageUrls;
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

     public function documents()
     {
         return $this->hasMany(UserDocument::class);
     }
    

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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}

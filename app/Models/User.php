<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        "role",
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function elections()
    {
        return $this->belongsToMany(Election::class)
                    ->withPivot('application_status') 
                    ->withTimestamps();
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'candidate_id');
    }

    public function votes()
{
    return $this->hasMany(Vote::class);
}
}
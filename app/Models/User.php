<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'rut',
        'phone',
        'partner',
        'role_id'
    ];

    protected $hidden = [
        'password'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function isAdmin()
    {
        $response = false;

        foreach ($this->role->permissions as $permission) {
            if ($permission->route_name == 'admin.home') {
                $response = true;
                break;
            }
        }

        return $response;
    }

    public function hasPermission($routeName)
    {
        $response = false;

        foreach ($this->role->permissions as $permission) {
            if ($permission->route_name == $routeName) {
                $response = true;
                break;
            }
        }

        return $response;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
        'route_name',
        'label',
        'icon',
        'menu_item',
        'order',
        'permission_menu_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function permissionMenu()
    {
        return $this->belongsTo(PermissionMenu::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}

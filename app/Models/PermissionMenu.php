<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionMenu extends Model
{
    protected $table = 'permission_menu';

    protected $fillable = [
        'name'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}

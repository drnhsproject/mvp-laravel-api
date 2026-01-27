<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use \App\Traits\HasStandardAttributes;

    protected $fillable = [
        'module',
        'submodule',
        'action',
        'method',
        'uri',
        'namespace',
        'ordering',
    ];

    protected $casts = [
        'ordering' => 'integer',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'privilege_role')
            ->using(PrivilegeRole::class)
            ->withTimestamps();
    }
}

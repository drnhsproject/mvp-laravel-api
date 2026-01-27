<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use \App\Traits\HasStandardAttributes;

    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(RoleUser::class)
            ->withTimestamps();
    }

    public function privileges()
    {
        return $this->belongsToMany(Privilege::class, 'privilege_role')
            ->using(PrivilegeRole::class)
            ->withTimestamps();
    }
}

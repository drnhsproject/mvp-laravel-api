<?php

namespace App\Models;

use App\Traits\HasStandardAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasStandardAttributes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'username',
        'password',
        'is_active',
        'is_verified',
        'last_login_at',
        'login_attempts',
        'login_count',
        'locked_until',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activation_key',
        'reset_key',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
            'reset_key_expires_at' => 'datetime',
            'reset_date' => 'datetime',
            'last_login_at' => 'datetime',
            'locked_until' => 'datetime',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->using(RoleUser::class)
            ->withTimestamps();
    }

    /**
     * Check if user has privilege.
     */
    /**
     * Check if user has privilege.
     */
    public function hasPrivilege(string $module, string $action, string $namespace = '*'): bool
    {
        $this->loadMissing('roles.privileges');

        return $this->roles
            ->flatMap
            ->privileges
            ->contains(function ($privilege) use ($module, $action, $namespace) {

                // Check Namespace (if explicit namespace requested)
                // Wildcard in DB allows all
                $privilegeNamespace = $privilege->namespace ?? '*';
                $namespaceMatch = ($privilegeNamespace === '*')
                    || ($namespace === '*')
                    || ($privilegeNamespace === $namespace);

                if (!$namespaceMatch) {
                    return false;
                }

                // Wildcard Module
                if ($privilege->module === '*' || $privilege->module === 'All Access') {
                    return true;
                }

                // Exact Module
                if ($privilege->module === $module) {
                    // Wildcard Action
                    if ($privilege->action === '*') {
                        return true;
                    }
                    // Exact Action
                    return $privilege->action === $action;
                }

                return false;
            });
    }
}

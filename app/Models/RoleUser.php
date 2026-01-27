<?php

namespace App\Models;

use App\Traits\HasAuthors;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{
    use HasAuthors;

    protected $table = 'role_user';
}

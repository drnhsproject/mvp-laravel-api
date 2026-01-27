<?php

namespace App\Models;

use App\Traits\HasAuthors;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PrivilegeRole extends Pivot
{
    use HasAuthors;

    protected $table = 'privilege_role';
}

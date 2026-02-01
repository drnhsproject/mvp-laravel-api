<?php

namespace App\Models;

use App\Traits\HasStandardAttributes;
use Illuminate\Database\Eloquent\Model;

class SystemParameter extends Model
{
    use HasStandardAttributes;

    protected $table = 'sysparams';

    protected $fillable = [
        'groups',
        'key',
        'value',
        'ordering',
        'description',
    ];

    protected $casts = [
        'ordering' => 'integer',
    ];
}

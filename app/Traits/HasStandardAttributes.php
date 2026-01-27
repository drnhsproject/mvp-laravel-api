<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;

trait HasStandardAttributes
{
    use SoftDeletes, HasAuthors;

    /**
     * Boot the standard attributes trait.
     */
    protected static function bootHasStandardAttributes(): void
    {
        static::creating(function ($model) {
            // Generate UUIDv7 for code if not set
            if (empty($model->code)) {
                $model->code = (string) Uuid::uuid7();
            }

            // Set default status if not set
            if (!isset($model->status)) {
                $model->status = 1;
            }
        });
    }

    /**
     * Initialize the standard attributes trait.
     */
    public function initializeHasStandardAttributes(): void
    {
        $this->mergeFillable([
            'code',
            'status',
        ]);

        $this->mergeCasts([
            'status' => 'integer',
        ]);
    }
}

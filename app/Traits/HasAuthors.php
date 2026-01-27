<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasAuthors
{
    /**
     * Boot the authors trait.
     */
    protected static function bootHasAuthors(): void
    {
        static::creating(function ($model) {
            if (Auth::check() && empty($model->created_by)) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('created_by')) {
                $model->created_by = $model->getOriginal('created_by');
            }

            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }

    /**
     * Initialize the authors trait.
     */
    public function initializeHasAuthors(): void
    {
        $this->mergeFillable([
            'created_by',
            'updated_by',
        ]);
    }
}

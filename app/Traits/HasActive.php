<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasActive
{
    /**
     * Scope a query to only include active models.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereActive(true);
    }

    /**
     * Scope a query to only include inactive models.
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->whereActive(false);
    }
}

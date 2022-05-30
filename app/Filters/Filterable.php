<?php

namespace App\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait Filterable {
    public static function filter(Filter $request): Builder
    {
        $query = static::query();
        $request->filter($query);
        return $query;
    }
}

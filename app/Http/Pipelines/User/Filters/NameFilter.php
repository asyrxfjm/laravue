<?php

namespace App\Http\Pipelines\User\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class NameFilter
{
    public function handle(Builder $query, Closure $next)
    {
        $query->when(request()->filled('name'), function (Builder $query) {
            $query->where('name', 'like', '%'.request('name').'%');
        });

        return $next($query);
    }
}

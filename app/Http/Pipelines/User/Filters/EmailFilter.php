<?php

namespace App\Http\Pipelines\User\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class EmailFilter
{
    public function handle(Builder $query, Closure $next)
    {
        if (request()->filled('email')) {
            $query->where('email', 'like', '%'.request('email').'%');
        }

        return $next($query);
    }
}

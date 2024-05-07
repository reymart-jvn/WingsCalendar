<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Cache;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $this->clearUserCache($request->user());
        
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    protected function clearUserCache($user)
    {
        //clear cache for permission both sidebar and view
        Cache::forget('employee');
        Cache::forget('accesses');
        Cache::forget('accesses_status');
        Cache::forget('per_employee');
        Cache::forget('per_accesses');
        Cache::forget('per_accesses_status');
        Cache::forget('get_company_helpers');
        Cache::forget('employee_helpers');
    }
}

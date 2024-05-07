<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;



class InactivityTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $lastActivity = session('last_activity');

        if ($user && $lastActivity && time() - $lastActivity > 3600) {
            // User has been inactive for 30 minutes (1800 seconds)
            // Auth::logout();
            $request->session()->invalidate();
            Artisan::call('cache:clear'); // Clear the cache
            $this->clearUserCache($request->user());
            return redirect()->route('login')->with('timeout', 'You have been automatically logged out due to inactivity.');
        }

        session(['last_activity' => time()]);

        return $next($request);
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

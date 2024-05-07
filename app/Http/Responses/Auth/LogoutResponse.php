<?php
namespace App\Http\Responses\Auth;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Support\Facades\Cache;

class LogoutResponse implements LogoutResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $this->clearUserCache($request->user());

        if ($request->wantsJson()) {
            return new JsonResponse(['message' => 'Logged out'], 200);
        } else {
            return redirect('/');
        }
    }

    /**
     * Clear the cache associated with the user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
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

<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;
use Illuminate\Support\Facades\Auth;

class TwoFactorLoginResponse implements TwoFactorLoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $role = Auth::user()->is_admin;

        if ($request->wantsJson()) {
            return response('', 204);
        }

        switch ($role) {
            case '1':
                return redirect()->intended('/dashboard');
            case '0':
                return redirect()->intended(config('fortify.view-calendar'));
            default:
                return redirect('/');
        }
    }
}

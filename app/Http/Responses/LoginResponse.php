<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
        
        // below is the existing response
        // replace this with your own code
        // the user can be located with Auth facade
        
        $role = Auth::user()->is_admin;
         // However you get role
    //    dd($checkrole);
        if ( $role == "1") {
           return redirect('/dashboard');
        } else {
            return redirect('/view-calendar');
        }
        return $request->wantsJson()
                    ? response()->json(['two_factor' => false])
                    : redirect()->intended(config('fortify.view-calendar'));
    }

}
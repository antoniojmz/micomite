<?php

namespace App\Http\Middleware;

//Facades
use App;
use Closure;
use Route;
use View;
use Redirect;
use Malahierba\Token\Token;


//Models
use App\Models\User;


class VerifyPasswordResetToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Validate the token
        $token_is_valid = false;

        $user = User::where('email', Route::input('user_email'))->first();

        if ($user) {

             $token = new Token(
                $user,
                'password reset'
        );

        if ($token->check(Route::input('password_reset_token')))
            $token_is_valid = true;
        }

        if(! $token_is_valid)
            return Redrect::route('password_reset_invalid_token')->with('password_reset_invalid_token', true);

        App::instance('password_reset_user', $user);

        return $next($request);
    }
}

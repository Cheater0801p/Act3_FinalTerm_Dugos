<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuth extends Controller
{
    public function redirectgoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handlecallback()
    {
        $user = Socialite::driver('google')->user();
        return $this->login($user, 'google'); 
    }

    public function login()
    {
      $user = User::updateOrCreate([
        'email' => $socialUser->getEmail(),
    ], [
        'first_name' => $socialUser->getName(),
        'auth_method' => $provider,
    ]);

    Auth::login($user);
    return redirect('/');
}
    }

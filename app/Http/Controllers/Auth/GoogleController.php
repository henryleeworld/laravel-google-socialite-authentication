<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Exception;
use Socialite;
  
class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
      
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
    
            $googleUser = Socialite::driver('google')->user();
            $user = User::updateOrCreate([
                'google_id'       => $googleUser->id,
                'google_nickname' => $googleUser->nickname,
                'google_avatar'   => $googleUser->avatar,
            ], [
                'name'            => $googleUser->name,
                'email'           => $googleUser->email,
                'password'        => encrypt('123456dummy')
            ]);
            Auth::login($user);
            return redirect('/dashboard');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}


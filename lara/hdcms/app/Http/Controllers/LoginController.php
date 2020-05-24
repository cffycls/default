<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelSocialite\Socialite;

class LoginController extends Controller
{
    //
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback()
    {
        $github_user = Socialite::driver('github')->user();

        $user=User::where('github_name',$github_user->name)->first();
        if(empty($user)){
            $user=User::create([
                'name'=>$github_user->name,
                'email'=>$github_user->email,
                'github_name'=>$github_user->name,
                'avatar'=>$github_user->avatar,
                'verified'=>1,
            ]);
        }
        Auth::login($user);
        return Redirect()->guest('/');
    }

    public function index()
    {

    }

}

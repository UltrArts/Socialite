<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\{
    User,

};

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function authCallback(string $provider){
        try{
            $u = Socialite::driver($provider)->user();
            $user = User::updateOrCreate([
                'email' =>  $u->getEmail(),
            ],[
                'name'  => $u->getName(),
                'email' => $u->getEmail(),
                'provider_avatar'   => $u->getAvatar(),
                'provider'          =>  $provider,
                'provider_name'     => $u->getName(),
                'provider_id'       => $u->getId(),
            ]);
            Auth::login($user);

            return redirect('/dashboard');
        }catch(Error $e){
            dd($e);
        }
        // try {
        //     //code...
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
    }
}

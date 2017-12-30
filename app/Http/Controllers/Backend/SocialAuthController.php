<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Socialite;
use App\Notificacion;

class SocialAuthController extends Controller
{
     //login socialite
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function handleProviderCallback($provider)
    {
         // Obtenemos los datos del usuario
        $social_user = Socialite::driver($provider)->user(); 
        //Comprobamos si el usuario ya existe
        if ($user = User::where('email', $social_user->email)->first()) 
        { 
            return $this->authAndRedirect($user); // Login y redirección
        } else 
        {  
            // En caso de que no exista creamos un nuevo usuario con sus datos.
            $user = User::create([
                'name' => $social_user->name,
                'email' => $social_user->email,
                'foto' => $social_user->avatar,
                'redsocial' => $provider,
                'redsocial_id' => $social_user->id,
                'rol_id' => 1,
                'localidad_id' =>1
            ]);
            Notificacion::create([
                'mensaje' => config('app.mensaje_bienvenida'),
                'ruta' => '/hola',
                'user_id' => $user->id
            ]);
 
            return $this->authAndRedirect($user); // Login y redirección
        }
        //return $provider;
    }
    public function authAndRedirect($user)
    {
        Auth::login($user);
        return redirect('/');
    }
}

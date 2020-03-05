<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
            session(['link' => url()->previous()]);
            return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider, Request $request)
    {
        
        $providerUser = Socialite::driver($provider)->user();
        $user = User::where('provider_id', $providerUser->getId())->first();
        if (!$user){
            $user = User::create([
                'email' => $providerUser->getEmail(),
                'name' => is_null($providerUser->getName()) ? 'N/A'  : $providerUser->getName(),
                'provider_id' => $providerUser->getId(),
                'provider' => $provider
                ]);
        } 
        Auth::login($user, true);
        $request->session()->flash('status', 'prompt-modal');
        return redirect(session('link'));
        // $user->token;
    }

}

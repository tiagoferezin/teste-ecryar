<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Facebook\Facebook;

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
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebookProvider()
    {
        return Socialite::driver('facebook')->scopes([
            "pages_show_list", "manage_pages", "pages_messaging", "pages_messaging_phone_number", "pages_messaging_subscriptions", "public_profile", "email"])->redirect();
    }

    public function loginFacebook(){
        $fb = new Facebook([
            'app_id' => '356321788489607',
            'app_secret' => '70d8add9f5005fd814ece322955dd159',
            'default_graph_version' => 'v2.10',
            ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ["pages_show_list", "manage_pages", "pages_messaging", "pages_messaging_phone_number", "pages_messaging_subscriptions", "public_profile", "email"]; // Optional permissions
        $loginUrl = $helper->getLoginUrl('https://teste.dev.br/login/facebook/callback', $permissions);

        echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
    }
 
    /**
     * Obtain the user information from Facebook.
     *
     * @return void
     */
    public function handleProviderFacebookCallback()
    {
        $auth_user = Socialite::driver('facebook')->user();
 
        $user = User::updateOrCreate(
            [
                'email' => $auth_user->email
            ],
            [
                'token' => $auth_user->token,
                'name'  =>  $auth_user->name
            ]
        );
 
        Auth::login($user, true);
        return redirect()->to('/'); // Redirect to a secure page
    }
}

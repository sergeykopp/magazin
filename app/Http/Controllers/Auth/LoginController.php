<?php

namespace Kopp\Http\Controllers\Auth;

use Kopp\Http\Controllers\ClientController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends ClientController
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        $this->data['title'] = 'Вход';
        $this->template = 'auth.login';
        return $this->renderOutput();
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        if (session()->has('cart')) {
            $sessionProducts = json_decode(session()->get('cart'), true);
            $request->session()->flush();
            $request->session()->regenerate();
            session(['cart' => json_encode($sessionProducts)]);
        } else {
            $request->session()->flush();
            $request->session()->regenerate();
        }

        return redirect('/');
    }
}

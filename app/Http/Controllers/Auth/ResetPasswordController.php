<?php

namespace Kopp\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Kopp\Http\Controllers\ClientController;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends ClientController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        $this->data['title'] = 'Сброс пароля';
        $this->data['token'] = $token;
        $this->data['email'] = $request->email;
        $this->template = 'auth.passwords.reset';
        return $this->renderOutput();
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];
    }
}

<?php

namespace Kopp\Http\Controllers\Auth;

use Kopp\Http\Requests\RegisterUserRequest;
use Kopp\User;
use Kopp\Http\Controllers\ClientController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

class RegisterController extends ClientController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

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

    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
    }

    public function showRegistrationForm()
    {
        $this->data['title'] = 'Регистрация';
        $this->template = 'auth.register';
        return $this->renderOutput();
    }

    public function register(RegisterUserRequest $request)
    {
        //$this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    /*protected function validator(array $data)
    {
        // Преобразование телефона
        if (array_key_exists('phone', $data)) {
            $oldPhone = $data['phone'];
            // Удаление в телефоне всего, кроме цифр
            $data['phone'] = trim(preg_replace('/\D/u', '', $data['phone']));
            if (7 == mb_strlen($data['phone'], 'utf-8')) {
                $data['phone'] = preg_replace('/^[78]/u', '', $data['phone']);
                if (7 == mb_strlen($data['phone'], 'utf-8')) {
                    preg_match('/(\d)(\d)(\d)(\d)(\d)(\d)(\d)/', $data['phone'], $regs);
                    $data['phone'] = "$regs[1]$regs[2]$regs[3]-$regs[4]$regs[5]-$regs[6]$regs[7]";
                } else {
                    $data['phone'] = $oldPhone;
                }
            } elseif (10 == mb_strlen($data['phone'], 'utf-8')) {
                $data['phone'] = preg_replace('/^[78]/u', '', $data['phone']);
                if (10 == mb_strlen($data['phone'], 'utf-8')) {
                    preg_match('/(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)/', $data['phone'], $regs);
                    $data['phone'] = "+7 ($regs[1]$regs[2]$regs[3]) $regs[4]$regs[5]$regs[6]-$regs[7]$regs[8]-$regs[9]$regs[10]";
                } else {
                    $data['phone'] = $oldPhone;
                }
            } elseif (11 == mb_strlen($data['phone'], 'utf-8')) {
                preg_match('/(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)/', $data['phone'], $regs);
                $data['phone'] = "+7 ($regs[2]$regs[3]$regs[4]) $regs[5]$regs[6]$regs[7]-$regs[8]$regs[9]-$regs[10]$regs[11]";
            } else {
                $data['phone'] = $oldPhone;
            }
        }

        $rules = [
            'name' => 'required',
            'phone' => 'required|regex:/(\+7 \([0-9]{3}\) )?[0-9]{3}-[0-9]{2}-[0-9]{2}/',
            'address' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ];

        $messages = [
            'name.required' => 'Поле обязательно к заполнению',
            'phone.required' => 'Поле обязательно к заполнению',
            'phone.regex' => 'Похоже не хватает цифр для телефона',
            'address.required' => 'Поле обязательно к заполнению',
            'email.required' => 'Поле обязательно к заполнению',
            'email.email' => 'Поле должно быть корректным почтовым адресом.',
            'email.unique' => 'Такой адрес уже зарегистрирован в системе.',
            'password.required' => 'Поле обязательно к заполнению',
            'password.min' => 'Пароль должен быть не менее :min символов и соответствовать подтверждению.',
            'password.confirmed' => 'Пароль должен быть не менее 8 символов и соответствовать подтверждению.',
        ];

        return Validator::make($data, $rules, $messages);
    }*/

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        /*// Преобразование телефона
        if (array_key_exists('phone', $data)) {
            $oldPhone = $data['phone'];
            // Удаление в телефоне всего, кроме цифр
            $data['phone'] = trim(preg_replace('/\D/u', '', $data['phone']));
            if (7 == mb_strlen($data['phone'], 'utf-8')) {
                $data['phone'] = preg_replace('/^[78]/u', '', $data['phone']);
                if (7 == mb_strlen($data['phone'], 'utf-8')) {
                    preg_match('/(\d)(\d)(\d)(\d)(\d)(\d)(\d)/', $data['phone'], $regs);
                    $data['phone'] = "$regs[1]$regs[2]$regs[3]-$regs[4]$regs[5]-$regs[6]$regs[7]";
                } else {
                    $data['phone'] = $oldPhone;
                }
            } elseif (10 == mb_strlen($data['phone'], 'utf-8')) {
                $data['phone'] = preg_replace('/^[78]/u', '', $data['phone']);
                if (10 == mb_strlen($data['phone'], 'utf-8')) {
                    preg_match('/(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)/', $data['phone'], $regs);
                    $data['phone'] = "+7 ($regs[1]$regs[2]$regs[3]) $regs[4]$regs[5]$regs[6]-$regs[7]$regs[8]-$regs[9]$regs[10]";
                } else {
                    $data['phone'] = $oldPhone;
                }
            } elseif (11 == mb_strlen($data['phone'], 'utf-8')) {
                preg_match('/(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)/', $data['phone'], $regs);
                $data['phone'] = "+7 ($regs[2]$regs[3]$regs[4]) $regs[5]$regs[6]$regs[7]-$regs[8]$regs[9]-$regs[10]$regs[11]";
            } else {
                $data['phone'] = $oldPhone;
            }
        }*/

        return User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}

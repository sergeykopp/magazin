<?php

namespace Kopp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    // Подготовка перед валидацией
    public function prepareForValidation()
    {
        // Преобразование телефона
        if ($this->request->has('phone')) {
            $oldPhone = $this->request->get('phone');
            // Удаление в телефоне всего, кроме цифр
            $this->request->set('phone', trim(preg_replace('/\D/u', '', $this->request->get('phone'))));
            if (7 == mb_strlen($this->request->get('phone'), 'utf-8')) {
                $this->request->set('phone', preg_replace('/^[78]/u', '', $this->request->get('phone')));
                if (7 == mb_strlen($this->request->get('phone'), 'utf-8')) {
                    preg_match('/(\d)(\d)(\d)(\d)(\d)(\d)(\d)/', $this->request->get('phone'), $regs);
                    $this->request->set('phone', "$regs[1]$regs[2]$regs[3]-$regs[4]$regs[5]-$regs[6]$regs[7]");
                } else {
                    $this->request->set('phone', $oldPhone);
                }
            } elseif (10 == mb_strlen($this->request->get('phone'), 'utf-8')) {
                $this->request->set('phone', preg_replace('/^[78]/u', '', $this->request->get('phone')));
                if (10 == mb_strlen($this->request->get('phone'), 'utf-8')) {
                    preg_match('/(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)/', $this->request->get('phone'), $regs);
                    $this->request->set('phone', "+7 ($regs[1]$regs[2]$regs[3]) $regs[4]$regs[5]$regs[6]-$regs[7]$regs[8]-$regs[9]$regs[10]");
                } else {
                    $this->request->set('phone', $oldPhone);
                }
            } elseif (11 == mb_strlen($this->request->get('phone'), 'utf-8')) {
                preg_match('/(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)(\d)/', $this->request->get('phone'), $regs);
                $this->request->set('phone', "+7 ($regs[2]$regs[3]$regs[4]) $regs[5]$regs[6]$regs[7]-$regs[8]$regs[9]-$regs[10]$regs[11]");
            } else {
                $this->request->set('phone', $oldPhone);
            }
        }
    }

    // Правила валидации
    public function rules()
    {
        return [
            'name' => 'required',
            'phone' => 'required|regex:/(\+7 \([0-9]{3}\) )?[0-9]{3}-[0-9]{2}-[0-9]{2}/',
            'address' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ];
    }

    // Сообщения ошибок валидации
    public function messages()
    {
        return [
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
    }
}

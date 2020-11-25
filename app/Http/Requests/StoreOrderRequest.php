<?php

namespace Kopp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'phone' => 'required|regex:/(\+7 \([0-9]{3}\) )?[0-9]{3}-[0-9]{2}-[0-9]{2}/',
            'address' => 'required',
            'email' => 'nullable|email',
        ];
    }

    // Сообщения ошибок валидации
    public function messages()
    {
        return [
            'phone.required' => 'Поле обязательно к заполнению',
            /*'phone.regex' => 'Поле должно иметь формат +7 (000) 000-00-00 или 000-00-00',*/
            'phone.regex' => 'Похоже не хватает цифр для телефона',
            'address.required' => 'Поле обязательно к заполнению',
            'email.email' => 'Поле должно быть корректным почтовым адресом.',
        ];
    }
}

/*public function rules()
{
    return [
        'id_directorate' => 'exists:directorates,id',
        'id_filial' => 'exists:filials,id',
        'id_city' => 'exists:cities,id',
        'id_office' => 'exists:offices,id',
        'started_at' => 'required|date_format:d.m.Y H:i',
        'id_source' => 'required|min:1|exists:sources,id',
        'description' => 'required',
        'incident' => 'digits_between:5,10',
        'finished_at' => 'date_format:d.m.Y H:i|after:started_at',
        'id_service' => 'required|min:1|exists:services,id',
        'id_status' => 'required|min:1|exists:statuses,id',
        'id_cause' => 'exists:causes,id',
    ];
}

public function messages()
{
    return [
        'id_directorate.exists' => 'Такой ДИРЕКЦИИ нет в базе',
        'id_filial.exists' => 'Такого ФИЛИАЛА нет в базе',
        'id_city.exists' => 'Такого ГОРОДА нет в базе',
        'id_office.exists' => 'Такого ПОДРАЗДЕЛЕНИЯ нет в базе',
        'started_at.required' => 'Поле ВРЕМЯ СОБЫТИЯ обязательно к заполнению',
        'started_at.date_format' => 'Поле ВРЕМЯ СОБЫТИЯ не соответствует шаблону XX.XX.XXXX XX:XX',
        'id_source.required' => 'Поле ИСТОЧНИК СОБЫТИЯ обязательно к заполнению',
        'id_source.exists' => 'Такого ИСТОЧНИКА СОБЫТИЯ нет в базе',
        'description.required' => 'Поле ОПИСАНИЕ обязательно к заполнению',
        'incident.digits_between' => 'Поле ИНЦИДЕНТ должно содержать от 5 до 10 цифр',
        'finished_at.date_format' => 'Поле ВРЕМЯ ЗАВЕРШЕНИЯ не соответствует шаблону XX.XX.XXXX XX:XX',
        'finished_at.after' => 'Значение поля ВРЕМЯ ЗАВЕРШЕНИЯ должно быть позже значения поля ВРЕМЯ СОБЫТИЯ',
        'id_service.required' => 'Поле СЕРВИС обязательно к заполнению',
        'id_service.exists' => 'Такого СЕРВИСА нет в базе',
        'id_status.required' => 'Поле СТАТУС обязательно к заполнению',
        'id_status.exists' => 'Такой КРИТИЧНОСТИ нет в базе',
        'id_cause.exists' => 'Такой ПРИЧИНЫ нет в базе',
    ];
}*/
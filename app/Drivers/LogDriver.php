<?php

namespace Kopp\Drivers;

use Illuminate\Support\Facades\File;

class LogDriver
{
    // Логирование ошибок
    public static function error($message)
    {
        $message = '[' . strftime('%d.%m.%Y %H:%M') . "] - \r\n" . $message;
        try {
            File::append(config('settings.error_log'), $message);
        } catch (\Exception $e) {

        }
    }

    // Логирование при сохранении проблем
    /*public static function storeTrouble ($subject, $trouble)
    {
        $subject .= ' пользователем ' . Auth::user()->name;
        if(null != $trouble->directorate) {
            $office = $trouble->directorate->name . ' дирекция';
            if (null != $trouble->filial) {
                $office .=  '|' . $trouble->filial->name . ' филиал';
            }
            if (null != $trouble->city) {
                $office .= '|г. ' . $trouble->city->name;
            }
            if (null != $trouble->office) {
                $office .= '|' . $trouble->office->name;
                $office .= '|' . $trouble->office->address;
            }
        } else {
            $office = 'Все дирекции';
        }
        $words = explode(' ', $trouble->user->name);
        $firstLetter = mb_substr($words[1],0,1,"UTF-8");
        $lastLetter = mb_substr($words[2],0,1,"UTF-8");
        $appendString = '[' . strftime('%d.%m.%Y %H:%M') .", $subject] - \r\n"
            . '    Дирекция|Филиал|Город|Подразделение : ' . $office . "\r\n"
            . '    Время события (МСК) : ' . $trouble->started_at . "\r\n"
            . '    Источник события : ' . $trouble->source->name . "\r\n"
            . '    Описание : ' . str_replace("\r\n", "\r\n        ", $trouble->description) . "\r\n"
            . '    Решение : ' . str_replace("\r\n", "\r\n        ", $trouble->action) . "\r\n"
            . '    Инцидент : ' . $trouble->incident . "\r\n"
            . '    Время завершения (МСК) : ' . $trouble->finished_at . "\r\n"
            . '    Сервис : ' . $trouble->service->name . "\r\n"
            . '    Критичность : ' . $trouble->status->name . "\r\n"
            . '    Дежурный : ' . $words[0] . ' ' . $firstLetter . '.' . $lastLetter . '.' . "\r\n";
        try {
            File::append(config('settings.monitoring_log'), $appendString);
        } catch (\Exception $e) {

        }
    }*/
}
<?php

namespace Kopp\Drivers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailDriver
{
    // Отправка письма при сохранении заказа
    public static function storeOrder($subject, $order, $totalCost)
    {
        $mailTo = config('settings.storeOrderSendMailTo');
        // Добавить email заказа, если есть
        if (null != $order->email) {
            $mailTo[] = $order->email;
        }
        $data = [
            'order' => $order,
            'totalCost' => $totalCost,
        ];
        try {
            Mail::send('emails.storeOrder', $data, function ($message) use ($subject, $mailTo) {
                //$message->from('monitoringPortal@binbank.ru', 'Портал мониторинга'); // Адрес отправителя и его псевдоним
                //$message->sender('sergeykopp@binbank.ru', 'Сергей'); // Сергей <sergeykopp@binbank.ru>; от имени; Портал мониторинга <monitoringPortal@binbank.ru>
                $message->to($mailTo); // Кому
                //$message->to(['kopp2@binbank.ru', 'aanikiforov@binbank.ru']); // Кому (несколько)
                //$message->cc('kopp2@binbank.ru'); // Копия
                //$message->bcc('kopp2@binbank.ru'); // Скрытая копия
                $message->subject($subject); // Тема
            });
        } catch (\Exception $e) {
            $message = '    Ошибка при попытке отправки сообщения : ' . $subject . "\r\n";
            $message .= '    $e->getMessage() : ' . $e->getMessage() . "\r\n";
            LogDriver::error($message);
        }
    }
}
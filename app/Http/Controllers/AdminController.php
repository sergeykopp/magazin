<?php

namespace Kopp\Http\Controllers;

use Illuminate\Http\Request;
use Kopp\Drivers\AdminDriver;
use Kopp\Product;

class AdminController extends Controller
{
    protected $data = [];
    protected $template;

    public function __construct()
    {
        $this->template = 'admin.';
        $this->middleware('auth');
    }

    protected function renderOutput()
    {
        return view($this->template)->with($this->data);
    }

    // Резервное копирование базы данных
    public function backup(Request $request)
    {
        if(true === $request->user()->cannot('backup', new Product())){
            return redirect()->route('main')->with('messageAuth', 'У Вас недостаточно прав для администрирования');
        }
        if (session()->has('backup')) {
            session()->forget('backup');
        }
        if (session()->has('error')) {
            session()->forget('error');
        }
        if ($request->isMethod('post')) {
            if ($request->has('export')) {
                $res = AdminDriver::exportToXML();
                if (true === $res) {
                    session(['backup' => 'Экспорт базы данных в файл выполнен!!!']);
                } else {
                    session(['error' => $res]);
                }
            } elseif ($request->has('import')) {
                $res = AdminDriver::importFromXML();
                if (true === $res) {
                    session(['backup' => 'Импорт в базу данных из файла выполнен!!!']);
                } else {
                    session(['error' => $res]);
                }
            }
        }
        $this->data['title'] = 'Резервное копирование';
        $this->template .= 'backup';
        return $this->renderOutput();
    }
}

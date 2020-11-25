<?php

namespace Kopp\Http\Controllers;

use Kopp\Category;

class ClientController extends Controller
{
    protected $data = [];
    protected $template;

    public function __construct()
    {
        $this->template = 'client.';
        $this->data['categories'] = Category::where('category_id', 0)->get();
    }

    protected function renderOutput()
    {
        return view($this->template)->with($this->data);
    }
}

<?php

namespace Kopp\Http\Controllers;

use Illuminate\Http\Request;
use Kopp\Drivers\ProductDriver;
use Kopp\Category;
use Kopp\Http\Requests\StoreOrderRequest;

class ProductController extends ClientController
{
    // Главная страница
    public function index()
    {
        $this->data['files'] = ProductDriver::carousel();
        $this->data['title'] = 'Масштабные модели';
        $this->template .= 'main';
        return $this->renderOutput();
    }

    // Страница товаров по категории
    public function category(Request $request, $categoryId = null)
    {
        if (null == $categoryId) {
            return redirect()->route('main');
        }
        $parameters = $request->all();
        // Если вошли методом GET
        if ($request->isMethod('get')) {
            if (session()->has('paginationQuantity')) {
                $parameters['paginationQuantity'] = session()->get('paginationQuantity');
            } else {
                session(['paginationQuantity' => 5]);
                $parameters['paginationQuantity'] = 5;
            }
            if (session()->has('paginationSorting')) {
                $parameters['paginationSorting'] = session()->get('paginationSorting');
            } else {
                session(['paginationSorting' => 'name']);
                $parameters['paginationSorting'] = 'name';
            }
            if (session()->has('paginationDirection')) {
                $parameters['paginationDirection'] = session()->get('paginationDirection');
            } else {
                session(['paginationDirection' => 'up']);
                $parameters['paginationDirection'] = 'up';
            }
        // Если вошли методом POST
        } else {
            if ($request->has('paginationQuantity')) {
                if (session()->get('paginationQuantity') != $parameters['paginationQuantity']) {
                    session(['paginationQuantity' => $parameters['paginationQuantity']]);
                }
            } else {
                $parameters['paginationQuantity'] = session()->get('paginationQuantity');
            }
            if ($request->has('paginationSorting')) {
                if (session()->get('paginationSorting') != $parameters['paginationSorting']) {
                    session(['paginationSorting' => $parameters['paginationSorting']]);
                }
            } else {
                $parameters['paginationSorting'] = session()->get('paginationSorting');
            }
            if ($request->has('paginationDirection')) {
                if (session()->get('paginationDirection') != $parameters['paginationDirection']) {
                    session(['paginationDirection' => $parameters['paginationDirection']]);
                }
            } else {
                $parameters['paginationDirection'] = session()->get('paginationDirection');
            }
        }
        // Если не был передан параметр текущей страницы
        if (!$request->has('currentPage')) {
            $parameters['currentPage'] = 1;
        }
        $result = ProductDriver::productsByCategory($categoryId, $parameters);
        if (false === $result) {
            return redirect()->route('main');
        }
        $this->data['products'] = $result['products'];
        $this->data['quantityPages'] = $result['quantityPages'];
        $this->data['currentPage'] = $result['currentPage'];
        $this->data['limitPages'] = $result['limitPages'];
        $this->data['paginationQuantity'] = $parameters['paginationQuantity'];
        $this->data['paginationSorting'] = $parameters['paginationSorting'];
        $this->data['paginationDirection'] = $parameters['paginationDirection'];
        $this->data['title'] = Category::find($categoryId)->name;
        $this->template .= 'category';
        return $this->renderOutput();
    }

    // Страница отдельного товара
    public function product($productId = null)
    {
        if (null == $productId) {
            return redirect()->route('main');
        }
        $this->data['product'] = ProductDriver::product($productId);
        if (false === $this->data['product']) {
            return redirect()->route('main');
        }
        $this->data['title'] = $this->data['product']->name;
        $this->template .= 'product';
        return $this->renderOutput();
    }

    // Страница поиска товаров по ключевым словам
    public function searchPhrase(Request $request)
    {
        if ($request->has('searchPhrase')) {
            $searchPhrase = $request->input('searchPhrase');
        } else {
            return redirect()->route('main');
        }
        $this->data['products'] = ProductDriver::searchPhrase($searchPhrase);
        $this->data['searchPhrase'] = $searchPhrase;
        $this->data['title'] = 'Поиск: ' . $searchPhrase;
        $this->template .= 'searchPhrase';
        return $this->renderOutput();
    }

    // Страница состояния корзины
    public function cart()
    {
        $cart = ProductDriver::cart();
        $this->data['products'] = $cart['products'];
        $this->data['totalCost'] = $cart['totalCost'];
        $this->data['totalQuantity'] = $cart['totalQuantity'];
        $this->data['title'] = 'Корзина';
        $this->template .= 'cart';
        return $this->renderOutput();
    }

    // Страница оформления заказа
    public function viewOrder()
    {
        if (0 == ProductDriver::cart()['totalQuantity']) {
            return redirect()->route('main');
        }
        $this->data['title'] = 'Оформление заказа';
        $this->template .= 'order';
        return $this->renderOutput();
    }

    // Сохранение заказа
    public function storeOrder(StoreOrderRequest $request)
    {
        if (0 == ProductDriver::cart()['totalQuantity']) {
            return redirect()->route('main');
        }
        $orderNumber = time();
        ProductDriver::orderSave($request, $orderNumber);
        $this->data['phone'] = $request->get('phone');
        $this->data['address'] = $request->get('address');
        $this->data['orderNumber'] = $orderNumber;
        $this->data['title'] = 'Заказ оформлен';
        $this->template .= 'storeOrder';
        return $this->renderOutput();
    }
}

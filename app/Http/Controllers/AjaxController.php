<?php

namespace Kopp\Http\Controllers;

use Illuminate\Http\Request;
use Kopp\Drivers\CartDriver;
use Kopp\Drivers\ProductDriver;

class AjaxController extends Controller
{
    // Запрос списка фраз по ключевым словам
    public function searchPhrase(Request $request)
    {
        $response = '';
        if ($request->has('searchPhrase')) {
            $response = ProductDriver::getListForAjaxSearchPhrase($request->input('searchPhrase'));
        }
        return $response;
    }

    // Запрос корзины
    public function cart(Request $request)
    {
        if ($request->has('productId') and '' != $request->input('productId')) {
            // Если такой продукт уже есть в корзине, то перенаправляем на страницу корзины
            if (true === CartDriver::productIsInCart($request->input('productId'))) {
                return 'redirectToCart';
            // Иначе добавляем продукт в корзину
            } else {
                CartDriver::addProductToCartForAjax($request->input('productId'));
            }
        }
        return CartDriver::getCartContentForAjax();
    }

    // Запрос изменения корзины
    public function changeCart(Request $request)
    {
        return CartDriver::changeProductsInCart($request->input('productId'), $request->input('ext'));
    }

    // Запрос изменения постраничной навигации
    public function pagination(Request $request)
    {
        if ($request->has('obj') and $request->has('value')) {
            session([$request->input('obj') => $request->input('value')]);
        }
        return 'done';
    }
}
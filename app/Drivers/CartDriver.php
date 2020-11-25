<?php

namespace Kopp\Drivers;

use Kopp\Product;

class CartDriver
{
    // Получение содержимого корзины для ajax-запросов
    public static function getCartContentForAjax()
    {
        $response = '';
        if (session()->has('cart')) {
            $sessionProducts = json_decode(session()->get('cart'), true);
            $totalQuantity = 0;
            $totalCost = 0;
            foreach ($sessionProducts as $sessionProduct) {
                $totalCost += $sessionProduct['price']*$sessionProduct['quantity'];
                $totalQuantity += $sessionProduct['quantity'];
            }
            $response = json_encode([
                'totalQuantity' => $totalQuantity,
                'totalCost' => $totalCost,
            ]);
        }
        return $response;
    }

    // Добавление продукта в корзину для ajax-запросов
    public static function addProductToCartForAjax($productId)
    {
        $product = Product::select('id', 'price', 'discount')
            ->where('id', $productId)
            ->first();
        if (null != $product) {
            if(0 != $product->discount) {
                $product->price = floor(($product->price*(0.1-$product->discount/1000)))*10;
            }
            // Если сессия есть
            if (session()->has('cart')) {
                $sessionProducts = json_decode(session()->get('cart'), true);
                foreach ($sessionProducts as $sessionProduct) {
                    // Если в сессии есть такой продукт, то переходим в корзину
                    if ($sessionProduct['id'] == $product->id) {
                        return 'redirectToCart';
                    }
                }
                // Если в сессии нет такого продукта, то добавляем его
                $sessionProduct = [
                    'id' => $product->id,
                    'price' => $product->price,
                    'quantity' => 1
                ];
                array_push($sessionProducts, $sessionProduct);
                // Перезапись сессии
                session(['cart' => json_encode($sessionProducts)]);
            } else { // Если сессии нет
                $sessionProducts = [];
                $sessionProduct = [
                    'id' => $product->id,
                    'price' => $product->price,
                    'quantity' => 1
                ];
                array_push($sessionProducts, $sessionProduct);
                // Запись сессии
                session(['cart' => json_encode($sessionProducts)]);
            }
        }
    }

    // Проверка присутствия продукта в корзине
    public static function productIsInCart($productId)
    {
        if (session()->has('cart')) {
            $product = Product::select('id')
                ->where('id', $productId)
                ->first();
            $sessionProducts = json_decode(session()->get('cart'), true);
            foreach ($sessionProducts as $sessionProduct) {
                // Если в сессии есть такой продукт, то переходим в корзину
                if ($sessionProduct['id'] == $product->id) {
                    return true;
                }
            }
        }
        return false;
    }

    // Получение содержимого корзины
    public static function getCartContent()
    {
        $sessionProducts = [];
        if (session()->has('cart')) {
            $sessionProducts = json_decode(session()->get('cart'), true);
        }
        return $sessionProducts;
    }

    // Изменение продуктов в корзине
    public static function changeProductsInCart($productId, $ext)
    {
        $productQuantity = 0;
        $productCost = 0;
        $sessionProducts = json_decode(session()->get('cart'), true);
        foreach ($sessionProducts as $key => $sessionProduct) {
            if ($sessionProduct['id'] == $productId) {
                switch($ext) {
                    case 'inc': $sessionProducts[$key]['quantity']++;
                                $productQuantity = $sessionProducts[$key]['quantity'];
                                $productCost =  $sessionProducts[$key]['price']*$sessionProducts[$key]['quantity'];
                                break;
                    case 'dec': $sessionProducts[$key]['quantity']--;
                                $productQuantity = $sessionProducts[$key]['quantity'];
                                $productCost =  $sessionProducts[$key]['price']*$sessionProducts[$key]['quantity'];
                                if(0 == $sessionProducts[$key]['quantity']) {
                                    unset($sessionProducts[$key]);
                                    $productQuantity = 0;
                                }
                                break;
                    case 'del': unset($sessionProducts[$key]);
                                $productQuantity = 0;
                                break;
                    case 0:     unset($sessionProducts[$key]);
                                $productQuantity = 0;
                                break;
                    default:    $sessionProducts[$key]['quantity'] = $ext;
                                $productQuantity = $ext;
                                $productCost =  $sessionProducts[$key]['price']*$sessionProducts[$key]['quantity'];
                                break;
                }
                break;
            }
        }
        if(0 < count($sessionProducts)){
            session(['cart' => json_encode($sessionProducts)]);
            $totalQuantity = 0;
            $totalCost = 0;
            foreach ($sessionProducts as $sessionProduct) {
                $totalCost += $sessionProduct['price']*$sessionProduct['quantity'];
                $totalQuantity += $sessionProduct['quantity'];
            }
            $response =  json_encode([
                'totalCost' => $totalCost,
                'totalQuantity' => $totalQuantity,
                'productId' => $productId,
                'productQuantity' => $productQuantity,
                'productCost' => $productCost,
            ]);
            return $response;
        } else {
            session()->forget('cart');
            return 'empty';
        }
    }

    // Очистка корзины
    public static function clearCart()
    {
        session()->forget('cart');
    }
}
/*session()->has('cart')*/
/*session()->get('cart')*/
/*session(['cart' => 5]);*/
/*session()->forget('cart');*/
/*array_push($array, $data);*/
/*unset($array[$i]);*/
<?php

namespace Kopp\Drivers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Kopp\Category;
use Kopp\Order;
use Kopp\OrderProduct;
use Kopp\Product;

class ProductDriver
{
    // Товары по категории
    public static function productsByCategory($categoryId = null, $parameters)
    {
        $category = Category::find($categoryId);
        // Если такой категории нет либо это корневая категория - возврат на главную
        if (null == $category or 0 == $category->category_id) {
            return false;
        }
        $query = Product::select('id', 'name', 'artikul', 'price', 'discount', 'brand_id')
            ->where('category_id', $categoryId)
            ->where('actual', true)
            ->with('brand')
            ->limit($parameters['paginationQuantity']);
        if ('up' == $parameters['paginationDirection']){
            $query->orderBy($parameters['paginationSorting'], 'asc');
        } elseif ('down' == $parameters['paginationDirection']) {
            $query->orderBy($parameters['paginationSorting'], 'desc');
        }
        $quantityProducts = Product::where('category_id', $categoryId)->count();
        $quantityPages = (int)($quantityProducts / $parameters['paginationQuantity']);
        if ($quantityPages != $quantityProducts / $parameters['paginationQuantity']) {
            $quantityPages++;
        }
        $firstProduct = ($parameters['currentPage'] - 1) * $parameters['paginationQuantity'];
        // Защита от дурака при возможном событии - текущая страница больше общего количества страниц
        if ($parameters['currentPage'] > $quantityPages) {
            $parameters['currentPage'] = 1;
            $firstProduct = ($parameters['currentPage'] - 1) * $parameters['paginationQuantity'];
        }
        $query->offset($firstProduct);
        $products = $query->get();
        return [
            'products' => $products,
            'quantityPages' => $quantityPages,
            'currentPage' => $parameters['currentPage'],
            'limitPages' => self::getLimitPages($parameters['currentPage'], $quantityPages),
        ];
    }

    // Ограничение списка ссылок страниц для постраничной навигации
    private static function getLimitPages($currentPage, $countPages)
    {
        // Ограничение количества ссылок c каждой стороны от текущей
        $limit = config('settings.navigation_limit_pages');
        // Вычисление первой и последней ссылок
        $firstPage = $currentPage - $limit;
        $lastPage = $currentPage + $limit;
        if ($firstPage < 1) {
            $firstPage = 1;
        }
        if ($lastPage > $countPages) {
            $lastPage = $countPages;
        }
        $countLinks = ($limit * 2) - ($lastPage - $firstPage);
        // Добавление ссылок с одной из сторон, если другая сторона достигла предела
        if (0 != $countLinks) {
            if (1 == $firstPage) {
                $lastPage += $countLinks;
                if ($lastPage > $countPages) {
                    $lastPage = $countPages;
                }
            } elseif ($lastPage == $countPages) {
                $firstPage -= $countLinks;
                if ($firstPage < 1) {
                    $firstPage = 1;
                }
            }
        }
        // Помещаем значения в массив
        $limitPages['firstPage'] = $firstPage;
        $limitPages['lastPage'] = $lastPage;
        // И возвращаем массив
        return $limitPages;
    }

    // Товар
    public static function product($productId = null)
    {
        if (null == $productId) {
            return false;
        }
        $product = Product::select('id', 'name', 'artikul', 'description', 'price', 'discount', 'category_id', 'brand_id')
            ->where('id', $productId)
            ->with('category', 'brand')
            ->first();
        if (null == $product) {
            return false;
        }
        $product->description = mb_ereg_replace('\r\n', '<br />', $product->description);
        $files = File::files(iconv('utf-8', 'cp1251', public_path() . '/instructions/' . $product->brand->name));
        $instructions = [];
        foreach($files as $file) {
            if(false !== (strpos($file->getFileName(), $product->artikul))) {
                $instructions[] = $file->getFileName();
            }
        }
        $product->instructions = $instructions;
        return $product;
    }

    // Ограничение сообщения
    private static function shortMessage($message)
    {
        if (mb_strlen($message, "UTF-8") > config('settings.short_message')) {
            $message = mb_substr($message, 0, config('settings.short_message'), "UTF-8");
            $message .= ' ...';
        }
        $message = mb_ereg_replace('\r\n', '<br />', $message);
        return $message;
    }

    // Получение списка изображений для карусели
    public static function carousel()
    {
        $files = File::files(public_path() . '/images/products/carousel');
        if (0 == count($files)) {
            return false;
        }
        foreach($files as $key => $file) {
            $files[$key] = $file->getFileName();
        }
        return $files;
    }

    // Поиск товаров по ключевым словам
    public static function searchPhrase($searchPhrase = null)
    {
        if (null == $searchPhrase) {
            return [];
        }
        if ('' != $searchPhrase) {
            $searchPhrase = preg_replace('/([^ \(\)\[\]\.\/,=:№@a-zа-яё0-9-])/iu', '\\\${1}', $searchPhrase); // Экранируем спец. символы
            $queryName = Product::select('id', 'name', 'artikul', 'price', 'discount', 'brand_id')
                ->where('name', 'like', "%$searchPhrase%");
            $queryArtikul = Product::select('id', 'name', 'artikul', 'price', 'discount', 'brand_id')
                ->where('artikul', 'like', "%$searchPhrase%");
            $products = $queryName
                ->union($queryArtikul)
                ->where('actual', true)
                ->with('brand')
                ->get();
            return $products;
        }
        return [];
    }

    // Составление списка фраз для ajax_запросов по ключевым словам
    public static function getListForAjaxSearchPhrase($searchPhrase = null)
    {
        $response = '';
        if ('' != $searchPhrase) {
            $searchPhrase = preg_replace('/([^ \(\)\[\]\.\/,=:№@a-zа-яё0-9-])/iu', '\\\${1}', $searchPhrase); // Экранируем спец. символы
            $queryName = Product::select('name')
                ->where('name', 'like', "%$searchPhrase%");
            $queryArtikul = Product::select('artikul')
                ->where('artikul', 'like', "%$searchPhrase%");
            $products = $queryName
                ->union($queryArtikul)
                ->where('actual', true)
                ->get();
            // Ищем похожие варианты
            $arr = [];
            $searchPhrase = preg_replace("/\(/u", "\(", $searchPhrase);
            $searchPhrase = preg_replace("/\)/u", "\)", $searchPhrase);
            $searchPhrase = preg_replace("/\[/u", "\[", $searchPhrase);
            $searchPhrase = preg_replace("/\]/u", "\]", $searchPhrase);
            $searchPhrase = preg_replace("/\./u", "\.", $searchPhrase);
            $searchPhrase = preg_replace("/\//u", "\/", $searchPhrase);
            foreach ($products as $product) {
                preg_match_all('/[\w\d-]*' . $searchPhrase . '[\w\d-]*/iu', $product->name, $words1, PREG_PATTERN_ORDER);
                //preg_match('/[\w\d]*' . $searchPhrase . '[\w\d]*/iu', $product->description, $words2);
                // Добавляем только новые, которых ещё нет в массиве
                foreach ($words1[0] as $word) {
                    if (1 == mb_strlen($word, "UTF-8")) {
                        continue;
                    }
                    $word = mb_strtoupper($word, 'utf-8');
                    if (!in_array($word, $arr)) {
                        $arr[] = $word;
                    }
                }
                /*foreach ($words2[0] as $word) {
                    if (1 == mb_strlen($word, "UTF-8")) {
                        continue;
                    }
                    $word = mb_strtoupper($word, 'utf-8');
                    if (!in_array($word, $arr)) {
                        $arr[] = $word;
                    }
                }*/
            }
            // Если более 30 вариантов, то отбираем только те, которые начинаются с ключевой фразы
            if (30 < count($arr)) {
                $searchPhrase = mb_strtoupper($searchPhrase, 'utf-8');
                $newArr = [];
                foreach ($arr as $value) {
                    if (0 === strpos($value, $searchPhrase)) {
                        $newArr[] = $value;
                    }
                }
                $arr = $newArr;
            }
            // Выводим не более 30 вариантов
            if (30 >= count($arr) and 0 < count($arr)) {
                asort($arr);
                $onmouseover = "clearStyleSearchPhraseList(); this.style.backgroundColor = '#149280'; this.style.color = 'white';";
                $onmouseout = "clearStyleSearchPhraseList();";
                $onclick = 'document.search.searchPhrase.value = this.firstChild.nodeValue; document.search.submit();';
                foreach ($arr as $value) {
                    $response .= '<span style="color: #149280" onmouseover="' . $onmouseover .'" onmouseout="' . $onmouseout . '" onclick="' . $onclick . '">' . $value . '</span><br />';
                }
            }
        }
        return $response;
    }

    // Получение товаров в корзине
    public static function cart()
    {
        $cartProducts = CartDriver::getCartContent();
        $products = [];
        $totalCost = 0;
        $totalQuantity = 0;
        foreach($cartProducts as $cartProduct) {
            $product = Product::select('id', 'name', 'artikul', 'brand_id')
                ->where('id', $cartProduct['id'])
                ->with('brand')
                ->first();
            $product->price = $cartProduct['price'];
            $product->quantity = $cartProduct['quantity'];
            $totalCost += $product->price*$product->quantity;
            $totalQuantity += $product->quantity;
            $products[] = $product;
        }
        $response['totalCost'] = $totalCost;
        $response['totalQuantity'] = $totalQuantity;
        $response['products'] = $products;
        return $response;
    }

    // Сохранение заказа
    public static function orderSave($request, $orderNumber)
    {
        $order = new Order();
        $order->number = $orderNumber;
        $order->phone = $request->get('phone');
        $order->address = $request->get('address');
        if ($request->has('email')) {
            $order->email = $request->get('email');
        }
        if ($request->has('name')) {
            $order->name = $request->get('name');
        }
        $date = new \DateTime(null, new \DateTimeZone(config('app.timezone')));
        $order->created_at = $date->format("Y-m-d H:i:00");
        if (false == Auth::guest()) {
            $order->user_id = Auth::user()->id;
        }
        $order->save();
        $products = ProductDriver::cart()['products'];
        $totalCost = 0;
        foreach($products as $product) {
            $orderProduct = new OrderProduct();
            $orderProduct->product_id = $product['id'];
            $orderProduct->price = $product['price'];
            $orderProduct->quantity = $product['quantity'];
            $totalCost += $orderProduct->price*$orderProduct->quantity;
            $order->products()->save($orderProduct);
        }
        CartDriver::clearCart();
        MailDriver::storeOrder("Сформирован новый заказ №" . $orderNumber, $order, $totalCost);
    }
}
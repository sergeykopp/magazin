// ajax-запрос корзины
function cart(productId) {
    if(undefined == productId) {
        productId = '';
    }
    requestCart.onreadystatechange = function () {
        // Если запрос ещё не готов
        if (4 != requestCart.readyState)
            return;
        // Если запрос был отменён
        if (0 == requestCart.status)
            return;
        // Если запрос не успешен
        if (200 != requestCart.status) {
            alert("Ошибка запроса " + requestCart.status + " : " + requestCart.statusText);
            return;
        }
        // Если запрос не пуст
        if ('' != requestCart.responseText) {
            if ('redirectToCart' == requestCart.responseText) {
                window.location.assign('/cart');
            } else {
                fieldCartButton.style.display = 'inline-block';
                cartButtonName.style.display = 'none';
                var obj = JSON.parse(requestCart.responseText);
                cartButtonTotalQuantity.innerHTML = obj.totalQuantity;
                cartButtonTotalCost.innerHTML = obj.totalCost;
            }
        }
        // Если запрос пуст
        else {
            fieldCartButton.style.display = 'none';
            cartButtonName.style.display = 'inline-block';
        }
    };
    requestCart.open("POST", "/ajax/cart", true);
    requestCart.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // Эмуляция отправки формы для заполнения массива POST
    requestCart.send("_token=" + token.value + "&productId=" + productId); // Параметры отправки
}

// Отмена запроса
function abortAjaxCart() {
    requestCart.abort();
}

// ajax-запрос изменения корзины
function changeCart(productId, ext) {
    if(undefined == productId) {
        productId = '';
    }
    if(undefined == ext) {
        ext = '';
    }
    requestChangeCart.onreadystatechange = function () {
        // Если запрос ещё не готов
        if (4 != requestChangeCart.readyState)
            return;
        // Если запрос был отменён
        if (0 == requestChangeCart.status)
            return;
        // Если запрос не успешен
        if (200 != requestChangeCart.status) {
            alert("Ошибка запроса " + requestChangeCart.status + " : " + requestChangeCart.statusText);
            return;
        }
        // Если запрос не пуст
        if ('' != requestChangeCart.responseText) {
            if ('empty' == requestChangeCart.responseText) {
                window.location.replace('/cart');
            } else {
                var obj = JSON.parse(requestChangeCart.responseText);
                cartButtonTotalQuantity.innerHTML = obj.totalQuantity;
                cartButtonTotalCost.innerHTML = obj.totalCost;
                document.getElementById('panelTotalCost').firstChild.nodeValue = obj.totalCost;
                document.getElementById('panelTotalQuantity').firstChild.nodeValue = obj.totalQuantity;
                var products = document.getElementsByClassName('cartProductQuantity');
                for (var i=0; i<products.length; i++) {
                    if (obj.productId == products[i].parentNode.getAttribute('productId')) {
                        if (0 == obj.productQuantity) {
                            products[i].parentNode.parentNode.parentNode.style.display = 'none';
                        } else{
                            products[i].value = obj.productQuantity;
                            products[i].parentNode.getElementsByClassName('price')[0].firstChild.nodeValue = obj.productCost;
                        }
                    }
                }
            }
        }
        // Если запрос пуст
        else {

        }
    };
    requestChangeCart.open("POST", "/ajax/changeCart", false);
    requestChangeCart.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // Эмуляция отправки формы для заполнения массива POST
    requestChangeCart.send("_token=" + token.value + "&productId=" + productId + "&ext=" + ext); // Параметры отправки
}

// Отмена запроса
function abortAjaxChangeCart() {
    requestChangeCart.abort();
}
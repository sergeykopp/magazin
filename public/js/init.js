var token,
    formSearchPhrase,
    searchPhrase,
    phraseList,
    requestSearchPhrase,
    fieldCartButton,
    cartButtonTotalCost,
    cartButtonTotalQuantity,
    cartButtonName,
    requestCart,
    requestChangeCart,
    timerChangeQuantity;

try {
    window.addEventListener('load', init, false); // Добавление события для W3C
} catch (e) {
    window.attachEvent('onload', init); // Добавление события для IE
}

// Инициализация при загрузке страницы
function init() {
    token = document.getElementsByName('_token')[0];
    formSearchPhrase = document.getElementsByName('search')[0];
    searchPhrase = document.getElementsByName('searchPhrase')[0];
    phraseList = document.getElementById("phraseList");
    requestSearchPhrase = getXmlHttpRequest();
    fieldCartButton = document.getElementById("fieldCartButton");
    cartButtonTotalCost = document.getElementById("cartButtonTotalCost");
    cartButtonTotalQuantity = document.getElementById("cartButtonTotalQuantity");
    cartButtonName = document.getElementById("cartButtonName");
    requestCart = getXmlHttpRequest();
    requestChangeCart = getXmlHttpRequest();

    // Запрос состояния корзины
    cart();

    // Добавление событий для документа
    try{
        window.document.addEventListener('keyup', documentKeyUp, false); // Добавление события для W3C
        window.document.addEventListener('click', documentMouseClick, false); // Добавление события для W3C
    } catch(e){
        window.document.attachEvent('onkeyup', documentKeyUp); // Добавление события для IE
        window.document.attachEvent('onclick', documentMouseClick); // Добавление события для IE
    }

    // Добавление событий для поля ввода поисковой фразы
    try {
        searchPhrase.addEventListener('keyup', inputSearchKeyUp, false); // Добавление события для W3C
    } catch (e) {
        searchPhrase.attachEvent('onkeyup', inputSearchKeyUp); // Добавление события для IE
    }

    // Добавление событий для кнопок купить
    var buttonsBuy = document.getElementsByClassName('buy');
    for(var i=0; i < buttonsBuy.length; i++) {
        try {
            buttonsBuy[i].addEventListener('click', buyClick, false); // Добавление события для W3C
        } catch (e) {
            buttonsBuy[i].attachEvent('onclick', buyClick); // Добавление события для IE
        }
    }

    // Добавление событий для кнопок увеличить количество продукта
    var buttonsIncrement = document.getElementsByClassName('glyphicon-plus');
    for(var i=0; i < buttonsIncrement.length; i++) {
        try {
            buttonsIncrement[i].addEventListener('click', incrementClick, false); // Добавление события для W3C
        } catch (e) {
            buttonsIncrement[i].attachEvent('onclick', incrementClick); // Добавление события для IE
        }
    }

    // Добавление событий для кнопок уменьшить количество продукта
    var buttonsDecrement = document.getElementsByClassName('glyphicon-minus');
    for(var i=0; i < buttonsDecrement.length; i++) {
        try {
            buttonsDecrement[i].addEventListener('click', decrementClick, false); // Добавление события для W3C
        } catch (e) {
            buttonsDecrement[i].attachEvent('onclick', decrementClick); // Добавление события для IE
        }
    }

    // Добавление событий для полей количества продукта
    var fieldsQuantity = document.getElementsByClassName('cartProductQuantity');
    for(var i=0; i < fieldsQuantity.length; i++) {
        try {
            fieldsQuantity[i].addEventListener('keyup', quantityChange, false); // Добавление события для W3C
        } catch (e) {
            fieldsQuantity[i].attachEvent('onkeyup', quantityChange); // Добавление события для IE
        }
    }

    // Добавление событий для ссылок удаления продукта
    var fieldsDelete = document.getElementsByClassName('cartProductDelete');
    for(var i=0; i < fieldsDelete.length; i++) {
        try {
            fieldsDelete[i].addEventListener('click', deleteClick, false); // Добавление события для W3C
        } catch (e) {
            fieldsDelete[i].attachEvent('onclick', deleteClick); // Добавление события для IE
        }
    }
}

// Обработка событий мыши из документа
function documentMouseClick() {
    phraseList.style.display = 'none';
}

// Обработка событий клавиш из документа
function documentKeyUp(e) {
    e = e || window.event;
    var code = e.keyCode;
    switch (code) {
        case 13:
            searchPhrase.focus();	// Фокусировка
            searchPhrase.select(); // и выделение текста в поле поиска
            break;

        case 27:
            //window.location.assign('/');
            break;

        default:
            break;
    }
}

// Обработка событий клавиш из поля фразы поиска
function inputSearchKeyUp(e) {
    e = e || window.event;
    var code = e.keyCode;
    preventDefault(e);
    stopPropagation(e);
    switch (code) {
        case 13:
            abortAjaxSearchPhrase();
            formSearchPhrase.submit();
            break;

        case 27:
            searchPhrase.value = '';
            phraseList.innerHTML = '';
            phraseList.style.display = 'none';
            //window.location.assign('/');
            break;

        case 38:
            movingSearchPhraseList('up');
            break;

        case 40:
            movingSearchPhraseList('down');
            break;

        default:
            abortAjaxSearchPhrase();
            ajaxSearchPhrase(searchPhrase.value);
            break;
    }
}

// Обработка событий мыши для кнопок Купить
function buyClick(e) {
    e = e || window.event;
    abortAjaxCart();
    var element = e.target || e.srcElement;
    cart(element.getAttribute('productId'));
}

// Обработка событий мыши для кнопок Увеличить количество продукта
function incrementClick(e) {
    e = e || window.event;
    abortAjaxChangeCart();
    var element = e.target || e.srcElement;
    changeCart(element.parentNode.getAttribute('productId'), 'inc');
}

// Обработка событий мыши для кнопок Уменьшить количество продукта
function decrementClick(e) {
    e = e || window.event;
    abortAjaxChangeCart();
    var element = e.target || e.srcElement;
    changeCart(element.parentNode.getAttribute('productId'), 'dec');
}

// Обработка событий для полей изменения количества продукта
function quantityChange(e) {
    clearTimeout(timerChangeQuantity);
    abortAjaxChangeCart();
    e = e || window.event;
    var element = e.target || e.srcElement;
    var regExp = /[^\d]/g; // Удаление всего, кроме цифр
    var value = element.value.replace(regExp, '');
    var inputs = document.getElementsByClassName('cartProductQuantity');
    var pluses = document.getElementsByClassName('glyphicon-plus');
    var minuses = document.getElementsByClassName('glyphicon-minus');
    // Блокировка всех input, кроме текущего, на время внесения информации
    for (var i=0; i<inputs.length; i++) {
        if (inputs[i] != element) {
            inputs[i].setAttribute('disabled', 'disabled');
        }
    }
    // Блокировка всех плюсов
    for (var i=0; i<pluses.length; i++) {
        pluses[i].style.display = 'none';
    }
    // Блокировка всех минусов
    for (var i=0; i<minuses.length; i++) {
        minuses[i].style.display = 'none';
    }
    if ('' != value) {
        // Задержка для внесения изменений
        timerChangeQuantity = setTimeout(function () {
            changeCart(element.parentNode.getAttribute('productId'), value);
            // Разблокировка всех input, кроме текущего, на время внесения информации
            for (var i=0; i<inputs.length; i++) {
                if (inputs[i] != element) {
                    inputs[i].removeAttribute('disabled');
                }
            }
            // Разблокировка всех плюсов
            for (var i=0; i<pluses.length; i++) {
                pluses[i].removeAttribute('style');
            }
            // Разблокировка всех минусов
            for (var i=0; i<minuses.length; i++) {
                minuses[i].removeAttribute('style');
            }
        }, 1000);
    }
}

// Обработка событий мыши для ссылок удаления продукта
function deleteClick(e) {
    e = e || window.event;
    abortAjaxChangeCart();
    var element = e.target || e.srcElement;
    changeCart(element.parentNode.getAttribute('productId'), 'del');
}

// Отмена всплытия события
function stopPropagation(e) {
    try {
        e.stopPropagation(); // Отмена всплытия события W3C
    } catch (x) {
        event.cancelBubble = true; // Отмена всплытия события IE
    }
}

// Запрет действия браузера по умолчанию
function preventDefault(e) {
    try {
        e.preventDefault(); // Запрещаем действие браузера по умолчанию W3C
    } catch (x) {
        e.returnValue = false;  // Запрещаем действие браузера по умолчанию IE
    }
}
// ajax-запрос для поиска фразы
function ajaxSearchPhrase(phrase) {
    var phraseList = document.getElementById("phraseList");
    if('' != phrase) {
        var fieldSearch = document.getElementById('fieldSearch');
        phraseList.style.top = fieldSearch.offsetHeight + 'px';
        requestSearchPhrase.onreadystatechange = function () {
            // Если запрос ещё не готов
            if (4 != requestSearchPhrase.readyState)
                return;
            // Если запрос был отменён
            if (0 == requestSearchPhrase.status)
                return;
            // Если запрос не успешен
            if (200 != requestSearchPhrase.status) {
                alert("Ошибка запроса " + requestSearchPhrase.status + " : " + requestSearchPhrase.statusText);
                return;
            }
            // Если запрос не пуст
            if ('' != requestSearchPhrase.responseText) {
                phraseList.style.display = 'block';
                phraseList.innerHTML = requestSearchPhrase.responseText;
            }
            // Если запрос пуст
            else {
                phraseList.style.display = 'none';
            }
        };
        requestSearchPhrase.open("POST", "/ajax/searchPhrase", true);
        requestSearchPhrase.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // Эмуляция отправки формы для заполнения массива POST
        requestSearchPhrase.send("_token=" + token.value + "&searchPhrase=" + phrase); // Параметры отправки
    } else {
        phraseList.style.display = 'none';
    }
}

// Отмена запроса
function abortAjaxSearchPhrase() {
    requestSearchPhrase.abort();
}

// Перемещение по списку ajax-запроса
function movingSearchPhraseList(direction) {
    var phraseList = document.getElementById("phraseList");
    var spans = phraseList.getElementsByTagName('span');
    if (0 < spans.length) {
        var search = document.getElementsByName('searchPhrase')[0];
        var isSelected = false;
        for (var i = 0; i < spans.length; i++) {
            if ('' != spans[i].style.backgroundColor) {
                isSelected = true;
                spans[i].style.backgroundColor = '';
                clearStyleSearchPhraseList();
                if ('up' == direction) {
                    if (0 == i) {
                        spans[spans.length - 1].style.backgroundColor = '#149280';
                        spans[spans.length - 1].style.color = 'white';
                        search.value = spans[spans.length - 1].firstChild.nodeValue;
                    }
                    else {
                        spans[i - 1].style.backgroundColor = '#149280';
                        spans[i - 1].style.color = 'white';
                        search.value = spans[i - 1].firstChild.nodeValue;
                    }
                }
                else if ('down' == direction) {
                    if (i == spans.length - 1) {
                        spans[0].style.backgroundColor = '#149280';
                        spans[0].style.color = 'white';
                        search.value = spans[0].firstChild.nodeValue;
                    }
                    else {
                        spans[i + 1].style.backgroundColor = '#149280';
                        spans[i + 1].style.color = 'white';
                        search.value = spans[i + 1].firstChild.nodeValue;
                    }
                }
                break;
            }
        }
        if (false == isSelected) {
            clearStyleSearchPhraseList();
            if ('up' == direction) {
                spans[spans.length - 1].style.backgroundColor = '#149280';
                spans[spans.length - 1].style.color = 'white';
                search.value = spans[spans.length - 1].firstChild.nodeValue;
            }
            else if ('down' == direction) {
                spans[0].style.backgroundColor = '#149280';
                spans[0].style.color = 'white';
                search.value = spans[0].firstChild.nodeValue;
            }
        }
    }
}

// Очистка стиля списка ajax-запроса
function clearStyleSearchPhraseList() {
    var phraseList = document.getElementById("phraseList");
    var spans = phraseList.getElementsByTagName('span');
    for (var i = 0; i < spans.length; i++) {
        spans[i].style.color = '#149280';
        spans[i].style.backgroundColor = '';
    }
}

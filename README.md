# Парсер синонимов с сайта http://www.wordreference.com

## Описание
Скрипт забирает файл со списком слов (пример: https://raw.githubusercontent.com/dwyl/english-words/master/words.txt). 
Затем парсит страницы с синонимами этих слов с сайта http://www.wordreference.com
Результат сохраняет в формате html в папке files.
Значение указанного тега записывает в MongoDB.
Скрипт использует в своей работе сторонние пакеты:
https://github.com/sunra/php-simple-html-dom-parser (парсинг html)
https://github.com/mongodb/mongo-php-library (адаптер подключения к MongoDB)

## Установка
1. Клонировать проект
    > git clone https://github.com/n-timurka/synonym_parser
2. Загрузить дополнительные пакеты
    > composer install
3. Заполнить конфиг файл config.json
4. Дать права на запись в папку files

## Использование
Запуск из командной строки.
    > php index.php

## Примечание
В базу записываются пакеты по 100 записей, это число можно изменить в конфиге. Отсутствует проверка, есть ли синонимы к каждому слову, соответственно мног опустых записей.
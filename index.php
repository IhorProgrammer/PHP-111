<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    
    <title>PHP_SPD-111</title>

</head>
<body>
    <header>
        <nav class="deep-purple darken-1">
            <div class="nav-wrapper container">
                    <a href="#" class="brand-logo">PHP</a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="basics.php">Основи</a></li>

                        <li><a href="badges.html">Components</a></li>
                        <li><a href="collapsible.html">JavaScript</a></li>
                    </ul>
            </div>
        </nav>
    </header>
    <div class="container">
        <pre>
            PHP 
            Hypertext Preprocessor
            Мова програмування, початково призначена для покращення можливостей
            HTML (змінні, інструкції, вирази, файли/шаблони)
            На сьогодні - повноцінна мова програмування, яка частіше за все
            використовується для задач бекенду.

            За приблизною аналогією з JS, РНР має подвійне розуміння
            - частина (модуль) веб-сервера, яка продовжує оброблення запитів
            - самостійний продукт для виконання програм

            Для встановлення краще за все використати збірку (налаштовані
            між собою веб-сервер, РНР, СУБД та інше). Такими є
            XAMPP, OpenServer, Danver, ...
                                                сайт 1  (index.php)
            веб-запит --> [Apache(веб-сервер)] < .... >  
                                                сайт N  (index.php)
                                                
            веб-сервер приймає запит, розбирає його (виділяє метод, заголовки,
            передані форми, файли тощо) та запускає РНР файл у запитаному сайті
            Те, що виводить РНР, передається сервером як відповідь на запит.
            !! Виведення РНР (як модуля) потрапляє не на "екран", а в тіло HTML

            - Тип мови: інтерпретатор (REPL)
            - 4GL
            - парадигма: процедурна (з підтримкою ООП)
            ==============================================

            Для зручності роботи з кількома проєктами (сайтами) бажано налаштувати
            локальний (віртуальний) хостінг.
            - папка з конфігурацією Apache (conf/extra/)
            - відкриваємо у редакторі httpd-vhosts.conf
            - за зразком, наведеним у конфігурації, створюємо запис для нашого сайту
            - додаємо імена локальних сайтів до локальної DNS 
            = переходимо до C:\Windows\System32\drivers\etc
            = відкриваємо на редагування (адмін) файл hosts
            = додаємо за зразком
                127.0.0.1       spd-111.loc
                ::1             spd-111.loc
                127.0.0.1       www.spd-111.loc
                ::1             www.spd-111.loc
            - зупиняємо та запускаємо Apache з панелі XAMPP
            - мають з'явитись файли .log у папці логів
            - у браузері набираємо http://spd-111.loc  (обовязково з http)

            Д.З. Створити проєкт для виконання ДЗ у вигляді локального
            (віртуального) хосту. Внести відповідні записи у файли 
            конфігурації сервера та DNS
            Надіслати скріншот браузера з адресним рядком
        </pre>
    </div>
</body>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</html>
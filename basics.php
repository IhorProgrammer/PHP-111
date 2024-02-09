<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!--Import Google Icon Font-->
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    
    <title>Основи PHP</title>
</head>
<body>
    <header>
        <nav class="deep-purple darken-1">
            <div class="nav-wrapper container">
                    <a href="#" class="brand-logo">PHP</a> 
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="basics.html">Основи</a></li>

                        <li><a href="badges.html">Components</a></li>
                        <li><a href="collapsible.html">JavaScript</a></li>
                    </ul>
            </div>
        </nav>
    </header>
    <main class="container">
    <h1>Основи РНР</h1>
    <p>
        PHP додає наступну функціональність до HTML
    </p>
    <ul>
        <li>Вирази</li>
        <li>Інструкції</li>
        <li>Управління формуванням HTML</li>
    </ul>
    <p>
        Вирази задаються спеціальними тегами &lt;?= 2 + 3 ?&gt; =
        <?= 2 + 3 ?>
    </p>
    <p>
        Інструкції - блоки коду, який виконується без впливу на HTML
        Є дві форми тегів: повна <?php ?> та скорочена <? ?>
        Повна працює завжди, скорочена - якщо є відповідні налаштування
        у конфігурації сервера. Вживання скороченої форми не рекомендується.
    </p>
    <p>
        Змінні. Оскільки у РНР процедурна парадигма і простори імен не дуже
        поширені, більшість слів є зарезервованою. Щоб не створювати конфлікти
        зі змінними, всі змінні у РНР починаються з знаку $.
        Типізація динамічна (на читання - як у JS)
    </p>
    <?php 
        $x = 30 ;
        $y = "20" ;
    ?>
    <p>
        !!! У РНР розрізняються оператори арифметичного додавання (+)
        та рядкової конкатенації (.)
        x + y = <?= $x + $y ?>,  x . y = <?= $x . $y ?> <br/>
        Ділення дробове, навіть якщо аргументи цілі: x / y = <?= $x / $y ?>
        для одержання цілого значення використовуються функції, наприклад,
        intval( x / y ) = <?= intval( $x / $y ) ?>
    </p>
    <p>
        Управління формуванням HTML - умовна та циклічна верстка.
    </p>
    <?php 
        $arr1 = [1,2,3,4,5] ;   // звичайний масив
        $arr2 = [ 'name2' => 'Petrovich', "age" => 42 ] ;   # асоціативний масив
    ?>
    <?php if( count( $arr1 ) > 10 ) { ?>
        <h3>У масиві більше за 10 елементів</h3>
    <?php } else { ?>
        <h3>У масиві не більше ніж 10 елементів</h3>
    <?php } ?>

    <?php if( isset( $arr2['name'] ) ) : ?>
        <p>Є елемент 'name' = <?= $arr2['name'] ?></p>
    <?php else : ?>
        <b>Елемент 'name' не задано</b>
    <?php endif ?>

    </main>
</body>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</html>
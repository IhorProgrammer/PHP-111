<h1>API та Backend</h1>
<div class="card-panel deep-purple darken-1">
    <button class="btn waves-effect waves-light btn-large blue" onclick="getClick()">
        CREATE
        <i class="material-icons right ">send</i>
    </button>
    <button class="btn waves-effect waves-light btn-large blue darken-2" onclick="postClick()">
        POST
        <i class="material-icons right ">send</i>
    </button>
    <div id="api-result"></div>

    <h2>Робота з БД</h2>
    <p>
        Підготовчі роботи.
        Встановлюємо СУБД (MySQL/MariaDB).
        Створюємо окрему БД для проєкту, користувача для неї.<br/>
        <code>CREATE DATABASE php_spd_111;</code><br/>
        <code>CREATE USER 'spd_111_user'@'localhost' IDENTIFIED BY 'spd_pass';</code><br/>
        Даємо користувачу права на дану БД<br/>
        <code>GRANT ALL PRIVILEGES ON php_spd_111.* TO 'spd_111_user'@'localhost';</code><br/>
        Оновлюємо таблицю доступу<br/>
        <code>FLUSH PRIVILEGES</code><br/>
    </p>
</div>
<script>
    function getClick() {
        fetch("/test")
        .then(r => r.text())
        .then(t=> {
            document.getElementById("api-result").innerText = t;
        })
    }
    function postClick() {
        fetch("/test", {
            method: 'POST'
        })
        .then(r => r.text())
        .then(t=> {
            document.getElementById("api-result").innerText = t;
        })
    }
</script>
<?php

?>

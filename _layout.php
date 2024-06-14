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
    <link rel="stylesheet" href="css/site.css">  
</head>
<body>
    <header>
        <nav class="deep-purple darken-1">
            <div class="nav-wrapper container">
                    <a href="/" class="brand-logo"><img src="img/php.png" alt=""></a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <?php foreach( [ 'basics' => 'Основи', 'layout' => 'Шаблонізація', 'api' => 'API', 'regexp' => "Регулярні вирази"] as $href => $name ) : ?>
                        <li <?= $uri==$href ? 'class="active"' : '' ?> ><a href="<?= $href ?>"><?= $name ?></a></li>
                        <?php endforeach ?>
                        <li data-auth="avatar" class="row">
                            <a href="reg" class="col s6">Реєстрація</a>
                            <a class="modal-trigger col s6" href="#auth_modal">Авторизація</a>
                        </li>
                    </ul>
            </div>
            <ul id="user-dropdown-menu" class="dropdown-content">
                <li><a data-auth="exit">Exit</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <?php include $page_body; ?>
    </div>
    <footer class="page-footer deep-purple darken-1">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">Footer Content</h5>
                    <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Links</h5>
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © 2014 Copyright Text
                <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
        </div>
    </footer>
		
    <!-- Modal Trigger -->
    <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Modal</a>

    <!-- Modal Structure -->
    <div id="auth_modal" class="modal">
        <form id="auth-form" class="col s12">
            <div class="modal-content">
                <h4>Введіть e-mail та пароль для входу</h4>
                <div class="input-field col s6">
                    <i class="material-icons prefix">login</i>
                    <input id="user-input-login" type="text" class="validate" name="login" autocomplete="username">
                    <label for="user-input-login">Login</label>
                </div>
                <div class="input-field col s6">
                    <i class="material-icons prefix">lock</i>
                    <input id="user-input-password" type="password" class="validate" name="password" autocomplete="current-password">
                    <label for="user-input-password">Password</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-close btn-flat grey">Закрити</button>
                <button type="submit" class="modal-close btn-flat deep-purple darken-1" style="margin-left:15px" id="auth-button">Вхід</button>
            </div>
        </form>
    </div>	
</body>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="js/site.js"></script>
</html>
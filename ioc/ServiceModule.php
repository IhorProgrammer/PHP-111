<?php

 class ServiceModule {
    private $services = [];
    private $instances = [];

    // Додаємо сервіс до контейнера
    public function addService($key, $service) {
        $this->services[$key] = $service;
    }

    // Отримуємо сервіс з контейнера
    public function getService($key) {
        // Якщо сервіс вже був створений, повертаємо його
        if (isset($this->instances[$key])) {
            return $this->instances[$key];
        }

        // Перевіряємо, чи існує сервіс у контейнері
        if (!isset($this->services[$key])) {
            throw new Exception("Service $key not found in the container");
        }

        // Створюємо сервіс і зберігаємо його в instances
        $service = $this->services[$key]($this);
        $this->instances[$key] = $service;

        return $service;
    }

    public function __construct() {
        $this->addService('db', function($container) {
            include_once "./services/db/DBPDOService.php";
            return new DBPDOService( "localhost", "php_spd_111", "spd_111_user", "spd_pass" );
        });
        $this->addService('hash', function($container) {
            include_once "./services/hash/SHA256HashService.php";
            return new SHA256HashService();
        });
        $this->addService('TokenDao', function($container) {
            include_once "./dal/dao/TokenDao.php";
            return new TokenDao( $container->getService("db") );
        });
        $this->addService('UserDao', function($container) {
            include_once "./dal/dao/UserDao.php";
            return new UserDao( $container->getService("db"), $container->getService("hash") );
        });
        $this->addService('AuthController', function($container) {
            include_once "./controllers/AuthController.php";
            return new AuthController( $container->getService("TokenDao"), $container->getService("UserDao") );
        });
        $this->addService('RegistrationController', function($container) {
            include_once "./controllers/RegistrationController.php";
            return new RegistrationController( $container->getService("UserDao") );
        });
    }

}
<?php

class APIController {
    protected function connect_db_or_exit(){
        try {
            $db = new PDO('mysql:host=localhost;dbname=php_spd_111;charset=utf8mb4', 'spd_111_user', 'spd_pass', 
            [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
            return $db;
        } catch (PDOException $e) {
            http_response_code( 500 );
            echo "Connection error: " . $ex->getMessage();
            exit;
        }
    }
    public function serve(){
        $method = strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) ;
        $action = "do_{$method}";
        if( method_exists( $this, $action ) ) {
            // якщо визначений, то викликаємо
            $this->$action();
        }
        else{
            $http_response_code(405);
            echo "Method Not Allowed";
        }
    }
    protected function end_with ($result) {
        header ('Content-Type: application/json');
        echo json_encode( $result );
        exit;
    }
}
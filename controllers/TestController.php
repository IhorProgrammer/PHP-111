<?php
include_once "APIController.php";
class TestController extends APIController {
    protected function do_get(){
        $db = $this->connect_db_or_exit();
        $sql = "CREATE TABLE IF NOT EXISTS Users (
            `id`          CHAR(36) PRIMARY KEY DEFAULT ( UUID() ),
            `email`       VARCHAR(128) NOT NULL,
            `name`        VARCHAR(64) NOT NULL,
            `password`    CHAR(32) NOT NULL,
            `avatar`      VARCHAR(128)
        ) ENGINE = INNODB, DEFAULT CHARSET = utf8mb4";
        try {
            $db->query( $sql );
        }
        catch(PDAException $ex) {
            http_response_code( 500 );
            echo "Connection error: " . $ex->getMessage();
            exit;
        }
        echo "All OK";
    }
    protected function do_post(){
    }
}
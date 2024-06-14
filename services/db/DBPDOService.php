<?php
    require_once('services/db/DBService.php');  

    class DBPDOService implements DBService {
        
        private $_connect = null; 
        
        private $host = null;
        private $name = null;
        private $user = null;
        private $pass = null;

        function __construct($host, $name, $user, $pass) {
            $this->host = $host;
            $this->name = $name;
            $this->user = $user;
            $this->pass = $pass;
        }

        public function connect(){
            if( $this->_connect != null ) return $this->_connect;
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->name};charset=utf8mb4";
                $this->_connect = new PDO($dsn, $this->user, $this->pass, 
                [
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]);
            } catch (PDOException $e) {
                throw new PDOException('DBPDOService: connect -> ' . $e->getMessage() );
            }
            return $this->_connect;
        }
    }


 

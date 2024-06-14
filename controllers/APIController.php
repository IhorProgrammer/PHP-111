<?php

class APIController {
    public function serve(){
        $method = strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) ;
        $action = "do_{$method}";
        if( method_exists( $this, $action ) ) {
            try {
                // якщо визначений, то викликаємо
                
                $data = $this->$action();
                $this->sendREST("200", "Success", $data);
            } catch ( RESTException $ex) {
                $this->sendREST( $ex->status, $ex->getMessage(), null );
            } catch (Exception $ex) {
                $this->sendREST( "500", $ex->getMessage(), null );
            }
        }
        else{
            $this->sendREST("405", "Method Not Allowed", null);
        }
    }

    private function sendREST( $status, $message, $data ) {
        $result = [ 
			'meta' => [
                'status' => $status,
				'time' => time(),
                'message' => $message
			],
			'data' => $data
		];

        header ('Content-Type: application/json');
        echo json_encode( $result );
        exit;
    }
}


class RESTException extends Exception {
    public $status;
    public $message;

    public function __construct($message, $status) {
        parent::__construct($message);
        $this->status = $status; 
    }

    public function getJson() : Array {
        $result = [ 
			'meta' => [
                'status' => $this->status,
				'time' => time(),
                'message' => $this->message
			],
			'data' => null
		];
        
        return $result;
    }
}
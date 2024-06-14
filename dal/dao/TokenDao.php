<?php
include_once "./dal/dto/TokenItem.php";
use Ramsey\Uuid\Uuid;


class TokenDao {
    
    //подовжувати час виконання

    private ?DBService $db = null;
    private const TOKEN_TIME_VALID  = 86400; // 1 day

    function __construct( DBService $db ) {
        $this->db = $db;
    }


    private function generateToken( string $user_id ) : ?TokenItem {
        $sql = "INSERT INTO Tokens( token_id, user_id, token_expires ) VALUE(?,?,?)";
		try {
            $db = $this->db->connect();
            $tokenItem = new TokenItem();
            $tokenItem->token_id = Uuid::uuid4();
            $tokenItem->user_id = $user_id;
            $tokenItem->tokenExpires = date('Y-m-d H:i:s', time() + self::TOKEN_TIME_VALID);


            $prep = $db->prepare( $sql ) ;
        
			$prep->execute( [
				$tokenItem->token_id,
				$tokenItem->user_id,
                $tokenItem->tokenExpires
			] ) ;
            
            return $tokenItem; 
        }
		catch( PDOException $ex ) {
            throw new Exception( $ex->getMessage(), "500" );
		}
    }

    private function findToken ( string $user_id ) : ?TokenItem {
        $sql = "SELECT * FROM tokens WHERE user_id = ? AND token_expires > CURRENT_TIMESTAMP LIMIT 1";
		try {
            $db = $this->db->connect();
            $prep = $db->prepare( $sql ) ;            
			$prep->execute( [
				$user_id,
			] ) ;
            
            $tokenDB = $prep->fetch(PDO::FETCH_ASSOC);
            
            if( $tokenDB != null ) {
                $tokenItem = TokenItem::toTokenItem( $tokenDB );
                return $tokenItem;
            }
    
            return null; 
        }
		catch( PDOException $ex ) {
            throw new Exception( $ex->getMessage(), "500" );
		}
        return null;
    }

    
    public function continueToken($token_id, $user_id) : ?TokenItem {
        $tokenItem = new TokenItem();
        $tokenItem->token_id = $token_id;
        $tokenItem->user_id = $user_id;
        $tokenItem->tokenExpires = date('Y-m-d H:i:s', time() + self::TOKEN_TIME_VALID);
        $sql = "UPDATE Tokens SET token_expires = ? WHERE token_id = ? AND token_expires > CURRENT_TIMESTAMP";
		
        try {
            $db = $this->db->connect();
            $prep = $db->prepare( $sql ) ;            
			$prep->execute( [
                $tokenItem->tokenExpires,
				$tokenItem->token_id
			] ) ;

            return $tokenItem; 
        }
		catch( PDOException $ex ) {
            throw new Exception( $ex->getMessage(), "500" );
		}
        return null;

    }

    public function getToken( string $user_id ) : ?string {
        $token = $this->findToken($user_id);
        if( $token == null ) {
            $token = $this->generateToken( $user_id );   
        }
        else {
            $this->continueToken( $token->token_id, $user_id );
        }
        return $token->token_id;
    }
}
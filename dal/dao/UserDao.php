<?php
include_once "./dal/dto/UserItem.php";
use Ramsey\Uuid\Uuid;


class UserDao {
    private $db = null;
    private $hash = null;

    function __construct( $db, $hash ) {
        $this->db = $db;
        $this->hash = $hash;
    }

    function registerUser ( $login, $user_password, $email, $avatar ) : ?UserItem {
		$sql = "INSERT INTO users ( user_id, login, email, avatar, salt, dk ) VALUES(?,?,?,?,?,?) ";
        
        $user = new UserItem(); 
        $user->user_id = Uuid::uuid4()->toString();
        $user->login = $login;
        $user->email = $email;
        $user->avatar = $avatar?$avatar:"";
        $user->salt = Uuid::uuid4()->toString();
        $user->dk = $this->hash->digest( $user->salt . $user_password );

		try {                        
            $db = $this->db->connect();
            $prep = $db->prepare( $sql ) ; 
			$prep->execute( [
                $user->user_id,
                $user->login,
                $user->email,
                $user->avatar,
                $user->salt,
                $user->dk,
			] ) ;

            return $user;
		}                         
		catch( PDOException $ex ) {
			throw new Exception($ex->getMessage(), 500);
		}
        return null;
    }

    function getUserByToken( $token ) {
        $sql = "
        SELECT * 
        FROM tokens t  
        JOIN users u ON u.user_id = t.user_id
        WHERE token_id = ? AND token_expires > CURRENT_TIMESTAMP 
        LIMIT 1";
		try {                        
            $db = $this->db->connect();
            $prep = $db->prepare( $sql ) ; 
			$prep->execute( [
                $token
			] ) ;
            $userDB = $prep->fetch(PDO::FETCH_ASSOC);
            if( $userDB != null ) {
                $userItem = UserItem::toUserItem( $userDB );
                return $userItem;
            }
            return null;

		}                         
		catch( PDOException $ex ) {
            throw new Exception($ex->getMessage(), 500);
		}
        return null;
    }
    
    function authorizationUser ( $login, $password ) : ?UserItem {
        $sql = "SELECT * from users WHERE login = ? LIMIT 1";
		try {                        
            $db = $this->db->connect();
            $prep = $db->prepare( $sql ) ; 
			$prep->execute( [
                $login
			] ) ;
            $userDB = $prep->fetch(PDO::FETCH_ASSOC);
            
            if( $userDB != null ) {
                $userItem = UserItem::toUserItem( $userDB );
                $dkTemp = $this->hash->digest( $userItem->salt . $password );
                if( strcmp( $dkTemp, $userItem->dk ) == 0) {
                    return $userItem;
                }
            }
            return null;

		}                         
		catch( PDOException $ex ) {
            throw new Exception($ex->getMessage(), 500);
		}
        return null;
    }
}
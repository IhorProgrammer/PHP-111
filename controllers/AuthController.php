<?php
include_once "ApiController.php" ;

class AuthController extends ApiController {	
	
	private  $tokenDao = null;
	private  $userDao = null;

	function __construct ( $tokenDao, $userDao ) {
        $this->tokenDao = $tokenDao;
        $this->userDao = $userDao;

    }

	protected function do_get() {
		if( empty( $_GET[ "token" ] ) ) {
			throw new RESTException( "Missing required parameter: 'token'", "400" );
		}
		$token = trim( $_GET[ "token" ] ) ;
		$userItem = $this->userDao->getUserByToken( $token );
		if( $userItem == null ) {
			throw new RESTException( "Token isnt valid", "400" );
		}

		return array(
			"login" => $userItem->login,
			"email" => $userItem->email,
			"avatar" => $userItem->avatar
		);		
	}
	protected function do_post() {
		// $login
		if( empty( $_POST[ "login" ] ) ) {
			throw new RESTException( "Missing required parameter: 'login'", "400" );
		}
		$login = trim( $_POST[ "login" ] ) ;
		if( strlen( $login ) < 2 ) {
			throw new RESTException( "Validation violation: 'login' too short", "400" );
		}
		// $password
		if( empty( $_POST[ "password" ] ) ) {
			throw new RESTException( "Missing required parameter: 'password'", "400" );
		}
		$password = trim( $_POST[ "password" ] ) ;
		if( strlen( $password ) < 2 ) {
			throw new RESTException( "Validation violation: 'password' too short", "400" );
		}
		
		$userItem = $this->userDao->authorizationUser( $login, $password );
		if( $userItem == null ) {
			throw new RESTException( "Login or Password not valid", "401" );
		}
		
		
		return $this->tokenDao->getToken( $userItem->user_id );
	}
}

/*
CRUD-повнота -- реалізація щонайменше 4х операцій з даними
C  Create   POST
R  Read     GET
U  Update   PUT
D  Delete   DELETE

Д.З. Закласти курсовий проєкт
- скласти ТЗ (хоча б мінімалістичне), орієнтир часу на весь проєкт - 4 тижні
- створити облікові записи
 = репозиторій
 = місце розміщення 
- створити стартову сторінку
Прикласти посилання на репозиторій та сам сайт

*/

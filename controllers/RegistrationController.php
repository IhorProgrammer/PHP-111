<?php
include_once "ApiController.php" ;

class RegistrationController extends ApiController {	
	/**
	* Реєстрація нового користувача (Create)
	*/

	private  $userDao = null;

	function __construct ( $userDao ) {
        $this->userDao = $userDao;
    }

	protected function do_post() {
		if( empty( $_POST[ "name" ] ) ) {
			throw new RESTException( "Missing required parameter: 'user-name'", "400" );
		}
		$user_name = trim( $_POST[ "name" ] ) ;
		if( strlen( $user_name ) < 2 ) {
			throw new RESTException( "Validation violation: 'user-name' too short", "400" );
		}
		if( preg_match( '/\d/', $user_name ) ) {
			throw new RESTException( "Validation violation: 'name' must not contain digit(s)", "400" );
		}
		if( empty( $_POST[ "password" ] ) ) {
			throw new RESTException( "Missing required parameter: 'password'", "400" );
		}
		$user_password = $_POST[ "password" ] ;		
		
		if( empty( $_POST[ "email" ] ) ) {
			throw new RESTException( "Missing required parameter: 'user-email'", "400" );
		}
		$user_email = trim( $_POST[ "email" ] ) ;
		
		$filename = null ;
		if( ! empty( $_FILES[ 'avatar' ] ) ) {
			// файл опціональний, але якщо переданий, то перевіряємо його
			if( $_FILES[ 'avatar' ][ 'error' ] != 0
			 || $_FILES[ 'avatar' ][ 'size' ] == 0
			) {
				throw new RESTException( "File upload error", "400" );
			}
			// перевіряємо тип файлу (розширення) на перелік допустимих
			$ext = pathinfo( $_FILES[ 'avatar' ][ 'name' ], PATHINFO_EXTENSION ) ;
			if( strpos( ".png.jpg.bmp", $ext ) === false ) {
				throw new RESTException( "File type error", "400" );
			}
			// генеруємо ім'я для збереження, залишаємо розширення
			do {
				$filename = uniqid() . "." . $ext ;
			}  // перевіряємо чи не потрапили в існуючий файл
			while( is_file( "./wwwroot/avatar/" . $filename ) ) ;
			
			// переносимо завантажений файл до нового розміщення
			move_uploaded_file( 
				$_FILES[ 'avatar' ][ 'tmp_name' ],
				"./wwwroot/avatar/" . $filename ) ;
		}
		/* Запити до БД поділяються на два типи - звичайні та підготовлені
		У звичайних запитах дані підставляються у текст запиту (SQL), 
		у підготовлених - ідуть окремо.
		Звичайні запити виконуються за один акт комунікації (БД-РНР),
		підготовлені - за два: перший запит "готує", другий передає дані.
		!! Хоча підготовлені запити призначені для повторного (багаторазового)
			використання, вони мають значно кращі параметри безпеки щодо 
			SQL-ін'єкцій.
			... WHERE name='%s' ...   (name = "o'Brian") -> 
			... WHERE name='o'Brian' ...  -- пошкоджений запит (Syntax Error)
		  Тому використання підготовлених запитів рекомендується у всіх 
		  випадках, коли у запит додаються дані, що приходять зовні
		*/

		$userItem = $this->userDao->registerUser( $user_name, $user_password, $user_email, $filename );
		if( $userItem == null) {
			throw new RESTException("User dont Registered", "500");
		} 
		return null;
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

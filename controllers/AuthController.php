<?php

include_once "ApiController.php" ;

class AuthController extends ApiController {	
	
	protected function do_get() {
		$db = $this->connect_db_or_exit() ;
		// виконання запитів
		$sql = "CREATE TABLE  IF NOT EXISTS  Users (
			`id`        CHAR(36)      PRIMARY KEY  DEFAULT ( UUID() ),
			`email`     VARCHAR(128)  NOT NULL,
			`name`      VARCHAR(64)   NOT NULL,
			`password`  CHAR(32)      NOT NULL     COMMENT 'Hash of password',
			`avatar`    VARCHAR(128)  NULL
		) ENGINE = INNODB, DEFAULT CHARSET = utf8mb4";
		try {
			$db->query( $sql ) ;
		}
		catch( PDOException $ex ) {
			http_response_code( 500 ) ;
			echo "query error: " . $ex->getMessage() ;
			exit ;
		}
		echo "Hello from do_get - Query OK" ;
	}
	
	/**
	* Реєстрація нового користувача (Create)
	*/
	protected function do_post() {
		// $result = [ 'get' => $_GET, 'post' => $_POST, 'files' => $_FILES, ] ;
		$result = [  // REST - як "шаблон" однаковості відповідей АПІ
			'status' => 0,
			'meta' => [
				'api' => 'auth',
				'service' => 'signup',
				'time' => time()
			],
			'data' => [
				'message' => ""
			],
		] ;
		if( empty( $_POST[ "name" ] ) ) {
			$result[ 'data' ][ 'message' ] = "Missing required parameter: 'user-name'" ;
			$this->end_with( $result ) ;
		}
		$user_name = trim( $_POST[ "name" ] ) ;
		if( strlen( $user_name ) < 2 ) {
			$result[ 'data' ][ 'message' ] = "Validation violation: 'user-name' too short" ;
			$this->end_with( $result ) ;
		}
		if( preg_match( '/\d/', $user_name ) ) {
			$result[ 'data' ][ 'message' ] = 
				"Validation violation: 'name' must not contain digit(s)" ;
			$this->end_with( $result ) ;
		}
		
		if( empty( $_POST[ "password" ] ) ) {
			$result[ 'data' ][ 'message' ] = "Missing required parameter: 'password'" ;
			$this->end_with( $result ) ;
		}
		$user_password = $_POST[ "password" ] ;		
		
		if( empty( $_POST[ "email" ] ) ) {
			$result[ 'data' ][ 'message' ] = "Missing required parameter: 'user-email'" ;
			$this->end_with( $result ) ;
		}
		$user_email = trim( $_POST[ "email" ] ) ;
		
		$filename = null ;
		if( ! empty( $_FILES[ 'avatar' ] ) ) {
			// файл опціональний, але якщо переданий, то перевіряємо його
			if( $_FILES[ 'avatar' ][ 'error' ] != 0
			 || $_FILES[ 'avatar' ][ 'size' ] == 0
			) {
				$result[ 'data' ][ 'message' ] = "File upload error" ;
				$this->end_with( $result ) ;
			}
			// перевіряємо тип файлу (розширення) на перелік допустимих
			$ext = pathinfo( $_FILES[ 'avatar' ][ 'name' ], PATHINFO_EXTENSION ) ;
			if( strpos( ".png.jpg.bmp", $ext ) === false ) {
				$result[ 'data' ][ 'message' ] = "File type error" ;
				$this->end_with( $result ) ;
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
		$db = $this->connect_db_or_exit() ;
		// виконання підготовлених запитів
		// 1. у запиті залишаються "плейсхолдери" - знаки "?"
		$sql = "INSERT INTO Users(`email`,`name`,`password`,`avatar`) VALUES(?,?,?,?) ";
		
		try {                        
			$prep = $db->prepare( $sql ) ;  // 2. Запит готується
			// 3. Запит виконується з передачею параметрів
			$prep->execute( [
				$user_email,
				$user_name,
				md5( $user_password ),
				$filename
			] ) ;
		}                         
		catch( PDOException $ex ) {
			http_response_code( 500 ) ;
			echo "query error: " . $ex->getMessage() ;
			exit ;
		}
		
		$result[ 'status' ] = 1 ;
		$result[ 'data' ][ 'message' ] = "Signup OK" ;
		$this->end_with( $result ) ;
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

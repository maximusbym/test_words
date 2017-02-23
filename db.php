<?php

namespace Core;

class DB {
	
	static private $_instance = null;
	private $pdo;
	
	private function __construct() {}
	private function __clone() {}
	
	static public function getInstance( $host, $db, $login, $password ) {
		
		if( is_null(self::$_instance) ) {
			
			try {
				$pdo = new \PDO("mysql:host={$host};dbname={$db};charset=utf8", $login, $password);
				$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
				$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
				
				self::$_instance = new DB();
				self::$_instance->pdo = $pdo;
			}
			catch (PDOException $e){
				echo "ERROR: " . $e->getMessage() . "\n";
			}
		}
		return self::$_instance;
	}
	
	public function query( $q, $params = [] ) {
		
		$stmt = $this->pdo->prepare( $q );
		$stmt->execute( $params );
		
		return $stmt->fetchAll();
	}
	
}
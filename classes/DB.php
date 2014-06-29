<?php
// IN THIS SINGLETON CLASS WE INSTANTIATE THE CONNECTION TO DB SO WE DO NOT NEED TO CONNECT TO IT EVERYTIME WE DO A QUERY
class DB {
	//THE UNDERSCORE IS JUST TO TELL THAT THEY ARE PRIVATE
	private static $_instance = null;
	//PDO OBJECT, WHEN IT IS INSTANTIATED, IS GONNA BE STORED TO THE $_pdo
	//$_query is the last query that is executed
	//result stores the result set
	//count of the result is stored to $_count
	public $pdo;


	private function __construct(){
		try{

			$this->pdo = new PDO('mysql:host=' . Config::get('mysql/host') .';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
			$this->pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$this->pdo->setAttribute (PDO::ATTR_EMULATE_PREPARES, false);

		} catch(PDOException $e) {

			die ($e->getMessage());
		}
	}

	public static function getInstance(){
		if(!isset(self::$_instance)) {
			self::$_instance = new DB();
		}

		return self::$_instance;
	}

}	
<?php
require_once "account.php";

class accountPDO {
	private $db;
	function __construct($dsn="mysql:host=localhost;dbname=SKLV", $user="root", $password="salainen") {
		$this->db = new PDO($dsn,$user,$password);
		$this->db->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$this->db->setAttribute (PDO::ATTR_EMULATE_PREPARES, false);
	}

	function addAccount($account) {
		$sql = "INSERT INTO account (fname, lname, phone, email, passwd, role)
		values (:fname, :lname, :phone, :email, :passwd, :role)";
		if (!$stmt = $this->db->prepare($sql)) {
			$error = $this->db->errorInfo();

			throw new PDOException ($error[2], $error[1]);
		}
		$stmt->bindValue(":fname", utf8_decode($account->getfName()), PDO::PARAM_STR);
		$stmt->bindValue(":lname", utf8_decode($account->getlName()), PDO::PARAM_STR);
		$stmt->bindValue(":phone", utf8_decode($account->getPhone()), PDO::PARAM_STR);
		$stmt->bindValue(":email", utf8_decode($account->getEmail()), PDO::PARAM_STR);
		$stmt->bindValue(":passwd", utf8_decode($account->getPasswd()), PDO::PARAM_STR);
		$stmt->bindValue(":role", utf8_decode($account->getRole()), PDO::PARAM_STR);
		
		if(! $stmt->execute()) {
			$error = $stmt->errorInfo();
			
			if($error[0] == "HY093"){
				$error[2] = "Invalid parameter";
			}
			
			throw new PDOException($error[2], $error[1]);
		}
		
		return $this->db->lastInsertId();
		
	}

	function loginAccount($email, $passwd){
		//$passwd = sha1($passwd);

		$sql = "SELECT id, fname, lname, phone, email, passwd, role FROM account
		WHERE email =':email' AND passwd =':passwd'";
		if (!$stmt = $this->db->prepare($sql)) {
			$error = $this->db->errorInfo();

			throw new PDOException ($error[2], $error[1]);
		}

		$stmt->bindValue(":email", $email, PDO::PARAM_STR);
		$stmt->bindValue(":passwd", $passwd, PDO::PARAM_STR);
		
		
		if (! $stmt->execute()) {
			$error = $stmt->errorInfo ();
			throw new PDOException ($error[2], $error[1]);
		}
		
		$result = array();
		
		while ($row = $stmt->fetchObject() ) {

			$account = new Account();
			$account->setfName(utf8_encode($row->fname));
			$account->setlName(utf8_encode($row->lname));
			$account->setPhone($row->phone);
			$account->setEmail(utf8_encode($row->email));
			$account->setPasswd($row->passwd);
			$account->setRole(utf8_encode($row->role));
			$account->setId($row->id);

			$result[] = $account;
		}
		return $result; 

	}
	
	
}
?>
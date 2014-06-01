<?php
require_once "account.php";

class AccountPDO {
	private $db;
	function __construct($dsn="mysql:host=localhost;dbname=SKLV", $user="root", $password="salainen") {
		$this->db = new PDO($dsn,$user,$password);
		$this->db->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$this->db->setAttribute (PDO::ATTR_EMULATE_PREPARES, false);
	}

	function addAccount($newaccount) {
		$sql = "INSERT INTO account (fname, lname, phone, email, passwd, role)
		values (:fname, :lname, :phone, :email, SHA1(:passwd), :role)";
		if (!$stmt = $this->db->prepare($sql)) {
			$error = $this->db->errorInfo();

			throw new PDOException ($error[2], $error[1]);
		}
		$stmt->bindValue(":fname", utf8_decode($newaccount->getfName()), PDO::PARAM_STR);
		$stmt->bindValue(":lname", utf8_decode($newaccount->getlName()), PDO::PARAM_STR);
		$stmt->bindValue(":phone", utf8_decode($newaccount->getPhone()), PDO::PARAM_STR);
		$stmt->bindValue(":email", utf8_decode($newaccount->getEmail()), PDO::PARAM_STR);
		$stmt->bindValue(":passwd", utf8_decode($newaccount->getPasswd()), PDO::PARAM_STR);
		$stmt->bindValue(":role", utf8_decode($newaccount->getRole()), PDO::PARAM_STR);
		
		if(! $stmt->execute()) {
			$error = $stmt->errorInfo();
			
			if($error[0] == "HY093"){
				$error[2] = "Invalid parameter";
			}
			
			throw new PDOException($error[2], $error[1]);
		}	
		return $this->db->lastInsertId();
	}


	function updateAccount($theaccount) {
		$passwd = sha1($passwd);



		$sql = "UPDATE account SET fname=:fname, lname=:lname, phone=:phone, email=:email, passwd=:passwd, role=:role";
		if (!$stmt = $this->db->prepare($sql)) {
			$error = $this->db->errorInfo();

			throw new PDOException ($error[2], $error[1]);
		}
		$stmt->bindValue(":fname", utf8_decode($theaccount->getfName()), PDO::PARAM_STR);
		$stmt->bindValue(":lname", utf8_decode($theaccount->getlName()), PDO::PARAM_STR);
		$stmt->bindValue(":phone", utf8_decode($theaccount->getPhone()), PDO::PARAM_STR);
		$stmt->bindValue(":email", utf8_decode($theaccount->getEmail()), PDO::PARAM_STR);
		$stmt->bindValue(":passwd", utf8_decode($theaccount->getPasswd()), PDO::PARAM_STR);
		$stmt->bindValue(":role", utf8_decode($theaccount->getRole()), PDO::PARAM_STR);
		
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
		$passwd = sha1($passwd);

		$sql = "SELECT id, fname, lname, phone, email, passwd, role FROM account
		WHERE email =:email AND passwd = :passwd LIMIT 1";

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

		$result = new Account();
		while ($row = $stmt->fetchObject() ) {
			$account = $result;
			$account->setId($row->id);
			$account->setfName(utf8_encode($row->fname));
			$account->setlName(utf8_encode($row->lname));
			$account->setPhone($row->phone);
			$account->setEmail(utf8_encode($row->email));
			$account->setPasswd($row->passwd);
			$account->setRole(utf8_encode($row->role));
			$result = $account;	
		}
		return $result; 

	}
	
	
}
?>
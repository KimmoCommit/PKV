<?php

class AccountPDO {
	private $db;

	function __construct() {
		if (DB::getInstance() === null ){
			$this->db = new PDO('mysql:host=' . Config::get('mysql/host') .';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
		}

		$this->db = DB::getInstance()->pdo;		
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
		$pwd = $theaccount->getPasswd();
		$passwd = sha1($pwd);

		$sql = "UPDATE account SET fname=:fname, lname=:lname, phone=:phone, email=:email, passwd=:passwd, role=:role WHERE id=:id";
		if (!$stmt = $this->db->prepare($sql)) {
			$error = $this->db->errorInfo();

			throw new PDOException ($error[2], $error[1]);
		}
		$stmt->bindValue(":fname", utf8_decode($theaccount->getfName()), PDO::PARAM_STR);
		$stmt->bindValue(":lname", utf8_decode($theaccount->getlName()), PDO::PARAM_STR);
		$stmt->bindValue(":phone", utf8_decode($theaccount->getPhone()), PDO::PARAM_STR);
		$stmt->bindValue(":email", utf8_decode($theaccount->getEmail()), PDO::PARAM_STR);
		$stmt->bindValue(":passwd", utf8_decode($passwd), PDO::PARAM_STR);
		$stmt->bindValue(":role", utf8_decode($theaccount->getRole()), PDO::PARAM_STR);
		$stmt->bindValue(":id", utf8_decode($theaccount->getId()), PDO::PARAM_STR);
		
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

	public function allAccounts() {
		$sql = "SELECT id, fname, lname, phone, email, role FROM account ORDER BY fname ASC;
		";
		
		if (! $stmt = $this->db->prepare($sql)) {
			$error = $this->db->errorInfo ();
			
			throw new PDOException ($error[2], $error[1]);
		}
		
		if (! $stmt->execute()) {
			$error = $stmt->errorInfo ();
			throw new PDOException ($error[2], $error[1]);
		}
		
		$result = array();
		
		while ($row = $stmt->fetchObject() ) {
			$account = new Account();
			$account->setId($row->id);
			$account->setfName(utf8_encode($row->fname));
			$account->setlName(utf8_encode($row->lname));
			$account->setPhone($row->phone);
			$account->setEmail(utf8_encode($row->email));
			$account->setRole(utf8_encode($row->role));
			$result[] = $account;
		}
		return $result;
	}

	public function deleteAccount($id) {

		$sql = "DELETE FROM account WHERE id = :id";
		if (! $stmt = $this->db->prepare($sql)) {
			$error = $this->db->errorInfo();

			throw new PDOException ($error[2], $error[1]);
		}
		$stmt->bindValue(":id", $id, PDO::PARAM_STR);


		if(! $stmt->execute()) {
			$error = $stmt->errorInfo();

			if($error[0] == "HY093"){
				$error[2] = "Invalid parameter";
			}

			throw new PDOException($error[2], $error[1]);
		}

		return;

	}

	public function findAccounts($search){
		$sql = "SELECT id, fname, lname, phone, email, role FROM account 
		WHERE (CONCAT_WS(fname, lname, phone, email, role) LIKE :search) ORDER BY fname ASC ;";

		if (! $stmt = $this->db->prepare($sql)) {
			$error = $this->db->errorInfo ();
			throw new PDOException ($error[2], $error[1]);
		}

		$srch = "%" . utf8_decode($search) . "%";
		$stmt->bindValue(":search", $srch, PDO::PARAM_STR);

		if (! $stmt->execute()) {
			$error = $stmt->errorInfo ();
			throw new PDOException ($error[2], $error[1]);
		}

		$result = array();

		while ($row = $stmt->fetchObject() ) {

			$account = new Account();
			$account->setId($row->id);
			$account->setfName(utf8_encode($row->fname));
			$account->setlName(utf8_encode($row->lname));
			$account->setPhone($row->phone);
			$account->setEmail(utf8_encode($row->email));
			$account->setRole(utf8_encode($row->role));
			$result[] = $account;
		}
		return $result;

	}

	public function findEmail($email){
		$sql = "SELECT email FROM account WHERE email = :email";

		if (!$stmt = $this->db->prepare($sql)) {
			$error = $this->db->errorInfo();
			throw new PDOException ($error[2], $error[1]);
		}

		$stmt->bindValue(":email", $email, PDO::PARAM_STR);
		
		if (! $stmt->execute()) {
			$error = $stmt->errorInfo ();
			throw new PDOException ($error[2], $error[1]);
		}
		

		while ($row = $stmt->fetchObject() ) {
			$result = new Account();
			$result->setEmail(utf8_encode($row->email));
		}

		return $result; 
	}

}
?>
<?php

class Account {

	private static $errorcodes = array(

	-1 => "",
	0 => "",
	1 => "Kenttä ei saa olla tyhjä",
	11 => "Nimessä ei saa olla erikoismerkkejä",
	12 => "Nimessä tulee olla vähintään neljä (4) merkkiä",
	13 => "Nimessä tulee olla enintään kolmekymmentä (30) merkkiä",
	21 => "Puhelinnumerossa saa olla vain numeroita",
	22 => "Puhelinnumerossa on liian vähän numeroita - kentässä tulee olla täsmälleen 10 numeroa",
	23 => "Puhelinnumerossa on liian paljon numeroita - kentässä tulee olla täsmälleen 10 numeroa",
	51 => "Sähköposti on muotoiltu väärin - kentän tiedon tulee olla muotoa Matti@Meikalainen.fi",
	52 => "Sähköpostissa on liian vähän merkkejä - kentässä tulee olla vähintään kuusi (6) merkkiä",
	53 => "Sähköpostissa on liian paljon merkkejä - kentässä tulee olla enintään kolmekymmentä (30) merkkiä",
	61 => "Salasanassa tulee olla kaksi (2) pientä ja  yksi (1) iso kirjain sekä kaksi numeroa",
	71 => "Salasanat eivät täsmää"

	);

public static function getError($errorcodes) {
	if (isset(self::$errorcodes[$errorcodes]))
		return self::$errorcodes[$errorcodes];

	return self::$errorcodes[-1];
}


private $id;
private $fname;
private $lname;
private $phone;
private $email;
private $passwd;
private $passwd2;
private $role;


function __construct( $fname = "", $lname = "", $phone = "", $email = "" , $passwd = "", $passwd2 = "",  $role = "",  $id = 0) {
	$this->id = $id;
	$this->fname = trim(ucwords($fname));
	$this->lname = trim(ucwords($lname));
	$this->phone = trim($phone);
	$this->email = trim($email);
	$this->passwd = trim($passwd);
	$this->passwd2 = trim($passwd2);
	$this->role = trim($role);

}


public function setId($id) {
	$this->id = trim($id);
}


public function getId() {
	return $this->id;
}


public function setfName($fname) {
	$this->fname = trim($fname);
}

public function getfName() {
	return $this->fname;
}


public function setlName($lname) {
	$this->lname = trim($lname);
}

public function getlName() {
	return $this->lname;
}

public function setPhone($phone) {
	$this->phone = trim($phone);
}

public function getPhone() {
	return $this->phone;
}

public function setEmail($email) {
	$this->email = trim($email);
}

public function getEmail() {
	return $this->email;
}


public function setPasswd($passwd) {
	$this->passwd = trim($passwd);
}


public function getPasswd() {
	return $this->passwd;
}

public function setPasswd2($passwd2) {
	$this->passwd = trim($passwd2);
}


public function getPasswd2() {
	return $this->passwd2;
}


public function setRole($role) {
	$this->role = trim($role);
}


public function getRole() {
	return $this->role;
}


public function checkfName($required = true, $min = 4, $max = 30) {
	
	if ($required == false && strlen($this->fname) == 0)
		return 0;

	if ($required == true && strlen($this->fname) == 0)
		return 1;

	if (strlen($this->fname) < $min)
		return 12;

	if (strlen($this->fname) > $max)
		return 13;

	if (preg_match("/[^a-zåäöA-ZÅÄÖ\- ]/", $this->fname))
		return 11;

return 0;

}

public function checklName($required = true, $min = 4, $max = 30) {
	
	if ($required == false && strlen($this->lname) == 0)
		return 0;

	if ($required == true && strlen($this->lname) == 0)
		return 1;

	if (strlen($this->lname) < $min)
		return 12;

	if (strlen($this->lname) > $max)
		return 13;

	if (preg_match("/[^a-zåäöA-ZÅÄÖ\- ]/", $this->lname))
		return 11;

return 0;
}

public function checkPhone($required = true, $min = 10, $max = 10) {
	
	if ($required == false && strlen($this->phone) == 0)
		return 0;


	if ($required == true && strlen($this->phone) == 0)
		return 1;

	if (preg_match("/[^0-9 ]/", $this->phone))
		return 21;

	if (strlen($this->phone) < $min)
		return 22;

	if (strlen($this->phone) > $max)
		return 23;



return 0;
}



public function checkEmail($required = true, $min = 6, $max = 30) {
	
	if ($required == false && strlen($this->email) == 0)
		return 0;

	//strlen tarkastaa, montako merkkiä muuttujassa on
	if ($required == true && strlen($this->email) == 0)
		return 1;

	if (preg_match("/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/i", $this->email))
		return 0;
	else {
		return 51;
	}

	if (strlen($this->email) < $min)
		return 52;

	if (strlen($this->email) > $max)
		return 53;


return 0;
}





public function checkPasswd($required = true, $min = 8, $max = 30) {

	if ($required == false && strlen($this->passwd) == 0)
		return 0;


	if ($required == true && strlen($this->passwd) == 0)
		return 1;


	if(preg_match("/^.*(?=.*[a-zåäö]{2,})(?=.*[A-ZÅÄÖ]{1,})(?=.*[0-9]{2,}).*$/", $this->passwd))
		return 0;
	else {
		return 61;
	}

return 0;

}


public function checkPasswd2($required = true, $min = 8, $max = 30) {

	if ($required == false && strlen($this->passwd2) == 0)
		return 0;

	if ($required == true && strlen($this->passwd2) == 0)
		return 1;

	if (strcmp($this->passwd,$this->passwd2) != 0)
		return 71;
	


return 0;

}

public function checkRole($required = true) {
	
	if ($required == false && strlen($this->role) == 0)
		return 0;


	if ($required == true && strlen($this->role) == 0)
		return 1;



return 0;
}



}
?>
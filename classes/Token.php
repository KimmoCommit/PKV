<?php

class Token {
	public static function generate() {
		//return Session::put('session/token_name', md5(uniqid()));
		return $_SESSION[Config::get('session/token_name')] = md5(uniqid());

	}

	public static function check($token){
		$tokenName = Config::get('session/token_name');

		if(isset($_SESSION[$tokenName]) && $token === $_SESSION[$tokenName]){
			unset($_SESSION[$tokenName]);
			
			return true;

		}

		return false;
	}

}
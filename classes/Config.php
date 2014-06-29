<?php
//allows easily to access configs in init
//example: Config::get('mysql/host'); gets you: 127.0.0.1
class Config {
	public static function get($path = null) {
		if($path){
			$config = $GLOBALS['config'];
			$path = explode('/', $path);
			
			foreach($path as $bit){
				if(isset($config[$bit])){
					$config = $config[$bit];
				}
			}

			return $config;
		}

		return false;
	}
}


<?php
function escape($string){
	return htmlentitites($string, ENT_QUOTES, 'UTF-8');
}
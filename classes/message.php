<?php

class Message {

private $messagetitle;
private $messagebody;

function __construct($messagetitle = "", $messagebody = "") {
	$this->messagetitle = trim($messagetitle);
	$this->messagebody = trim($messagebody);

}

public function setMessageTitle($messagetitle) {
	$this->messagetitle = trim($messagetitle);
}


public function getMessageTitle() {
	return $this->messagetitle;
}

public function setMessageBody($messagebody) {
	$this->messagebody = trim($messagebody);
}


public function getMessageBody() {
	return $this->messagebody;
}


}


?>

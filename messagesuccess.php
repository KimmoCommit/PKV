<?php 
require_once 'classes/message.php';
require_once 'classes/account.php';
session_start();
$account = $_SESSION["account"];
$message = new Message();

if(isset($_SESSION["updatesuccess"])){
  unset($_SESSION["updatesuccess"]);
  $messagetitle = "Profiilisi tietojen päivitys onnistui!";
  $messagebody = "Siirrytään etusivulle noin kolmen (3) sekunnin kuluttua..";
  $message->setMessageTitle($messagetitle);
  $message->setMessageBody($messagebody);
  unset($_SESSION["updatesuccess"]);
  header("Refresh: 3 URL = index.php");
}

if(isset($_SESSION["editsuccess"])){
  unset($_SESSION["editsuccess"]);
  $messagetitle = "Käyttäjän tietojen päivitys onnistui!";
  $messagebody = "Siirrytään takaisin henkilöihin noin kolmen (3) sekunnin kuluttua..";
  $message->setMessageTitle($messagetitle);
  $message->setMessageBody($messagebody);
  unset($_SESSION["editsuccess"]);
  header("Refresh: 3 URL = accmanagement.php");
}


if(isset($_SESSION["deletesuccess"])){
  unset($_SESSION["deletesuccess"]);
  $messagetitle = "Käyttäjän poistaminen onnistui!";
  $messagebody = "Siirrytään takaisin henkilöihin noin kolmen (3) sekunnin kuluttua..";
  $message->setMessageTitle($messagetitle);
  $message->setMessageBody($messagebody);
  header("Refresh: 3 URL = accmanagement.php");
}



if(isset($_SESSION["newsuccess"])){
  unset($_SESSION["newsuccess"]);
  $messagetitle = "Uuden käyttäjän luonti onnistui!";
  $messagebody = "Siirrytään takaisin henkilöihin noin kolmen (3) sekunnin kuluttua..";
  $message->setMessageTitle($messagetitle);
  $message->setMessageBody($messagebody);
  unset($_SESSION["newsuccess"]);
  header("Refresh: 3 URL = accmanagement.php");
}




?>
<?php 
include 'includes/logout-module.php';
?>
<!DOCTYPE html>
<html lang="fi">
<?php require 'includes/head.php'; ?>
<body>
  <?php require 'includes/nav.php'; ?>
  <div class="content-container">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
          <div class="panel panel-default login-panel">
            <div class="panel-body">
              <div class="alert alert-success"><?php print($message->getMessageTitle()); ?></div>
              <p style="font-size:80%"><?php print($message->getMessageBody()); ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
        </div>
      </div>
    </div>
  </div>
</body>
</html>

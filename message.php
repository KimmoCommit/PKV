<?php 
require_once 'core/init.php';
$account = $_SESSION["account"];

if(isset($_SESSION["updateAccount"])){
  $message = $_SESSION["updateAccount"];
  unset($_SESSION["updateAccount"]);
  header("Refresh: 3 URL = index.php");
}

if(isset($_SESSION["editAccount"])){
  $message = $_SESSION["editAccount"];
  unset($_SESSION["editAccount"]);
  header("Refresh: 3; URL = accmanagement.php");
}


if(isset($_POST["deleteAccount"])){
 $theaccount = new Account($_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["email"], $_POST["passwd"], $_POST["passwd2"], $_POST["role"], $_POST["id"]);
 try
 {
  $usedb = new AccountPDO();
  $id = $theaccount->getId();
  $usedb->deleteAccount($id);
  
} catch (Exception $error) {
  print($error->getMessage());
}

$message = new Message();
$messagetitle = "Käyttäjän poistaminen onnistui!";
$messagebody = "Siirrytään takaisin henkilöihin noin kolmen (3) sekunnin kuluttua..";
$message->setMessageTitle($messagetitle);
$message->setMessageBody($messagebody);
header("Refresh: 3; URL = accmanagement.php");
}


if(isset($_SESSION["createAccount"])){
  $message = $_SESSION["createAccount"];
  unset($_SESSION["createAccount"]);
  header("Refresh: 3; URL = accmanagement.php");
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

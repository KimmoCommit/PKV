<?php
require_once "account.php";
session_start();

if (isset($_SESSION["account"]) && $_SESSION["account"]->getfName() != null){
  $account = $_SESSION["account"];
} 

if (isset($_POST["login"])) {
  try
  {
    require_once "accountPDO.php";
    $usedb = new AccountPDO();
    $email = $_POST["email"];
    $passwd = $_POST["passwd"];
    $result = $usedb->loginAccount($email, $passwd);
    
  } catch (Exception $error) {
    print($error->getMessage());
  }

  $_SESSION["account"] = $result;
  if($result->getfName() == null){
    unset($_SESSION["account"]);
    header("location: index.php");
  } else {
    header("location: index.php");
    exit;
  }
}


?>
<?php 
require 'includes/logout-module.php';
?>


<!DOCTYPE html>
<html lang="fi">
<?php require 'head.php'; ?>
<body>
  <?php require 'includes/nav.php'; ?>

  <div class="content-container">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
          <?php if (isset($_SESSION["account"])){
            include 'includes/index-logged-in.php';
          } else {
            include 'includes/index-logged-out.php';
          }
          ?>
        </div>
        <div class="col-md-4">
        </div>
      </div>
    </div>
  </div>
</body>
</html>

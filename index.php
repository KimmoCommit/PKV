<?php
require_once 'core/init.php';

//var_dump(Token::check($_POST['token']));
//var_dump(Config::get('session/token_name'));

if (isset($_SESSION["account"]) && $_SESSION["account"]->getfName() != null){
  $account = $_SESSION["account"];
} 

$theaccount = new Account();
$emailError = 0;



$message = new Message();


if (isset($_POST["login"])) {
  if(Token::check($_POST["token"])){

    $theaccount->setEmail($_POST["email"]);
    $theaccount->setPasswd($_POST["passwd"]);
    $emailError = $theaccount->checkEmail();
    $passwdError = $theaccount->checkPasswd();

    if($emailError == 0){

      try
      {
        $usedb = new AccountPDO();
        $email = $_POST["email"];
        $passwd = $_POST["passwd"];
        $result = $usedb->loginAccount($email, $passwd);

      } catch (Exception $error) {
        print($error->getMessage());
      }
     
      if($result->getId() === 0){
        $message->setMessageBody("Sähköposti ja salasana eivät täsmää");

      } else {
        $_SESSION["account"] = $result;
        header("location: index.php");
        exit;
      }
    }

  }
}

?>
<?php require 'includes/logout-module.php'; ?>


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

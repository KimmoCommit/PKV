<?php
require_once "classes/account.php";
session_start();


if (isset($_SESSION["account"]) && isset($_SESSION["editaccount"])){
  $account = $_SESSION["account"];
  $theaccount = $_SESSION["editaccount"];
} else {
  header("location: index.php");
  exit;
}


if(isset($_POST["fix"])){
  header("location: accedit.php");
  exit;
}

if(isset($_POST["confirm"])){
  try
  {
    require_once "classes/accountPDO.php";
    $theaccount = $_SESSION["editaccount"];
    $usedb = new AccountPDO();
    $usedb->updateAccount($theaccount);

    
  } catch (Exception $error) {
    print($error->getMessage());
    

  }
  unset($_SESSION["editaccount"]);
  $_SESSION["editsuccess"] = "editsuccess";
  header("location: messagesuccess.php");
  exit;
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
          <div class="panel panel-default login-panel">
            <div class="panel-heading">
              <h3 class="panel-title">Tietojen varmistaminen</h3>
            </div>
            <div class="panel-body">
             <form method="post">
              <table class="table-condensed confirm-table">
                <input type="hidden" name="id" value="<?php print($theaccount->getId); ?>"
                <tr>
                  <td>Etunimi:</td><td><?php print($theaccount->getfName()); ?> </td>
                </tr>
                <tr>
                  <td>Sukunimi:</td><td><?php print($theaccount->getlName()); ?> </td>
                </tr>
                <tr>
                  <td>Puhelinnumero:</td><td><?php print($theaccount->getPhone()); ?> </td>
                </tr>
                <tr>
                  <td>Sähköposti:</td><td><?php print($theaccount->getEmail()); ?></td>
                </tr>
                <tr>
                  <td>Salasana:</td><td> <?php print($theaccount->getPasswd()); ?></td>
                </tr>
                <tr>
                  <td>Rooli:</td><td class="role-value"> <?php print($theaccount->getRole()); ?></td>
                </tr>
              </table><br/>
              <button name="confirm" type="submit" class="btn btn-default  btn-success btn-block">Tallenna</button>
              <button name="fix" type="submit" class="btn btn-default  btn-warning btn-block">Korjaa</button> 
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-4">
      </div>
    </div>
  </div>
</div>


<script src="js/rolehelper.js" type="text/javascript"></script>
<script>
$(function(){

  var rh = new RoleHelper();
  rh.checkRoleTD();

});
</script>

</body>
</html>

<?php
require_once "account.php";
session_start();


if(isset($_SESSION["updateaccount"])){
  $theaccount = $_SESSION["updateaccount"];
} 

if (isset($_SESSION["account"])){
  $account = $_SESSION["account"];
}


if(isset($_POST["korjaa"])){
  header("location: accprofile.php");
  exit;
}

if(isset($_POST["confirm"])){
  try
  {
    require_once "accountPDO.php";
    $theaccount = $_SESSION["updateaccount"];
    $usedb = new AccountPDO();
    $usedb->updateAccount($theaccount);

    
  } catch (Exception $error) {
    print($error->getMessage());
    

  }
  $_SESSION["account"] = $theaccount;
  unset($_SESSION["theaccount"]);
  header("location: accupdatesuccess.php");
  exit;
}


?>
<?php 
require 'includes/logout-module.php';
?>


<!DOCTYPE html>
<html lang="fi">
<?php 
require 'head.php';
?>
<body>

  <?php 
  require 'includes/nav.php';
  ?>

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
              <button name="korjaa" type="submit" class="btn btn-default  btn-warning btn-block">Korjaa</button> 
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

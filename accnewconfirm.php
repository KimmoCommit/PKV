<?php
require_once "account.php";
session_start();

if(isset($_POST["korjaa"])){
  header("location: accnew.php");
  exit;
}


if(isset($_POST["confirm"])){
  try
  {
    require_once "accountPDO.php";
    $newaccount = $_SESSION["newaccount"];
    $usedb = new AccountPDO();
    $id = $usedb->addAccount($newaccount);
    $newaccount->setId($id);
    
  } catch (Exception $error) {
    print($error->getMessage());
    

  }
  
  unset($_SESSION["newaccount"]);
  header("location: accnewconfirmed.php");
  exit;
}

if(isset($_SESSION["newaccount"])){
  $newaccount = $_SESSION["newaccount"];
} else {
  header("location:index.php");
}

if (isset($_SESSION["account"])){
  $account = $_SESSION["account"];
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
                <tr>
                  <td>Etunimi:</td><td><?php print($newaccount->getfName()); ?> </td>
                </tr>
                <tr>
                  <td>Sukunimi:</td><td><?php print($newaccount->getlName()); ?> </td>
                </tr>
                <tr>
                  <td>Puhelinnumero:</td><td><?php print($newaccount->getPhone()); ?> </td>
                </tr>
                <tr>
                  <td>Sähköposti:</td><td><?php print($newaccount->getEmail()); ?></td>
                </tr>
                <tr>
                  <td>Salasana:</td><td> <?php print($newaccount->getPasswd()); ?></td>
                </tr>
                <tr>
                  <td>Rooli:</td><td class="role-value"> <?php print($newaccount->getRole()); ?></td>
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

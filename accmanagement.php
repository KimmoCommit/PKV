<?php
require_once "classes/account.php";
session_start();

if (isset($_SESSION["account"])){
  $account = $_SESSION["account"];
} else {
  header("location: index.php");
}

if(isset($_POST["editAccount"])){

  $editaccount = new Account( $_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["email"], $_POST["passwd"], $_POST["passwd2"], $_POST["role"], $_POST["id"]);
  /*$fnameError = $editaccount->checkfName();
  $lnameError = $editaccount->checklName();
  $phoneError = $editaccount->checkPhone();
  $emailError = $editaccount->checkEmail();
  $passwdError = $editaccount->checkPasswd();
  $passwd2Error = $editaccount->checkPasswd2();
  $roleError = $editaccount->checkRole();*/

  if($fnameError == 0 && $lnameError == 0 && $phoneError == 0 && $emailError == 0 && $passwdError == 0 && $passwd2Error == 0 && $roleError == 0){
    $_SESSION["editaccount"] = $editaccount;
    session_write_close();
    header("location: accedit.php");
    exit;
  }
}

if(isset($_POST["deleteAccount"])){

  $deleteaccount = new Account( $_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["email"], $_POST["passwd"], $_POST["passwd2"], $_POST["role"], $_POST["id"]);
  /*$fnameError = $editaccount->checkfName();
  $lnameError = $editaccount->checklName();
  $phoneError = $editaccount->checkPhone();
  $emailError = $editaccount->checkEmail();
  $passwdError = $editaccount->checkPasswd();
  $passwd2Error = $editaccount->checkPasswd2();
  $roleError = $editaccount->checkRole();*/

  if($fnameError == 0 && $lnameError == 0 && $phoneError == 0 && $emailError == 0 && $passwdError == 0 && $passwd2Error == 0 && $roleError == 0){
    $_SESSION["deleteaccount"] = $deleteaccount;
    session_write_close();
    header("location: accdeleteconfirm.php");
    exit;
  }
}


?>
<?php 
require 'includes/logout-module.php';
?>

<!DOCTYPE html>
<html lang="fi">
<?php require 'includes/head.php'; ?>
<body>
  <?php require 'includes/nav.php'; ?>
  <div class="content-container">
    <div class="container">
      <div class="row">
        <!--
        <div class="col-md-4">
        </div>-->
        <div class="col-md-12">
          <h1 style="padding-bottom:2%;">Henkilöt</h1>
          <div class="row" style="padding-bottom:2%;">
            <div class="col-md-3">
             <form class="" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="">
              </div>
              <button type="submit" class="btn btn-default btn-sm">Hae</button>
            </form>
          </div>
        </div>
        <div class="table-responsive ">
          <table class="table table-condensed table-hover">

            <thead>
              <th>Etunimi</th>
              <th>Sukunimi</th>
              <th>Puhelinnumero</th>
              <th>Sähköposti</th>
              <th>Rooli</th>
              <th></th>
              <th></th>
            </thead>

            <?php
            if($account->getRole() == 1){
              try
              {
               require_once "classes/accountPDO.php";
               $usedb = new accountPDO();
               $result = $usedb->allAccounts();

               foreach($result as $listaccount) {
                print("
                  <form method='post'>
                  <input type='hidden' name='id' value='". $listaccount->getId() . "''>
                  <tr>
                  <td>". $listaccount->getfName() ."</td>
                  <input name='fname' type='hidden' value='". $listaccount->getfName() ."'>
                  <td>". $listaccount->getlName() ."</td>
                  <input name='lname' type='hidden' value='". $listaccount->getlName() ."'>
                  <td><a href='tel:". $listaccount->getPhone() ."'>". $listaccount->getPhone() ."</a></td>
                  <input name='phone' type='hidden' value='". $listaccount->getPhone() ."'>
                  <td><a href='mailto:". $listaccount->getEmail() . "?Subject=[SKLV] ". $account->getfName() ." tässä hei!' target=_'top'>". $listaccount->getEmail() ."</a></td>
                  <input name='email' type='hidden' value='". $listaccount->getEmail() ."'>
                  <td class='role-value'>". $listaccount->getRole() ."</td>
                  <input name='role' type='hidden' value='". $listaccount->getRole() ."'>
                  <input name='passwd' type='hidden' value=''>
                  <input name='passwd2' type='hidden' value=''>
                  <td><button class='btn btn-warning btn-xs' type='submit' name='editAccount'>Muokkaa</td>
                  <td><button class='btn btn-danger btn-xs' type='submit' name='deleteAccount'>Poista</td>
                  </tr>
                  </form>");
}
} catch (Exception $error) {
  print($error->getMessage());
}
} else {

  try
  {
   require_once "classes/accountPDO.php";
   $usedb = new accountPDO();
   $result = $usedb->allAccounts();

   foreach($result as $listaccount) {
    print("
      <tr>
      <td>". $listaccount->getfName() ."</td>
      <td>". $listaccount->getlName() ."</td>
      <td><a href='tel:". $listaccount->getPhone() ."'>". $listaccount->getPhone() ."</a></td>
      <td><a href='mailto:". $listaccount->getEmail() . "?Subject=[SKLV] ". $account->getfName() ." tässä hei!' target=_'top'>". $listaccount->getEmail() ."</a></td>
      <td class='role-value'>". $listaccount->getRole() ."</td>
      <td></td>
      <td></td>
      </tr>");
  }
} catch (Exception $error) {
  print($error->getMessage());
}

}
?>

</table>
</div>

<?php if($_SESSION["account"]->getRole() == 1){
  print("
    <div class='row'>
    <div class='col-sm-12 col-md-12'>
    <div class='thumbnail'>
    <!--<img data-src='holder.js/300x200' alt='...'>-->
    <div class='caption'>
    <h3 class='text-center'>Uuden tilin luonti</h3>
    <!--<p></p>-->
    <p><a href='accnew.php' class='btn btn-primary btn-lg center-block' role='button'>Luo uusi tili</a>
    </div>
    </div>
    </div>
  </div> "); } ?>

</div>
        <!--<div class="col-md-4">
      </div>-->
    </div>
  </div>
</div>
<script src="js/rolehelper.js" type="text/javascript"></script>
<script>
$(function(){

  var rh = new RoleHelper();
  rh.checkRoleValue();

});
</script>

</body>
</html>

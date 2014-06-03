<?php
require_once "classes/account.php";
require_once "classes/acclist.php";
session_start();
$acclist = new AccountList();

if (isset($_SESSION["account"])){
  $account = $_SESSION["account"];

/*
  if(isset($_POST["editAccount"])){
    $editaccount = new Account( $_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["email"], $_POST["passwd"], $_POST["passwd2"], $_POST["role"], $_POST["id"]);
    $_SESSION["editAccount"] = $editaccount;
    header("location: accedit.php");
    exit;
  }
/*
  if(isset($_POST["editAccount"])){
    $editaccount = new Account( $_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["email"], $_POST["passwd"], $_POST["passwd2"], $_POST["role"], $_POST["id"]);
     // header("location: accedit.php");
     // exit;

    //if($fnameError == 0 && $lnameError == 0 && $phoneError == 0 && $emailError == 0 && $passwdError == 0 && $passwd2Error == 0 && $roleError == 0){
      
      /*$_SESSION["editaccount"] = $editaccount;
      session_write_close();
      header("location: accedit.php");
      exit; }*/
    
  /*}

  if(isset($_POST["deleteAccount"])){
    $deleteaccount = new Account( $_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["email"], $_POST["passwd"], $_POST["passwd2"], $_POST["role"], $_POST["id"]);
    //if($fnameError == 0 && $lnameError == 0 && $phoneError == 0 && $emailError == 0 && $passwdError == 0 && $passwd2Error == 0 && $roleError == 0){
      
      /*
      $_SESSION["deleteaccount"] = $deleteaccount;
      session_write_close();
      header("location: accconfirm.php");
      exit;
       }*/
    
  
} else {
  header("location: index.php");
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
             <form method="post" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="" name="searchfield">
              </div>
              <button type="submit" class="btn btn-default btn-sm" name="search" id="search">Hae</button>

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
            <tbody>

              <?php
              if (isset($_POST["search"]) && $account->getRole() == 1) {
                $acclist->searchAccountsAdmin();
              }
              ?>

              <?php
              if (isset($_POST["search"]) && $account->getRole() == 0) {
                $acclist->searchAccountsNormal();
              } 
              ?>

              <?php
              if(isset($_POST["search"]) == false && $account->getRole() == 1){
                $acclist->listAccountsAdmin();
              } else if(isset($_POST["search"]) == false && $account->getRole() == 0){
                $acclist->listAccountsNormal();
              }
              ?>
            </tbody>
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

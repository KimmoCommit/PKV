<?php
require_once "core/init.php";
$acclist = new AccountList();

if (isset($_SESSION["account"])){
  $account = $_SESSION["account"];
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
          <div class="row">
            <div class="col-md-9">
              <div class="row">
                <h1 style="padding-bottom:2%;padding-left:1%;">Henkilöt</h1>
              </div>
              <form method="post" role="search" style="padding-bottom:2%;">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="" name="searchfield">
                </div>
                <button type="submit" class="btn btn-default btn-sm" name="search" id="search">Hae</button>
              </form>
            </div>
            <div class="col-md-3">
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
                } else if (isset($_POST["search"]) == false && $account->getRole() == 0){
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

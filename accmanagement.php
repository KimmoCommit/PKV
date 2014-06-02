<?php
require_once "classes/account.php";
session_start();

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
                <td><button class='btn btn-warning btn-xs'>Muokkaa</td>
                <td><button class='btn btn-danger btn-xs'>Poista</td>
                </tr>");
            }
          } catch (Exception $error) {
            print($error->getMessage());
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

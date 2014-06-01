<?php
require_once "account.php";
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
<?php require 'head.php'; ?>
<body>
  <?php require 'includes/nav.php'; ?>
  <div class="content-container">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">

          <div class="row">
            <div class="col-sm-12 col-md-12">
              <div class="thumbnail">
                <!--<img data-src="holder.js/300x200" alt="...">-->
                <div class="caption">
                  <h3 class="text-center">Uuden tilin luonti</h3>
                  <!--<p></p>-->
                  <p><a href="accnew.php" class="btn btn-primary btn-lg center-block" role="button">Luo uusi tili</a>
                  </div>
                </div>
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

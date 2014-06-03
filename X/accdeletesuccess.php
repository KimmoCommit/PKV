<?php 
header("Refresh: 3; URL=accmanagement.php");
?>
<?php 
include 'includes/logout-module.php';
?>
<!DOCTYPE html>
<html lang="fi">
<?php require 'includes/head.php'; ?>
<body>
  <?php include 'includes/nav.php'; ?>
  <div class="content-container">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
          <div class="panel panel-default login-panel">
            <div class="panel-body">
              <div class="alert alert-success">Käyttäjän poisto onnistui!</div>
              <p style="font-size:80%">Siirrytään noin viiden (3) sekunnin kuluttua takaisin henkiöihin..</p>
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

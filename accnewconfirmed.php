<?php 
header("Refresh: 5; URL=accmanagement.php");
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
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
          <div class="panel panel-default login-panel">
            <div class="panel-body">
              <div class="alert alert-success">Käyttäjän luonti onnistui!</div>
              <p style="font-size:80%">Siirrytään noin viiden (5) sekunnin kuluttua takaisin henkiöihin..</p>
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

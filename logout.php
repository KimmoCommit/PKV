<?php 
  header("Refresh:5 URL=index.php");
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
              <div class="alert alert-info">Kirjauduit ulos järjestelmästä</div>
              <p style="font-size:80%">Siirrytään etusivulle noin viiden (5) sekunnin kuluttua..</p>
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

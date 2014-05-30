<?php
require_once "account.php";
  session_start();

if (isset($_POST["login"])) {
  try
  {
    require_once "accountPDO.php";
    //$passwd = $_POST["passwd"];
   // $email = $_POST["email"];
    $usedb = new AccountPDO();
    $result = $usedb->loginAccount($_POST["passwd"], $_POST["email"]);

    
  } catch (Exception $error) {
    print($error->getMessage());


  }

  $_SESSION["account"] = $result;
  header("location: index.php");
  exit;
}


if (isset($_SESSION["account"])){
  $account = $_SESSION["account"];
}

?>

<!DOCTYPE html>
<html lang="fi">
<?php 
require 'head.php';
?>
<body>

  <nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">SKLV-järjestelmä</a>
      </div>


      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">Link</a></li>
          <li><a href="#">Link</a></li> 
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li><a href="#">Link</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>


  <div class="content-container">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
          <div class="panel panel-default login-panel">
            <div class="panel-heading">
              <h3 class="panel-title">Kirjautuminen</h3>
              <?php
              if(isset($_SESSION["account"])){
                print("SESSIOSSA ON JTN");


              }
              else {
                print("ei löydy mtn");
              }

               ?>
            </div>
            <div class="panel-body">
              <form accept-charset="UTF-8" role="form" method="post">
                <fieldset>
                  <div class="form-group">
                    <input class="form-control" placeholder="Sähköposti" name="email" type="text">
                  </div>
                  <div class="form-group">
                    <input class="form-control" placeholder="Salasana" name="passwd" type="password" value="">
                  </div>
                  <div class="checkbox">
                    <label>
                      <input name="remember" type="checkbox" value="Remember Me"> Muista käyttäjätunnus
                    </label>
                  </div>
                  <input class="btn btn-lg btn-success btn-block" type="submit" value="Kirjaudu sisään" name="login">
                </fieldset>
              </form>
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

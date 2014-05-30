<?php
require_once "account.php";
session_start();


if(isset($_POST["korjaa"])){
  $registration = $_SESSION["registration"];
  session_write_close();
  header("location: register.php");
  exit;
}

if(isset($_POST["peruuta"])) {
  $_SESSION = array();
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
      );
  }
  session_destroy(); 
  header("location: index.php");
  exit;
}

if(isset($_POST["confirm"])){
  try
  {
    require_once "accountPDO.php";
    $account = $_SESSION["newaccount"];
    $usedb = new AccountPDO();
    $id = $usedb->addAccount($account);
    $account->setId($id);
    
  } catch (Exception $error) {
    print($error->getMessage());
    

  }
  
  unset($_SESSION["newaccount"]);
  header("location: confirmed.php");
  exit;
}

if(isset($_SESSION["newaccount"])){
  $account = $_SESSION["newaccount"];
} else {
  header("location: index.php");
  exit;
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
              <h3 class="panel-title">Tietojen varmistaminen</h3>
            </div>
            <div class="panel-body">
             <form method="post">
              <table class="table-condensed confirm-table">
                <tr>
                  <td>Etunimi:</td><td><?php print($account->getfName()); ?> </td>
                </tr>
                <tr>
                  <td>Sukunimi:</td><td><?php print($account->getlName()); ?> </td>
                </tr>
                <tr>
                  <td>Puhelinnumero:</td><td><?php print($account->getPhone()); ?> </td>
                </tr>
                <tr>
                  <td>Sähköposti:</td><td><?php print($account->getEmail()); ?></td>
                </tr>
                <tr>
                  <td>Salasana:</td><td> <?php print($account->getPasswd()); ?></td>
                </tr>
                <tr>
                  <td>Rooli:</td><td> <?php print($account->getRole()); ?></td>
                </tr>
              </table>
              <button name="confirm" type="submit" class="btn btn-default btn-sm">Tallenna</button>
              <button name="korjaa" type="submit" class="btn btn-default btn-sm">Korjaa</button>
              <button name="peruuta" type="submit" class="btn btn-default btn-sm">Peruuta</button>
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

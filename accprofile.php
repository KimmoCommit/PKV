<?php
require_once "core/init.php";


if (isset($_SESSION["account"])){
  $account = $_SESSION["account"];
} else {
  header("location: index.php");
}

if(isset($_SESSION["updateaccount"])){
  $theaccount = $_SESSION["updateaccount"];
} else if(isset($_SESSION["account"])){
  $theaccount = $_SESSION["account"];
}

if (isset($_POST["revert"])) {
  unset($_SESSION["updateaccount"]);
  header("location: accprofile.php");
  exit;
}

if (isset($_POST["updateAccount"])) {
  $updateaccount = new Account( $_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["email"], $_POST["passwd"], $_POST["passwd2"], $account->getRole(), $account->getId());
  $fnameError = $updateaccount->checkfName();
  $lnameError = $updateaccount->checklName();
  $phoneError = $updateaccount->checkPhone();
  $emailError = $updateaccount->checkEmail();
  $passwdError = $updateaccount->checkPasswd();
  $passwd2Error = $updateaccount->checkPasswd2();
  $roleError = $updateaccount->checkRole();

  if($fnameError == 0 && $lnameError == 0 && $phoneError == 0 && $emailError == 0 && $passwdError == 0 && $passwd2Error == 0 && $roleError == 0){

   try
   {
    $usedb = new AccountPDO();
    $usedb->updateAccount($theaccount);

  } catch (Exception $error) {
    print($error->getMessage());

  }

  $message = new Message();
  $messagetitle = "Profiilisi tietojen päivitys onnistui!";
  $messagebody = "Siirrytään etusivulle noin kolmen (3) sekunnin kuluttua..";
  $message->setMessageTitle($messagetitle);
  $message->setMessageBody($messagebody);
  $_SESSION["updateAccount"] = $message;
  session_write_close();
  header("location: message.php");

}

}

else {

  $fnameError =  0;
  $lnameError =  0;
  $phoneError = 0;
  $emailError = 0;
  $passwdError = 0;
  $passwd2Error = 0;
  $roleError = 0;
}

?>

<?php require 'includes/logout-module.php'; ?>

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
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Profiilin tiedot</h3>
            </div>
            <div class="panel-body">
              <form accept-charset="UTF-8" role="form" method="post">
                <fieldset>
                  <div class="form-group">
                    <!--<input type="hidden" name="id" value="<?php print($account->getId());?>">-->
                    <label>Etunimi</label> 
                    <input class="form-control"  name="fname" type="text" value="<?php print(htmlentities($theaccount->getfName(), ENT_QUOTES, "UTF-8"));?>">

                    <?php
                    print("<div class='custom-alert'>" . $theaccount->getError($fnameError) . "</div>");
                    ?> 

                  </div>
                  <div class="form-group">
                    <label>Sukunimi</label> 
                    <input class="form-control"  name="lname" type="text" value="<?php print(htmlentities($theaccount->getlName(), ENT_QUOTES, "UTF-8"));?>">

                    <?php
                    print("<div class='custom-alert'>" . $theaccount->getError($lnameError) . "</div>");
                    ?> 

                  </div>
                  <div class="form-group">
                    <label>Puhelinnumero</label> 
                    <input class="form-control"  name="phone" type="text" value="<?php print(htmlentities($theaccount->getPhone(), ENT_QUOTES, "UTF-8"));?>">
                    <?php
                    print("<div class='custom-alert'>" . $theaccount->getError($phoneError) . "</div>");
                    ?> 
                  </div>
                  <div class="form-group">
                    <label>Sähköposti</label> 
                    <input class="form-control"  name="email" type="text" value="<?php print(htmlentities($theaccount->getEmail(), ENT_QUOTES, "UTF-8"));?>">
                    <?php
                    print("<div class='custom-alert'>". $theaccount->getError($emailError) . "</div>");
                    ?> 
                  </div>

                  <div class="form-group">
                    <label>Salasana</label> 
                    <input class="form-control"  name="passwd" autocomplete="off" type="password" value="">
                    <?php
                    print("<div class='custom-alert'>". $theaccount->getError($passwdError) . "</div>");
                    ?> 
                  </div>
                  <div class="form-group">
                    <label>Vahvista salasana</label> 
                    <input class="form-control"  name="passwd2" autocomplete="off" type="password" value="">
                    <?php
                    print("<div class='custom-alert'>". $theaccount->getError($passwd2Error) . "</div>");
                    ?> 
                  </div>
                  <!-- <input id="role"  class="form-control" name="role" type="hidden" value="<?php print($theaccount->getRole()); ?>">-->


                </div> 
                <button class="btn btn-lg btn-success btn-block" type="button" name="updateAccount" data-toggle="modal" data-target="#updateAcc">Päivitä</button> 
                <button class="btn btn-lg btn-warning btn-block" type="submit" name="revert" >Palauta</button> 
              </fieldset>



              <div class='modal fade' id="updateAcc" tabindex='-1' role='dialog' aria-labelledby='accEditLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                      <h4 class='modal-title' id='accEditLabel'>Vahvista tilitietojen muutokset</h4>
                    </div>
                    <div class='modal-body'>
                      Tallenna tilin muutokset?
                    </div>
                    <div class='modal-footer'>

                      <button type='button' class='btn btn-default ' data-dismiss='modal' style="margin-bottom:5px;">Peruuta</button>
                      <button class='btn btn-success ' type='submit' name='updateAccount' style="margin-bottom:5px;">Tallenna</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
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

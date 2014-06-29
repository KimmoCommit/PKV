<?php 
require_once 'core/init.php';
$message = new Message();	

if (isset($_SESSION["account"]) && $_SESSION["account"]->getRole() == 1){
	$newaccount = new Account();
	$fnameError = 0;
	$lnameError = 0;
	$phoneError = 0;
	$emailError = 0;
	$passwdError = 0;
	$passwd2Error = 0;
	$roleError = 0;
	$account = $_SESSION["account"];
} else {
	header("location index.php");
	exit;
}

if (isset($_POST["createAccount"])) {	

	$newaccount = new Account( $_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["email"], $_POST["passwd"], $_POST["passwd2"], $_POST["role"]);
	$fnameError = $newaccount->checkfName();
	$lnameError = $newaccount->checklName();
	$phoneError = $newaccount->checkPhone();
	$emailError = $newaccount->checkEmail();
	$passwdError = $newaccount->checkPasswd();
	$passwd2Error = $newaccount->checkPasswd2();
	$roleError = $newaccount->checkRole();

	try
	{
		$usedb = new AccountPDO();
		$email = $_POST["email"];
		$result = $usedb->findEmail($email);

	} catch (Exception $error) {
		print($error->getMessage());
	}

	if( $result != null ){
		$message->setMessageBody("Käyttäjätunnus tällä sähköpostilla löytyy järjestelmästä");
	} else {

		if($fnameError == 0 && $lnameError == 0 && $phoneError == 0 && $emailError == 0 && $passwdError == 0 && $passwd2Error == 0 && $roleError == 0){
			try
			{
				$usedb = new AccountPDO();
				$id = $usedb->addAccount($newaccount);
				$newaccount->setId($id);

			} catch (Exception $error) {
				print($error->getMessage());
			}
			$message = new Message();
			$messagetitle = "Uuden käyttäjän luonti onnistui!";
			$messagebody = "Siirrytään takaisin henkilöihin noin kolmen (3) sekunnin kuluttua..";
			$message->setMessageTitle($messagetitle);
			$message->setMessageBody($messagebody);

			$_SESSION["createAccount"] = $message;
			session_write_close();
			header("location: message.php");
			exit;
		}

	}

}

if (isset($_POST["empty"])) {
	unset($_SESSION["newaccount"]);
	header("location: accnew.php");
	exit;
}

if (isset($_POST["back"])) {
	unset($_SESSION["newaccount"]);
	header("location: accmanagement.php");
	exit;
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
				<div class="col-md-4">
				</div>
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Uuden käyttäjätilin tiedot</h3>
						</div>
						<div class="panel-body">
							<form accept-charset="UTF-8" role="form" method="post">
								<fieldset>
									<div class="form-group">
										<label>Etunimi</label> 
										<input class="form-control"  name="fname" type="text" value="<?php print(htmlentities($newaccount->getfName(), ENT_QUOTES, "UTF-8"));?>">
										<?php
										print("<div class='custom-alert'>" . $newaccount->getError($fnameError) . "</div>");
										?> 
									</div>
									<div class="form-group">
										<label>Sukunimi</label> 
										<input class="form-control"  name="lname" type="text" value="<?php print(htmlentities($newaccount->getlName(), ENT_QUOTES, "UTF-8"));?>">
										<?php
										print("<div class='custom-alert'>" . $newaccount->getError($lnameError) . "</div>");
										?> 
									</div>
									<div class="form-group">
										<label>Puhelinnumero</label> 
										<input class="form-control"  name="phone" type="text" value="<?php print(htmlentities($newaccount->getPhone(), ENT_QUOTES, "UTF-8"));?>">
										<?php
										print("<div class='custom-alert'>" . $newaccount->getError($phoneError) . "</div>");
										?> 
									</div>
									<div class="form-group">
										<label>Sähköposti</label> 
										<input class="form-control"  name="email" type="text" value="<?php print(htmlentities($newaccount->getEmail(), ENT_QUOTES, "UTF-8"));?>">
										<?php
										print("<div class='custom-alert'>". $newaccount->getError($emailError) . "</div>");
										?> 
										<?php
										if (isset($_POST["createAccount"])){
											print("<div class='custom-alert'>". $message->getMessageBody() . "</div>");
										}
										?> 
									</div>

									<div class="form-group">
										<label>Salasana</label> 
										<input class="form-control"  name="passwd" type="password" autocomplete="off" value="<?php print(htmlentities($newaccount->getPasswd(), ENT_QUOTES, "UTF-8"));?>">
										<?php
										print("<div class='custom-alert'>". $newaccount->getError($passwdError) . "</div>");
										?> 
									</div>
									<div class="form-group">
										<label>Vahvista salasana</label> 
										<input class="form-control"  name="passwd2" type="password" autocomplete="off" value="<?php print(htmlentities($newaccount->getPasswd2(), ENT_QUOTES, "UTF-8"));?>">
										<?php
										print("<div class='custom-alert'>". $newaccount->getError($passwd2Error) . "</div>");
										?> 
									</div>
									<div class="form-group">
										<label>Rooli</label> 
										<div class="btn-group btn-group-justified">
											<div class="btn-group">
												<button type="button" class="role-button-hyllyttaja btn btn-default role-button btn-xs " value="0">Hyllyttäjä</button>
											</div>
											<div class="btn-group">
												<button type="button" class="role-button-hallinnoitsija btn btn-default role-button btn-xs " value="1">Hallinnoitsija</button>
											</div>
										</div>
										<input id="role"  class="form-control" name="role" type="hidden" value="<?php if(isset($_SESSION["newaccount"])){print($newaccount->getRole()); }else{print(0);}?>">
										<?php
										print("<div class='custom-alert'>". $newaccount->getError($roleError) . "</div>");
										?> 
									</div>
								</div> 
								<button class="btn btn-lg btn-success btn-block" type="button"  data-toggle="modal" data-target="#createAccount">Luo tili </button>
								<button class="btn btn-lg btn-warning btn-block" type="submit" name="empty">Tyhjennä</button>
								<button class="btn btn-lg btn-block" type="submit" name="back">Takaisin</button>
							</fieldset>


							<div class='modal fade' id="createAccount" tabindex='-1' role='dialog' aria-labelledby='accCreateLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class='modal-header'>
											<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
											<h4 class='modal-title' id='accCreateLabel'>Vahvista tilin luonti</h4>
										</div>
										<div class='modal-body'>
											Vahvistetaanko tilin luonti?
										</div>
										<div class='modal-footer'>
											<button type='button' class='btn btn-default ' data-dismiss='modal' style="margin-bottom:5px;">Peruuta</button>
											<button class='btn btn-success' type='submit' name="createAccount" style="margin-bottom:5px;">Vahvista</button>
										</div>
									</div>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
			<div class="col-md-4">
			</div>
		</div>
	</div>
</div>

<script src="js/rolehelper.js" type="text/javascript"></script>
<script>
$(function(){
	var rh = new RoleHelper();
	rh.checkRole();
	rh.selectRole();
});
</script>

</body>
</html>

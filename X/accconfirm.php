<?php
require_once "classes/account.php";
session_start();

$theaccount = new Account();

//INITIAL CHECK TO SEE WE ARE LOGGED IN AND WE ARE ADMINISTRATORS
if(isset($_SESSION["account"]) && $_SESSION["account"]->getRole() == 1){
	$account = $_SESSION["account"];
} else if ($_SESSION["account"] == false){
	header("location index.php");
} 


//UPDATE ACCOUNT




//EDITING ACCOUNT
if(isset($_SESSION["editAcc"])) {
	// && isset($_SESSION["newAcc"]) == false 
	$theaccount = $_SESSION["editAcc"];
	function showContent(){
		print('
			<button name="editAcc" formaction="messagesuccess.php" type="submit" class="btn btn-default  btn-success btn-block">Tallenna</button>
			<button name="editEditAcc" type="submit" formaction="accnew.php" class="btn btn-default  btn-warning btn-block">Muokkaa</button> 
			<button name="goBack" type="submit" formaction="accmanagement.php" class="btn btn-default  btn-warning btn-block">Peruuta</button> 
			');
	}
}

//ADDING ACCOUNT
if(isset($_SESSION["newAcc"])){
	// && isset($_SESSION["editAcc"]) == false 
	$theaccount = $_SESSION["newAcc"];
	function showContent(){
		print('
			<button name="createNewAcc" formaction="messagesuccess.php" type="submit" class="btn btn-default  btn-success btn-block">Tallenna</button>
			<button name="editNewAcc" type="submit" formaction="accnew.php" class="btn btn-default  btn-warning btn-block">Muokkaa</button> 
			');
	}
}


//DELETING ACCOUNT
if(isset($_POST["deleteAccount"])){
	$theaccount = new Account($_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["email"], $_POST["passwd"], $_POST["passwd2"], $_POST["role"], $_POST["id"]);
	function showContent(){
		print('
			<input type="hidden" name="passwd" value="">
			<input type="hidden" name="passwd2" value="">
			<button name="confirmDelete" formaction="messagesuccess.php" type="submit" class="btn btn-default  btn-danger btn-block">Poista</button>
			<button name="back" type="submit" class="btn btn-default  btn-block">Takaisin</button> 
			');
	}
}


if($theaccount->getfName() == null){
	header("location: accmanagement.php");
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
					<div class="panel panel-default login-panel">
						<div class="panel-heading">
							<h3 class="panel-title">
								<?php	if(isset($_SESSION["newAcc"])){
									print("Uuden tilin ". $theaccount->getEmail() ." luonnin varmistus");
								}
								if(isset($_POST["deleteAccount"])){
									print("Varmista tilin ". $theaccount->getEmail() . " poisto");
								}
								?>

							</h3>
						</div>
						<div class="panel-body">
							<form method="post">
								<table class="table-condensed confirm-table">
									<input type="hidden" name="id" value="<?php print($theaccount->getId()); ?>">

									<tr>
										<td>Etunimi:</td><td><?php print($theaccount->getfName()); ?> </td>
										<input type="hidden" name="fname" value="<?php print($theaccount->getfName() ); ?>">
									</tr>
									<tr>
										<td>Sukunimi:</td><td><?php print($theaccount->getlName()); ?> </td>
										<input type="hidden" name="lname" value="<?php print($theaccount->getlName() ); ?>">
									</tr>
									<tr>
										<td>Puhelinnumero:</td><td><?php print($theaccount->getPhone()); ?> </td>
										<input type="hidden" name="phone" value="<?php print($theaccount->getPhone() ); ?>">
									</tr>
									<tr>
										<td>Sähköposti:</td><td><?php print($theaccount->getEmail()); ?></td>
										<input type="hidden" name="email" value="<?php print($theaccount->getEmail() ); ?>">
									</tr>
									<tr>
										<td>Rooli:</td><td class="role-value"><?php print($theaccount->getRole()); ?></td>
										<input type="hidden"  name="role" value="<?php print($theaccount->getRole()); ?>">
									</tr>

									<?php 
									//PRINTING THE PASSWORD ONLY FOR ADMINS AND IF WE HAVE A STORED A NEW ACCOUNT TO SESSION
									if( $account->getRole() == 1 && isset($_SESSION["newAcc"])){
										print('	
											<tr>
											<td>Salasana:</td><td>'. $theaccount->getPasswd() .'</td>
											<input type="hidden" name="passwd" value='. $theaccount->getPasswd() .'>
											<input type="hidden" name="passwd2" value='. $theaccount->getPasswd2() .'>
											</tr>
											');
										}?>

									</table><br/>
									<?php 
									//CHECKING TO SEE IF WE CAME FROM PAGE accountmanagement.php BY PRESSING deleteAccount AND PRINTING BUTTONS FOR THE TASKS
									if(isset($_POST["deleteAccount"])){ 	
										showContent();
									}
									if(1 == 0 ){	
										print('
											<input type="hidden" name="passwd" value='. $theaccount->getPasswd() .'>
											<input type="hidden" name="passwd2" value='. $theaccount->getPasswd2() .'>
											<button name="editAccConfirm" formaction="messagesuccess.php" type="submit" class="btn btn-default  btn-success btn-block">Tallenna</button>
											<button name="fixEdit" type="submit" formaction="accedit.php" class="btn btn-default  btn-warning btn-block">fixEdit</button> 
											');
									} 	
									if(isset($_SESSION["newAcc"])){
										showContent();
										unset($_SESSION["newAcc"]);
										session_write_close();	
									}
									if(isset($_SESSION["editAcc"])){
										showContent();
										unset($_SESSION["editAcc"]);
										session_write_close();	
									}



									if(isset($_SESSION["updateAccount"]))
									{	
										print('
											<button name="confirmUpdate" type="submit" class="btn btn-default  btn-success btn-block">Tallenna</button>
											<button name="fixUpdate"  type="submit" class="btn btn-default  btn-warning btn-block">Korjaa</button> 
											');
										}?>
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
				rh.checkRoleTD();

			});
			</script>

		</body>
		</html>

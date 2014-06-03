<?php
require_once "classes/account.php";
session_start();

if(isset($_SESSION["account"])){
	$account = $_SESSION["account"];

	/** DELETE **/
	if (isset($_POST["deleteAccount"])){
		$theaccount = new Account( $_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["email"], $_POST["passwd"], $_POST["passwd2"], $_POST["role"], $_POST["id"]);
	} 

		if(isset($_POST["back"])){
			header("location: accmanagement.php");
			exit;
		}

		if (isset($_POST["confirmDelete"])){
			$theaccount = new Account( $_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["email"], $_POST["passwd"], $_POST["passwd2"], $_POST["role"], $_POST["id"]);

			try
			{
				require_once "classes/accountPDO.php";

				$usedb = new AccountPDO();
				$id = $theaccount->getId();
				$usedb->deleteAccount($id);

			} catch (Exception $error) {
				print($error->getMessage());
			}

			$_SESSION["deletesuccess"] = "deletesuccess";
			header("location: messagesuccess.php");
			exit;
		}



	/** NEW **/
	if(isset($_SESSION["newaccount"]) && $account->getRole() == 1){
		$theaccount = $_SESSION["newaccount"];

		if(isset($_POST["fix"])){
			$editaccount = new Account( $_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["email"], $_POST["passwd"], $_POST["passwd2"], $_POST["role"], $_POST["id"]);
			$_SESSION["editAccount"] = $editaccount;
			header("location: accnew.php");
			exit;
		}

		if(isset($_POST["confirm"])){
			try
			{
				require_once "classes/accountPDO.php";
				$newaccount = $_SESSION["newaccount"];
				$usedb = new AccountPDO();
				$id = $usedb->addAccount($newaccount);
				$newaccount->setId($id);

			} catch (Exception $error) {
				print($error->getMessage());
			}

			unset($_SESSION["newaccount"]);
			header("location: messagesuccess.php");
			exit;
		}


	}


	/** UPDATE **/
	if(isset($_SESSION["updateaccount"])){
		$theaccount = $_SESSION["updateaccount"];

		if(isset($_POST["fix"])){
			$editaccount = new Account( $_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["email"], $_POST["passwd"], $_POST["passwd2"], $_POST["role"], $_POST["id"]);
			$_SESSION["editAccount"];
			header("location: accprofile.php");
			exit;
		}

		if(isset($_POST["confirm"])){
			try
			{
				require_once "classes/accountPDO.php";
				$theaccount = $_SESSION["updateaccount"];
				$usedb = new AccountPDO();
				$usedb->updateAccount($theaccount);


			} catch (Exception $error) {
				print($error->getMessage());


			}
			$_SESSION["account"] = $theaccount;
			unset($_SESSION["theaccount"]);
			$_SESSION["updatesuccess"] = "updatesuccess";
			header("location: messagesuccess.php");
			exit;

		} 
	}

	/** EDIT **/
	if(isset($_SESSION["editAccount"])){
		$theaccount = $_SESSION["editAccount"];

		if(isset($_POST["fix"])){
			header("location: accedit.php");
			exit;
		}

		if(isset($_POST["confirm"])){
			try
			{
				require_once "classes/accountPDO.php";
				$theaccount = $_SESSION["editAccount"];
				$usedb = new AccountPDO();
				$usedb->updateAccount($theaccount);


			} catch (Exception $error) {
				print($error->getMessage());


			}

			$_SESSION["editsuccess"] = "editsuccess";
			header("location: messagesuccess.php");
			exit;

		} 
	}



} else {
	header("location: index.php");
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
							<h3 class="panel-title">Muokkauksen varmistaminen</h3>
						</div>
						<div class="panel-body">
							<form method="post">
								<table class="table-condensed confirm-table">
									<input type="hidden" name="id" value="<?php print($theaccount->getId()); ?>">
									<tr>
										<td>Etunimi:</td><td><?php print($theaccount->getfName()); ?> </td>
									</tr>
									<tr>
										<td>Sukunimi:</td><td><?php print($theaccount->getlName()); ?> </td>
									</tr>
									<tr>
										<td>Puhelinnumero:</td><td><?php print($theaccount->getPhone()); ?> </td>
									</tr>
									<tr>
										<td>Sähköposti:</td><td><?php print($theaccount->getEmail()); ?></td>
									</tr>
									<tr>
										<td>Rooli:</td><td class="role-value"> <?php print($theaccount->getRole()); ?></td>
									</tr>
								</table><br/>
								<?php if(isset($_POST["deleteAccount"]))
								{ 	
									print('
										<button name="confirmDelete" action="messagesuccess.php" type="submit" class="btn btn-default  btn-danger btn-block">Poista</button>
										<button name="back" type="submit" class="btn btn-default  btn-block">Takaisin</button> 
										');
									}?>
									<?php if(isset($_SESSION["editAccount"]))
									{	
										print('
											<button name="confirm" type="submit" class="btn btn-default  btn-success btn-block">Tallenna</button>
											<button name="fix" type="submit" class="btn btn-default  btn-warning btn-block">Korjaa</button> 
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

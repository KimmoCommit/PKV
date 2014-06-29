<?php
require_once "core/init.php";
class AccountList {

	function searchAccountsNormal(){
		try {

			$usedb = new AccountPDO();
			$result = $usedb->findAccounts($_POST["searchfield"]);
			if(count($result) == 0 ){
				print("
					<h3> Yhtään hakutulosta ei löytynyt haulle: " . $_POST["searchfield"] . " </h3>
					");
			}

			else if($_POST["searchfield"] == ""){
				header("location: accmanagement.php");
			}
			else {
				print("<h3>Hakutulokset haulle: " . $_POST["searchfield"] . "</h3>");
				foreach($result as $listaccount) {
					print("
						<tr>
						<td>". $listaccount->getfName() ."</td>
						<td>". $listaccount->getlName() ."</td>
						<td><a href='tel:". $listaccount->getPhone() ."'>". $listaccount->getPhone() ."</a></td>
						<td><a href='mailto:". $listaccount->getEmail() . "?Subject=[SKLV] ". $_SESSION["account"]->getfName() ." tässä hei!' target=_'top'>". $listaccount->getEmail() ."</a></td>
						<td class='role-value'>". $listaccount->getRole() ."</td>
						<td></td>
						<td></td>
						</tr>
						");
				}
			}
		}
		catch (Exception $error){
			print($error->getMessage());
		}
	}

	function searchAccountsAdmin(){
		try {

			$usedb = new AccountPDO();
			$result = $usedb->findAccounts($_POST["searchfield"]);
			if(count($result) == 0 ){
				print("
					<h3> Yhtään hakutulosta ei löytynyt </h3>
					");
			}

			else if($_POST["searchfield"] == ""){
				header("location: accmanagement.php");
			}
			else {
				print("<h3>Hakutulokset haulle: " . $_POST["searchfield"] . "</h3>");
				$dataTarget = 0;
				foreach($result as $listaccount) {
					$dataTarget = $dataTarget + 1;
					print("
						<form method='post' action='accedit.php' name='acclist'>
						<input type='hidden' name='id' value='". $listaccount->getId() . "''>
						<tr>
						<td>". $listaccount->getfName() ."</td>
						<input name='fname' type='hidden' value='". $listaccount->getfName() ."'>
						<td>". $listaccount->getlName() ."</td>
						<input name='lname' type='hidden' value='". $listaccount->getlName() ."'>
						<td><a href='tel:". $listaccount->getPhone() ."'>". $listaccount->getPhone() ."</a></td>
						<input name='phone' type='hidden' value='". $listaccount->getPhone() ."'>
						<td><a href='mailto:". $listaccount->getEmail() . "?Subject=[SKLV] ". $_SESSION["account"]->getfName() ." tässä hei!' target=_'top'>". $listaccount->getEmail() ."</a></td>
						<input name='email' type='hidden' value='". $listaccount->getEmail() ."'>
						<td class='role-value'>". $listaccount->getRole() ."</td>
						<input name='role' type='hidden' value='". $listaccount->getRole() ."'>
						<input name='passwd' type='hidden' value=''>
						<input name='passwd2' type='hidden' value=''>
						<td><button class='btn btn-warning btn-xs' type='submit' name='editAccount' formaction='accedit.php';return true;'>Muokkaa</button></td>
						<td><button class='btn btn-danger btn-xs'  type='button' data-toggle='modal' data-target='#deleteAcc". $dataTarget ."'>Poista</button></td>
						</tr>

						<div class='modal fade' id='deleteAcc". $dataTarget ."' tabindex='-1' role='dialog' aria-labelledby='accDeleteLabel' aria-hidden='true'>
						<div class='modal-dialog'>
						<div class='modal-content'>
						<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
						<h4 class='modal-title' id='accDeleteLabel'>Vahvista käyttäjän poisto</h4>
						</div>
						<div class='modal-body'>
						Poistetaanko käyttäjätili ". $listaccount->getEmail() ."?
						</div>
						<div class='modal-footer'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Peruuta</button>
						<button class='btn btn-danger' type='submit' name='deleteAccount' formaction='message.php'>Poista</button>
						</div>
						</div>
						</div>
						</div>


						</form>
						");
}
}
}
catch (Exception $error){
	print($error->getMessage());
}
}



function listAccountsAdmin(){
	try
	{

		$usedb = new AccountPDO();
		$result = $usedb->allAccounts();
		$dataTarget = 0;
		foreach($result as $listaccount) {
			$dataTarget = $dataTarget + 1;
			print("


				<form method='post' action='accedit.php'>

				<input type='hidden' name='id' value='". $listaccount->getId() . "''>
				<tr>
				<td>". $listaccount->getfName() ."</td>
				<input name='fname' type='hidden' value='". $listaccount->getfName() ."'>
				<td>". $listaccount->getlName() ."</td>
				<input name='lname' type='hidden' value='". $listaccount->getlName() ."'>
				<td><a href='tel:". $listaccount->getPhone() ."'>". $listaccount->getPhone() ."</a></td>
				<input name='phone' type='hidden' value='". $listaccount->getPhone() ."'>
				<td><a href='mailto:". $listaccount->getEmail() . "?Subject=[SKLV] ". $_SESSION["account"]->getfName() ." tässä hei!' target=_'top'>". $listaccount->getEmail() ."</a></td>
				<input name='email' type='hidden' value='". $listaccount->getEmail() ."'>
				<td class='role-value'>". $listaccount->getRole() ."</td>
				<input name='role' type='hidden' value='". $listaccount->getRole() ."'>
				<input name='passwd' type='hidden' value=''>
				<input name='passwd2' type='hidden' value=''>
				<td><button class='btn btn-warning btn-xs' name='editAccount' data-toggle='modal'>Muokkaa</button></td>
				<td><button class='btn btn-danger btn-xs'  type='button' data-toggle='modal' data-target='#deleteAcc". $dataTarget ."'>Poista</button></td>
				</tr>

				<div class='modal fade' id='deleteAcc". $dataTarget ."' tabindex='-1' role='dialog' aria-labelledby='accDeleteLabel' aria-hidden='true'>
				<div class='modal-dialog'>
				<div class='modal-content'>
				<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
				<h4 class='modal-title' id='accDeleteLabel'>Vahvista käyttäjän poisto</h4>
				</div>
				<div class='modal-body'>
				Poistetaanko käyttäjätili ". $listaccount->getEmail() ."?
				</div>
				<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Peruuta</button>
				<button class='btn btn-danger' type='submit' name='deleteAccount' formaction='message.php'>Poista</button>
				</div>
				</div>
				</div>
				</div>



				</form>
				");
}
} catch (Exception $error) {
	print($error->getMessage());
}
}

function listAccountsNormal(){
	try
	{

		$usedb = new accountPDO();
		$result = $usedb->allAccounts();

		foreach($result as $listaccount) {
			print("
				<tr>
				<td>". $listaccount->getfName() ."</td>
				<td>". $listaccount->getlName() ."</td>
				<td><a href='tel:". $listaccount->getPhone() ."'>". $listaccount->getPhone() ."</a></td>
				<td><a href='mailto:". $listaccount->getEmail() . "?subject=[SKLV]%20". $_SESSION["account"]->getfName() ."%20tässä%20hei!'>". $listaccount->getEmail() ."</a></td>
				<td class='role-value'>". $listaccount->getRole() ."</td>
				<td></td>
				<td></td>
				</tr>
				");
		}
	} catch (Exception $error) {
		print($error->getMessage());
	}
}
}



?>
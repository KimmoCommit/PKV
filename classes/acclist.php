<?php

class AccountList {

	function searchAccountsNormal(){
		try {
			require_once "classes/accountPDO.php";
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
			require_once "accountPDO.php";
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
				foreach($result as $listaccount) {
					print("
						<form method='post' action='' name='acclist'>
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
						<td><button class='btn btn-warning btn-xs' type='submit' name='editAccount' formaction='accedit.php';return true;'>Muokkaa</td>
						<td><button class='btn btn-danger btn-xs' type='submit' name='deleteAccount' formaction='accconfirm.php';return true;'>Poista</td>
						</tr>
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
		require_once "accountPDO.php";
		$usedb = new accountPDO();
		$result = $usedb->allAccounts();

		foreach($result as $listaccount) {
			print("
				<form method='post'>
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
				<td><button class='btn btn-warning btn-xs' type='submit' name='editAccount' formaction='accedit.php'>Muokkaa</td>
				<td><button class='btn btn-danger btn-xs' type='submit' name='deleteAccount' formaction='accconfirm.php'>Poista</td>
				</tr>
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
		require_once "classes/accountPDO.php";
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
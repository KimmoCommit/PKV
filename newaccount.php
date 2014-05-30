<?php 
require_once "account.php";
session_start();


if (isset($_POST["empty"])) {
	unset($_SESSION["newaccount"]);
	header("location: newaccount.php");
	exit;
}

if (isset($_POST["createAccount"])) {
	$account = new Account( $_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["email"], $_POST["passwd"], $_POST["passwd2"], $_POST["role"]);
	$fnameError = $account->checkfName();
	$lnameError = $account->checklName();
	$phoneError = $account->checkPhone();
	$emailError = $account->checkEmail();
	$passwdError = $account->checkPasswd();
	$passwd2Error = $account->checkPasswd2();
	$roleError = $account->checkRole();

	if($fnameError == 0 && $lnameError == 0 && $phoneError == 0 && $emailError == 0 && $passwdError == 0 && $passwd2Error == 0 && $roleError == 0){
		$_SESSION["newaccount"] = $account;
		session_write_close();
		header("location: confirmaccount.php");
		exit;
	}

}

else {

	if(isset($_SESSION["newaccount"])){
		$account = $_SESSION["newaccount"];
	} else {
		$account = new Account();

	}
	$fnameError =  0;
	$lnameError =  0;
	$phoneError = 0;
	$emailError = 0;
	$passwdError = 0;
	$passwd2Error = 0;
	$roleError = 0;
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
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Matti Administraattori <b class="caret"></b></a>
						<ul class="dropdown-menu">

							<li><a href="#">Luo uusi käyttäjä</a></li>
							
							<li class="divider"></li>
							<li><a href="#">Profiili</a></li>
							<li><a href="#">Asetukset</a></li>
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
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Luo uusi käyttäjätili</h3>
						</div>
						<div class="panel-body">
							<form accept-charset="UTF-8" role="form" method="post">
								<fieldset>
									<div class="form-group">
										<label>Etunimi</label> 
										<input class="form-control"  name="fname" type="text" value="<?php print(htmlentities($account->getfName(), ENT_QUOTES, "UTF-8"));?>">

										<?php
										print("<div class='custom-alert'>" . $account->getError($fnameError) . "</div>");
										?> 

									</div>
									<div class="form-group">
										<label>Sukunimi</label> 
										<input class="form-control"  name="lname" type="text" value="<?php print(htmlentities($account->getlName(), ENT_QUOTES, "UTF-8"));?>">

										<?php
										print("<div class='custom-alert'>" . $account->getError($lnameError) . "</div>");
										?> 

									</div>
									<div class="form-group">
										<label>Puhelinnumero</label> 
										<input class="form-control"  name="phone" type="text" value="<?php print(htmlentities($account->getPhone(), ENT_QUOTES, "UTF-8"));?>">
										<?php
										print("<div class='custom-alert'>" . $account->getError($phoneError) . "</div>");
										?> 
									</div>
									<div class="form-group">
										<label>Sähköposti</label> 
										<input class="form-control"  name="email" type="text" value="<?php print(htmlentities($account->getEmail(), ENT_QUOTES, "UTF-8"));?>">
										<?php
										print("<div class='custom-alert'>". $account->getError($emailError) . "</div>");
										?> 
									</div>

									<div class="form-group">
										<label>Salasana</label> 
										<input class="form-control"  name="passwd" type="password" value="<?php print(htmlentities($account->getPasswd(), ENT_QUOTES, "UTF-8"));?>">
										<?php
										print("<div class='custom-alert'>". $account->getError($passwdError) . "</div>");
										?> 
									</div>
									<div class="form-group">
										<label>Vahvista salasana</label> 
										<input class="form-control"  name="passwd2" type="password" value="<?php print(htmlentities($account->getPasswd2(), ENT_QUOTES, "UTF-8"));?>">
										<?php
										print("<div class='custom-alert'>". $account->getError($passwd2Error) . "</div>");
										?> 
									</div>

									<div class="form-group">
										<label>Rooli</label> 
										<div class="btn-group btn-group-justified">
											<div class="btn-group">
												<input type="button" id="role-button-hyllyttaja" class="btn btn-default role-button btn-xs active" value="Hyllyttäjä">
											</div>
													<div class="btn-group">
												<input type="button" id="role-button-hallinnoitsija" class="btn btn-default role-button  btn-xs" value="Hallinnoitsija">
											</div>
										</div>
										<input id="role"  class="form-control" name="role" type="hidden" value="<?php if(isset($_SESSION["newaccount"])){print(htmlentities($account->getRole(), ENT_QUOTES, "UTF-8")); }
										else{print('Hyllyttäjä');}?>">
										<?php
										print("<div class='custom-alert'>". $account->getError($roleError) . "</div>");
										?> 
									</div>
								</div> 

								<input class="btn btn-lg btn-success btn-block" type="submit" value="Luo tili" name="createAccount">
								<input class="btn btn-lg btn-warning btn-block" type="submit" value="Tyhjennä" name="empty">

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

<script>
$(function(){
var role = $('#role').attr('value');
if( role === 'Hyllyttäjä' || role === null)
 {
 	$('.role-button').removeClass('active');
 	$('#role-button-hyllyttaja').addClass('active');
 }

else if( role === 'Hallinnoitsija') {
	 $('.role-button').removeClass('active');
 	$('#role-button-hallinnoitsija').addClass('active');
}

});
</script>

<script>
$(function() {
	$('.role-button').click(function(){
		$('.role-button').removeClass('active');
		$(this).addClass('active');
		var rolevalue = $(this).attr("value");
		$('#role').val(rolevalue)
	});
});
</script>

</body>
</html>

<?php 

session_start();
if(!empty($_SESSION['user_id']))
{
	session_unset();
}
session_destroy();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Naslovnica</title>
	<meta charset="latin2">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body> 
		<!-- NAVBAR -->
		<nav class="navbar navbar-default">
			<div class="container-fluid">
			    <img class="navbar-brand" src="images/Logo.png" alt="Logo"/>
			    <h1 id="logoTitle">Portal za Posao</h1>

			    <!-- LOGIN FORMA -->
			    <form class="navbar-form navbar-right collapse-navbar" action="userAuth.php" method="POST">
			    	<label class="inputLabel">E-mail</label><input class="form-control homeInput" type="text" name="email" placeholder="E-mail" required>
			    	<label class="inputLabel">Lozinka</label><input class="form-control homeInput" type="password" name="lozinka" placeholder="Lozinka" required>
			    	<button type="submit" class="btn homeLoginButton">Prijava</button>
			    </form>
			    
		    </div>
		</nav>
	
		<div class="container-fluid homepage">

			<!-- LOGIN FORMA -->
		    <form class="loginForm" action="userAuth.php" method="POST">
		    	<h1>Prijavi se</h1>
		    	<hr>
		    	<label class="inputLabel">E-mail</label><input class="form-control homeInput" type="text" name="email" placeholder="E-mail" required>
		    	<label class="inputLabel">Lozinka</label><input class="form-control homeInput" type="password" name="lozinka" placeholder="Lozinka" required>
		    	<button type="submit" class="btn homeLoginButton">Prijava</button>
		    </form>

		    <!-- Novi korisnik -->
		    <div class="signUpForm">
		    	<h1>Novi korisnik</h1>
		    	<hr>
		    	<label class="inputLabelReg">Korisnik</label>
		    	<div id="radioUsers">
		    		<input type="radio" value="poslodavac" name="radioUser"><span> Poslodavac</span>
		    		<br>
			    	<input type="radio" value="posloprimac" name="radioUser"><span> Posloprimac</span>
		    	</div>
		    	<button onclick="OpenRegModal()" class="btn homeRegisterButton">Kreiraj račun</button>
		    </div>
		</div>

		<div class="modal fade" id="modals" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content"></div>
			</div>
		</div>

	<script src="js/globals.js"></script>
	<script src="js/app.js"></script>
</body>
</html>
<?php 
	if(empty($_SESSION['user_id']))
	{
		header('Location: ../index.php');
	}
 ?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Poslodavac</title>
		<meta charset="latin2">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular.min.js" integrity="sha256-23hi0Ag650tclABdGCdMNSjxvikytyQ44vYGo9HyOrU=" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/korisnici.css">
		<script src="js/app.js"></script>
	</head>
	<body ng-app="oPoslodavacModul" id="poslodavacBody">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default">
			<div class="container-fluid">
			    <img class="navbar-brand" src="images/Logo.png" alt="Logo"/>
			    <h1 class="logoTitle">Portal za Posao</h1>


		    	<button id="updateProfileBtn" onclick="GetModal('modals.php?modal_id=update_employer')" class="btn btn-primary"><span><i class="far fa-edit"></i></span> Uredi profil</button>

		    	<button id="getConversationsBtn" onclick="window.location='razgovori.php'" class="btn btn-primary"><i class="far fa-comments"></i> Razgovori</button>

			    <button id="logoutBtn" class="btn navbar-right" onclick="window.location='logout.php'"><i class="fas fa-sign-out-alt"></i>Odjavi se</button>
		    </div>
		</nav>

		<div class="profilePage row">

			<div id="panelUser" class="panel panel-default col-lg-4 col-sm-9">
			  <div class="panel-heading">
			    <h3 id="empName" class="panel-title">
			    	<script type="text/javascript">
			    		var ime = "<?php echo $oPoslodavac->ime; ?>";
			    		RenderTitle(ime);
			    	</script>
			    </h3>
			  </div>
			  <div class="panel-body">
			    <img src=
			    	<?php 
			    		echo $oPoslodavac->slika;
			    	?>
			    >
			  </div>
			  <div class="panel-footer">
			  	<h2>Opis</h2>
			  	<p id="opis">
			  		<?php 
			  			echo $oPoslodavac->opis;
			  		?>
			  	</p>
			  </div>
			</div>

			<div ng-controller="obavijestiController" id="panelNotifications" class="panel panel-default col-lg-4 col-sm-9">
			  <div class="panel-heading">
			    <h3 id="notifications" class="panel-title">
			    	Obavijesti
			    </h3>
			  </div>
			  <div class="panel-body">
			    <poslodavac-obavijesti ng-repeat="obavijest in oObavijesti">
			    	
			    </poslodavac-obavijesti>
			  </div>
			</div>

			<div id="panelJobs" class="panel panel-default col-lg-4 col-sm-9">
			  <div class="panel-heading">
			    <h3 id="myJobs" class="panel-title">
			    	Moji Poslovi
			    </h3>
			    <button id="btnNewJob" onclick="GetModal('modals.php?modal_id=new_job')" class="btn"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj posao</button>
			  </div>
			  <div class="panel-body table-responsive" ng-controller="posloviController">
			    	<poslodavac-poslovi>
		    			
		    		</poslodavac-poslovi>
			  </div>
			</div>

			<!-- MODAL DODAVANJE POSLA -->
			<div class="modal fade" id="modals" tabindex="-1" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content"></div>
				</div>
			</div>

		</div>
	<script src="js/poslodavacApp.js"></script>
	<script src="js/globals.js"></script>
	</body>
	</html>
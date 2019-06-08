<?php 

include "connection.php";

$regType = "";
if(!empty($_POST['reg_type']))
{
	$regType = $_POST['reg_type'];
}

switch ($regType) {
	case 'employer':
		if(!EmailRegistered($oConnection))
		{
			InsertEmp($oConnection, $regType);
			StartUserSession($oConnection, $regType);
		}
		else
		{
			?>
			<script type="text/javascript">
				alert('E-mail adresa se već koristi!');
				window.location = "index.php";
			</script>
			<?php
		}
		break;

	case 'employee':
		if(!EmailRegistered($oConnection))
		{
			InsertEmp($oConnection, $regType);
			StartUserSession($oConnection, $regType);
		}
		else
		{
			?>
			<script type="text/javascript">
				alert('E-mail adresa se već koristi!');
				window.location = "index.php";
			</script>
			<?php
		}
		break;

	default:
		header('Location: index.php');
		break;
}

function InsertEmp($con, $userType)
{
	//short if else
	$userType == "employer" ? $tip = "poslodavac" : $tip = "posloprimac";

	$sQueryUser = "INSERT INTO korisnici (vrsta_korisnika, email, lozinka) VALUES ('".$tip."', '".$_POST['empEmail']."', '".$_POST['empPass']."');";
	//ZAPIŠI KORISNIKA
	$con->query($sQueryUser);
	
	$sQueryCheckUser = "SELECT * FROM korisnici WHERE email='".$_POST['empEmail']."' AND lozinka='".$_POST['empPass']."'";

	//DOHVATI PODATKE KORISNIKA
	$dbResult = $con->query($sQueryCheckUser);
	$data = $dbResult->fetch(PDO::FETCH_ASSOC);

	if($data['vrsta_korisnika'] == "poslodavac")
	{
		$sQueryEmp = "INSERT INTO poslodavci (poslodavac_id, ime, opis, slika) VALUES (".$data['id'].", '".$_POST['employerName']."', '".$_POST['employerText']."', '".$_POST['employerImg']."') ";
	}
	else
	{
		if($_POST['gender'] == 'M'){
			$empImg = "images/posloprimacMusko.png";
		}
		else{
			$empImg = "images/posloprimacZensko.png";
		}
		$sQueryEmp = "INSERT INTO posloprimci (posloprimac_id, ime, prezime, spol, kategorije, opis, slika) VALUES (".$data['id'].", '".$_POST['employeeName']."', '".$_POST['employeeLastName']."', '".$_POST['gender']."', '".$_POST['employeeCategories']."', '".$_POST['employeeText']."', '".$empImg."') ";
	}
	
	
	$con->query($sQueryEmp);
}

function EmailRegistered($con)
{
	$sCheckEmail = "SELECT * FROM korisnici WHERE email='".$_POST['empEmail']."'";

	$dbResult = $con->query($sCheckEmail);
	$data = $dbResult->fetch(PDO::FETCH_ASSOC);

	if(!empty($data['id']))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function StartUserSession($con, $userType)
{
	$sGetUserIdQuery = "SELECT * FROM korisnici WHERE email='".$_POST['empEmail']."'";

	//DOHVATI PODATKE KORISNIKA
	$dbResult = $con->query($sGetUserIdQuery);
	$data = $dbResult->fetch(PDO::FETCH_ASSOC);

	session_start();
	$_SESSION['user_id'] = $data['id'];

	if($userType == "employer")
	{
		header('Location: poslodavac.php');
	}
	else
	{
		header('Location: posloprimac.php');
	}
	
}
?>
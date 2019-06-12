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

function GenerateRandomString()
{
	//GENERIRAJ RANDOM STRING ZA NAZIV SLIKE
	$string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$stringArray = str_split($string, 1);
	$randomString = '';
	foreach ($stringArray as $character) {
		$randomString .= $stringArray[mt_rand(0, sizeof($stringArray)-1)];
	}
	return $randomString;
}

function InsertEmp($con, $userType)
{
	//short if else
	$userType == "employer" ? $tip = "poslodavac" : $tip = "posloprimac";

	//ZAPIŠI KORISNIKA
	$sQueryUser = "INSERT INTO korisnici (vrsta_korisnika, email, lozinka) VALUES ('".$tip."', '".$_POST['empEmail']."', '".$_POST['empPass']."');";
	
	$con->query($sQueryUser);
	
	//DOHVATI PODATKE KORISNIKA
	$sQueryCheckUser = "SELECT * FROM korisnici WHERE email='".$_POST['empEmail']."' AND lozinka='".$_POST['empPass']."'";

	$dbResult = $con->query($sQueryCheckUser);
	$data = $dbResult->fetch(PDO::FETCH_ASSOC);

	//DOHVATI PODATKE ZA UPLOAD SLIKE KORISNIKA
	$slika = "userProfileImages/poslodavacAvatar.png";
	
	if($_FILES['empImg']['error'] == 0)
	{
		$randStr = GenerateRandomString();

		$uploadDir = getcwd().'/userProfileImages';//getcwd -> get current working directory
		$imgName = $_FILES['empImg']['name'];
		list($naziv, $ekstenzija) = explode('.', $imgName);

		$tmp_name = $_FILES['empImg']['tmp_name'];

		$name = $randStr."profilePicture".$data['id'].".".$ekstenzija;

		move_uploaded_file($tmp_name, "$uploadDir/$name");

		$slika = "userProfileImages/".$name;
	}

	//ZAPIŠI POSLODAVCA/POSLOPRIMCA
	if($data['vrsta_korisnika'] == "poslodavac")
	{
		$sQueryEmp = "INSERT INTO poslodavci (poslodavac_id, ime, opis, slika) VALUES (".$data['id'].", '".$_POST['employerName']."', '".$_POST['employerText']."', '".$slika."')";
	}
	else
	{
		if($_POST['gender'] == 'M' && empty($_FILES)){
			$empImg = "userProfileImages/posloprimacMusko.png";
		}
		elseif($_POST['gender'] == 'Z' && empty($_FILES)){
			$empImg = "userProfileImages/posloprimacZensko.png";
		}
		else{
			$empImg = $slika;
		}
		$sQueryEmp = "INSERT INTO posloprimci (posloprimac_id, ime, prezime, spol, kategorije, opis, slika) VALUES (".$data['id'].", '".$_POST['employeeName']."', '".$_POST['employeeLastName']."', '".$_POST['gender']."', '".$_POST['employeeCategories']."', '".$_POST['employeeText']."', '".$empImg."') ";
	}
	
	
	$con->query($sQueryEmp);
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
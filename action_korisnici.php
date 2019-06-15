<?php 

include "connection.php";

/*header("Access-Control-Allow-Headers: Authorization, Content-Type");*/
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json;charset=latin2;'); 

$request = "";

if(!empty($_GET['action_id']))
{
	$request = $_GET['action_id'];
}

if(!empty($_POST['action_id']))
{
	$request = $_POST['action_id'];
}

session_start();
$user_id = "";

if(!empty($_SESSION['user_id']))
{
	$user_id = $_SESSION['user_id'];

	switch ($request) {
		//KORISNICI
		case 'uredi_poslodavca':
			UpdateDbPoslodavca($oConnection, $user_id);
			break;
		case 'uredi_posloprimca':
			UpdateDbPosloprimca($oConnection, $user_id);
			break;
		//POSLOVI
		case 'dohvati_poslovePoslodavca':
			GetDbPosloviPoslodavca($oConnection, $user_id);
			break;
		case 'dohvati_poslovePosloprimca':
			GetDbPosloviPosloprimca($oConnection, $user_id);
			break;
		case 'dodaj_posao':
			InsertDbPosao($oConnection, $user_id);
			break;
		case 'uredi_posao':
			UpdateDbPosao($oConnection);
			break;
		case 'obrisi_posao':
			DeleteDbPosao($oConnection);
			break;
		//OBAVIJESTI
		case 'dohvati_obavijestiPoslodavca':
			FormatObavijestiPoslodavca($oConnection, $user_id);
			break;
		case 'dohvati_obavijestiPosloprimca':
			FormatObavijestiPosloprimca($oConnection, $user_id);
			break;
		case 'obrisi_obavijestPoslodavca':
			DeleteObavijestPoslodavca($oConnection);
			break;
		case 'obrisi_obavijestPosloprimca':
			DeleteObavijestPosloprimca($oConnection);
			break;
		case 'prijavi_posao':
			SendZahtjevZaPosao($oConnection, $user_id);
			break;
		case 'posalji_obavijestPosloprimcu':
			AcceptZahtjevZaPosao($oConnection, $user_id);
			break;
		//RAZGOVORI
		case 'dohvati_razgovorePoslodavca':
			GetDbRazgovorePoslodavca($oConnection, $user_id);
			break;
		case 'dohvati_razgovorePosloprimca':
			GetDbRazgovorePosloprimca($oConnection, $user_id);
			break;
		case 'posalji_porukuPoslodavac':
			SendDbMessagePoslodavac($oConnection);
			break;
		case 'posalji_porukuPosloprimac':
			SendDbMessagePosloprimac($oConnection);
			break;
		default:
			echo 'Zahtjev nije uspio.';
			break;
	}
}
else
{
	echo "ERROR";
	/*header("Location: index.php");*/
}

//KORISNICI
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
function UpdateDbPoslodavca($con, $userId)
{
	$sQueryKorisnik = "UPDATE korisnici SET email='".$_POST['empEmail']."', lozinka='".$_POST['empPass']."' WHERE id=".$userId;

	$slika = $_POST['empImgNow'];

	
	if($_FILES['empImg']['error'] == 0 && $_FILES['empImg']['size'] > 0)
	{
		$randStr = GenerateRandomString();

		$uploadDir = getcwd().'/userProfileImages';//getcwd -> get current working directory
		$imgName = $_FILES['empImg']['name'];
		list($naziv, $ekstenzija) = explode('.', $imgName);

		$tmp_name = $_FILES['empImg']['tmp_name'];

		$name = $randStr."profilePicture".$userId.".".$ekstenzija;

		//BRISE FILE/SLIKU AKO NIJE DEFAULT SLIKA
		if($slika != 'userProfileImages/poslodavacAvatar.png')
		{
			unlink($slika);
		}
		
		move_uploaded_file($tmp_name, "$uploadDir/$name");

		$slika = "userProfileImages/".$name;
	}

	$sQueryPoslodavac = "UPDATE poslodavci SET ime='".$_POST['empName']."', opis='".$_POST['empText']."', slika='".$slika."' WHERE poslodavac_id=".$userId;

	$con->query($sQueryKorisnik);
	$con->query($sQueryPoslodavac);
	header('Location: poslodavac.php');
}

function UpdateDbPosloprimca($con, $userId)
{
	$sQueryKorisnik = "UPDATE korisnici SET email='".$_POST['empEmail']."', lozinka='".$_POST['empPass']."' WHERE id=".$userId;

	$slika = $_POST['imgNow'];
	$slikaM = "userProfileImages/posloprimacMusko.png";
	$slikaZ = "userProfileImages/posloprimacZensko.png";
	
	if($_POST['gender'] != $_POST['dbGender']){
		if($slika == $slikaM || $slika == $slikaZ)
		{
			if($_POST['gender'] == 'M')
			{
				$slika = $slikaM;
			}
			else{
				$slika = $slikaZ;
			}
		}
	}
	

	if($_FILES['empImg']['error'] == 0 && $_FILES['empImg']['size'] > 0)
	{
		$randStr = GenerateRandomString();

		$uploadDir = getcwd().'/userProfileImages';//getcwd -> get current working directory
		$imgName = $_FILES['empImg']['name'];
		list($naziv, $ekstenzija) = explode('.', $imgName);

		$tmp_name = $_FILES['empImg']['tmp_name'];

		$name = $randStr."profilePicture".$userId.".".$ekstenzija;

		//BRISE FILE/SLIKU AKO NIJE DEFAULT SLIKA
		if($slika != 'userProfileImages/posloprimacMusko.png' && $slika != 'userProfileImages/posloprimacZensko.png')
		{
			unlink($slika);
		}

		move_uploaded_file($tmp_name, "$uploadDir/$name");

		$slika = "userProfileImages/".$name;
	}

	$sQueryPosloprimac = "UPDATE posloprimci SET ime='".$_POST['empName']."', prezime='".$_POST['empLastName']."', spol='".$_POST['gender']."', opis='".$_POST['empText']."', kategorije='".$_POST['empCats']."', slika='".$slika."' WHERE posloprimac_id=".$userId;

	$con->query($sQueryKorisnik);
	$con->query($sQueryPosloprimac);
	header('Location: posloprimac.php');
}

//POSLOVI-----------------------------------------
function GetDbPosloviPoslodavca($con, $userId)
{
	$oPoslovi = array();
	$sQueryPoslovi = "SELECT * FROM poslovi WHERE poslodavac_id='".$userId."'";
	$dbResult = $con->query($sQueryPoslovi);
	
	while($data = $dbResult->fetch(PDO::FETCH_ASSOC))
	{
		array_push($oPoslovi, $data);
	}
	$json = json_encode($oPoslovi);
	echo $json;
}

function GetDbPosloviPosloprimca($con, $userId)
{
	$oPoslovi = array();
	//KATEGORIJE KORISNIKA
	$sQueryUserCats = "SELECT kategorije FROM posloprimci WHERE posloprimac_id='".$userId."'";
	$dbResultCats = $con->query($sQueryUserCats);
	$userCategories = $dbResultCats->fetch(PDO::FETCH_ASSOC);
	$formatCategories = "'".$userCategories['kategorije']."'";
	
	$sKategorije = str_replace(", ", "', '", $formatCategories);

	//PROVJERI JE LI KORISNIK VEĆ PRIJAVIO POSAO
	$sQueryNotifications = "SELECT * FROM obavijesti WHERE posloprimac_id=".$userId." AND korisnik='poslodavac'";
	$dbResultNotifications = $con->query($sQueryNotifications);
	
	$dataAppJobs = [];
	while($row = $dbResultNotifications->fetch(PDO::FETCH_ASSOC))
	{
		array_push($dataAppJobs, $row['posao_id']." ");
	}
	$sPrijavljeniPoslovi = "";
	for ($i=0; $i < (sizeof($dataAppJobs)) ; $i++) 
	{
		if($i != (sizeof($dataAppJobs)-1))
		{
			$sPrijavljeniPoslovi .= str_replace(" ", ", ", $dataAppJobs[$i]);
		}
		else
		{
			$sPrijavljeniPoslovi .= $dataAppJobs[$i];
		}
	}
	if(empty($sPrijavljeniPoslovi))
	{
		$sPrijavljeniPoslovi = "0";
	}

	//POSLOVI U KATEGORIJAMA KORISNIKA
	$sQueryPoslovi = "SELECT * FROM poslovi WHERE kategorija IN (".$sKategorije.") AND id NOT IN (".$sPrijavljeniPoslovi.") AND dostupnost='dostupan'";

	$dbResultJobs = $con->query($sQueryPoslovi);
	
	while($jobsData = $dbResultJobs->fetch(PDO::FETCH_ASSOC))
	{
		$sQueryPoslodavac = "SELECT * FROM poslodavci WHERE poslodavac_id=".$jobsData['poslodavac_id'];
		$dbResultEmployer = $con->query($sQueryPoslodavac);
		$empData = $dbResultEmployer->fetch(PDO::FETCH_ASSOC);

		$jobArray = array(
			'id' => $jobsData['id'], 
			'poslodavac_id' => $jobsData['poslodavac_id'], 
			'naziv' => $jobsData['naziv'], 
			'kategorija' => $jobsData['kategorija'], 
			'opis' => $jobsData['opis'], 
			'ime_poslodavca' => $empData['ime']
		);

		array_push($oPoslovi, $jobArray);
	}

	$json = json_encode($oPoslovi);
	
	echo $json;
}

function InsertDbPosao($con, $userId)
{
	$sQuery = "INSERT INTO poslovi (poslodavac_id, naziv, kategorija, dostupnost, opis) VALUES ('".$userId."', '".$_POST['jobName']."', '".$_POST['jobCategory']."', '".$_POST['jobAvailability']."', '".$_POST['jobText']."')";

	$con->query($sQuery);
	header('Location: poslodavac.php');
}

function UpdateDbPosao($con)
{
	$sQuery = "UPDATE poslovi SET naziv='".$_POST['jobName']."', kategorija='".$_POST['jobCategory']."', dostupnost='".$_POST['jobAvailability']."', opis='".$_POST['jobText']."' WHERE id=".$_POST['jobId'];

	$con->query($sQuery);
	header('Location: poslodavac.php');
}

function DeleteDbPosao($con)
{
	$sQuery = "DELETE FROM poslovi WHERE id=".$_POST['posaoId'];

	$con->query($sQuery);
	header('Location: poslodavac.php');
}

//OBAVIJESTI-----------------------------------------
function GetDbObavijesti($con, $userId)
{
	$oObavijesti = array();
	$sQueryObavijesti = "SELECT * FROM obavijesti WHERE (poslodavac_id='".$userId."' AND korisnik='poslodavac') OR (posloprimac_id='".$userId."' AND korisnik='posloprimac') ORDER BY id DESC";
	$dbResult = $con->query($sQueryObavijesti);

	while($data = $dbResult->fetch(PDO::FETCH_ASSOC))
	{
		//DODAJ RAZGOVORE AKO NE POSTOJE
		$sQueryPR = "SELECT * FROM razgovori WHERE (poslodavac_id=".$data['poslodavac_id']." AND posloprimac_id=".$data['posloprimac_id'].");";
		$dbResultPR = $con->query($sQueryPR);
		$dataPR = $dbResultPR->fetch(PDO::FETCH_ASSOC);

		if(empty($dataPR))
		{
			$sQueryRazgovori = "INSERT INTO razgovori (posloprimac_id, poslodavac_id) VALUES (".$data['posloprimac_id'].", ".$data['poslodavac_id'].")";
			$con->query($sQueryRazgovori);
		}

		//POLJE OBAVIJESTI
		$oObavijest = array(
			'id' => $data['id'],
			'posao_id' => $data['posao_id'],
			'poslodavac_id' => $data['poslodavac_id'],
			'posloprimac_id' => $data['posloprimac_id']
		);

		array_push($oObavijesti, $oObavijest);
	}

	return $oObavijesti;
}

//POSLODAVAC OBAVIJESTI
function FormatObavijestiPoslodavca($con, $userId)
{
	$dbObavijesti = GetDbObavijesti($con, $userId);
	$jsonObavijesti = array();

	foreach ($dbObavijesti as $dbObavijest) {
		//DOHVATI POSAO IZ DB TABLICE Poslovi
		$sQueryPoslovi = "SELECT * FROM poslovi WHERE id='".$dbObavijest['posao_id']."'";
		$dbResultPosao = $con->query($sQueryPoslovi);
		$posao = $dbResultPosao->fetch(PDO::FETCH_ASSOC);

		//DOHVATI POSLOPRIMCA IZ DB TABLICE Posloprimci
		$sQueryPosloprimci = "SELECT * FROM posloprimci WHERE posloprimac_id='".$dbObavijest['posloprimac_id']."'";
		$dbResultPosloprimac = $con->query($sQueryPosloprimci);
		$posloprimac = $dbResultPosloprimac->fetch(PDO::FETCH_ASSOC);

		//DOHVATI EMAIL POSLODAVCA IZ DB TABLICE Korisnici
		$sQueryKorisnici = "SELECT * FROM korisnici WHERE id='".$dbObavijest['posloprimac_id']."'";
		$dbResultKorisnik = $con->query($sQueryKorisnici);
		$korisnik = $dbResultKorisnik->fetch(PDO::FETCH_ASSOC);

		//POLJE OBAVIJESTI
		$obavijest = array(
			'id' => $dbObavijest['id'],
			'posao_id' => $dbObavijest['posao_id'],
			'posloprimac_id' => $dbObavijest['posloprimac_id'],
			'naziv_posla' => $posao['naziv'],
			'ime_posloprimca' => $posloprimac['ime'],
			'prezime_posloprimca' => $posloprimac['prezime'],
			'email_posloprimca' => $korisnik['email']

		);
		array_push($jsonObavijesti, $obavijest);
	}
	$json = json_encode($jsonObavijesti);
	echo $json;
}

//POSLOPRIMAC OBAVIJESTI
function FormatObavijestiPosloprimca($con, $userId)
{
	$dbObavijesti = GetDbObavijesti($con, $userId);
	$jsonObavijesti = array();

	foreach ($dbObavijesti as $dbObavijest) {
		//DOHVATI NAZIV POSLA IZ DB TABLICE Poslovi
		$sQueryPoslovi = "SELECT * FROM poslovi WHERE id='".$dbObavijest['posao_id']."'";
		$dbResultPosao = $con->query($sQueryPoslovi);
		$posao = $dbResultPosao->fetch(PDO::FETCH_ASSOC);

		//DOHVATI POSLODAVCA IZ DB TABLICE Poslodavci
		$sQueryPoslodavci = "SELECT * FROM poslodavci WHERE poslodavac_id='".$dbObavijest['poslodavac_id']."'";
		$dbResultPoslodavac = $con->query($sQueryPoslodavci);
		$poslodavac = $dbResultPoslodavac->fetch(PDO::FETCH_ASSOC);

		//DOHVATI EMAIL POSLODAVCA IZ DB TABLICE Korisnici
		$sQueryKorisnici = "SELECT * FROM korisnici WHERE id='".$dbObavijest['poslodavac_id']."'";
		$dbResultKorisnik = $con->query($sQueryKorisnici);
		$korisnik = $dbResultKorisnik->fetch(PDO::FETCH_ASSOC);

		$obavijest = array(
			'id' => $dbObavijest['id'],
			'posao_id' => $dbObavijest['posao_id'],
			'poslodavac_id' => $dbObavijest['poslodavac_id'],
			'naziv_posla' => $posao['naziv'],
			'ime_poslodavca' => $poslodavac['ime'],
			'email_poslodavca' => $korisnik['email']
		);
		array_push($jsonObavijesti, $obavijest);
	}
	$json = json_encode($jsonObavijesti);
	echo $json;
}

function DeleteObavijestPoslodavca($con)
{
	$sQuery = "DELETE FROM obavijesti WHERE id=".$_POST['obavijestId'];

	$con->query($sQuery);
	header('Location: poslodavac.php');
}

function DeleteObavijestPosloprimca($con)
{
	$sQuery = "DELETE FROM obavijesti WHERE id=".$_POST['obavijestId'];

	$con->query($sQuery);
	header('Location: posloprimac.php');
}

function SendZahtjevZaPosao($con, $userId)
{
	$sQuery = "INSERT INTO obavijesti (posao_id, poslodavac_id, posloprimac_id, korisnik) VALUES ('".$_POST['posaoId']."', '".$_POST['poslodavacId']."', '".$userId."', 'poslodavac')";

	$con->query($sQuery);
	header('Location: posloprimac.php');
}

function AcceptZahtjevZaPosao($con, $userId){
	$sQueryPosao = "UPDATE poslovi SET dostupnost='nedostupan' WHERE id=".$_POST['posaoId'];
	$sQueryObavijest = "INSERT INTO obavijesti (posao_id, poslodavac_id, posloprimac_id, korisnik) VALUES ('".$_POST['posaoId']."', '".$userId."', '".$_POST['posloprimacId']."', 'posloprimac')";

	$con->query($sQueryPosao);
	$con->query($sQueryObavijest);
	DeleteObavijestPoslodavca($con, $userId);
}

//RAZGOVORI
function GetDbPorukeRazgovora($con, $razgovorId)
{
	$oPoruke = array();
	$sQuery = "SELECT * FROM poruke WHERE razgovor_id=".$razgovorId;

	$dbResult = $con->query($sQuery);
	
	while($data = $dbResult->fetch(PDO::FETCH_ASSOC))
	{
		$poruka = array(
			'korisnik' => $data['korisnik'],
			'sadrzaj' => $data['sadrzaj'],
			'vrijeme_datum' => $data['vrijeme_datum']
		);
		array_push($oPoruke, $poruka);
	}

	return $oPoruke;
}

function GetDbRazgovorePoslodavca($con, $userId)
{
	$oRazgovori = array();
	$sQueryRazgovori = "SELECT * FROM razgovori WHERE poslodavac_id=".$userId." ORDER BY id DESC";

	$dbResultRazgovori = $con->query($sQueryRazgovori);
	
	while($data = $dbResultRazgovori->fetch(PDO::FETCH_ASSOC))
	{
		$sQueryPoslodavac = "SELECT * FROM poslodavci WHERE poslodavac_id=".$data['poslodavac_id'];
		$dbResultPoslodavac = $con->query($sQueryPoslodavac);
		$employerData = $dbResultPoslodavac->fetch(PDO::FETCH_ASSOC);

		$sQueryPosloprimac = "SELECT * FROM posloprimci WHERE posloprimac_id=".$data['posloprimac_id'];
		$dbResultPosloprimac = $con->query($sQueryPosloprimac);
		$employeeData = $dbResultPosloprimac->fetch(PDO::FETCH_ASSOC);

		$razgovor = array(
			'razgovor_id' => $data['id'],
			'poruke' => GetDbPorukeRazgovora($con, $data['id']),
			'posloprimac_imePrezime' => $employeeData['ime'].' '.$employeeData['prezime'],
			'posloprimac_id' => $employeeData['posloprimac_id'],
			'posloprimac_slika' => $employeeData['slika'],
			'poslodavac_slika' => $employerData['slika']
		);
		array_push($oRazgovori, $razgovor);
	}
	$json = json_encode($oRazgovori);
	echo $json;
}

function GetDbRazgovorePosloprimca($con, $userId)
{
	$oRazgovori = array();
	$sQueryRazgovori = "SELECT * FROM razgovori WHERE posloprimac_id=".$userId." ORDER BY id DESC";

	$dbResultRazgovori = $con->query($sQueryRazgovori);
	
	while($data = $dbResultRazgovori->fetch(PDO::FETCH_ASSOC))
	{
		$sQueryPoslodavac = "SELECT * FROM poslodavci WHERE poslodavac_id=".$data['poslodavac_id'];
		$dbResultPoslodavac = $con->query($sQueryPoslodavac);
		$employerData = $dbResultPoslodavac->fetch(PDO::FETCH_ASSOC);

		$sQueryPosloprimac = "SELECT * FROM posloprimci WHERE posloprimac_id=".$data['posloprimac_id'];
		$dbResultPosloprimac = $con->query($sQueryPosloprimac);
		$employeeData = $dbResultPosloprimac->fetch(PDO::FETCH_ASSOC);

		$razgovor = array(
			'razgovor_id' => $data['id'],
			'poruke' => GetDbPorukeRazgovora($con, $data['id']),
			'poslodavac_ime' => $employerData['ime'],
			'poslodavac_id' => $employerData['poslodavac_id'],
			'poslodavac_slika' => $employerData['slika'],
			'posloprimac_slika' => $employeeData['slika']
		);
		array_push($oRazgovori, $razgovor);
	}
	$json = json_encode($oRazgovori);
	echo $json;
}

function SendDbMessagePoslodavac($con)
{
	$razgovorId = $_POST['razgovor_id'];

	date_default_timezone_set("Europe/Zagreb");
	$vrijemeSlanja = date("H:i d/m/Y");

	if(!empty($_POST['textPoruke']))
	{
		$sQuery = "INSERT INTO poruke (razgovor_id, korisnik, sadrzaj, vrijeme_datum) VALUES ('".$razgovorId."', 'poslodavac', '".$_POST['textPoruke']."', '".$vrijemeSlanja."')";

		$con->query($sQuery);
		echo $razgovorId;
	}
	else
	{
		echo "ERROR";
	}
}

function SendDbMessagePosloprimac($con)
{
	$razgovorId = $_POST['razgovor_id'];

	date_default_timezone_set("Europe/Zagreb");
	$vrijemeSlanja = date("H:i d/m/Y");

	if(!empty($_POST['textPoruke']))
	{
		$sQuery = "INSERT INTO poruke (razgovor_id, korisnik, sadrzaj, vrijeme_datum) VALUES ('".$razgovorId."', 'posloprimac', '".$_POST['textPoruke']."', '".$vrijemeSlanja."')";

		$con->query($sQuery);
		echo $razgovorId;
	}
	else
	{
		echo "ERROR";
	}
}

?>
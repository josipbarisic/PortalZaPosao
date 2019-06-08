<?php 

include 'connection.php';

session_start();
if(!empty($_SESSION['user_id']))
{
	$sQueryPoslodavci = 'SELECT * FROM poslodavci WHERE poslodavac_id='.$_SESSION['user_id'];
	$dbResultEmp = $oConnection->query($sQueryPoslodavci);
	//Podaci poslodavca
	$dataEmp = $dbResultEmp->fetch(PDO::FETCH_ASSOC);
	//-----------------------------------------------
	$sQueryKorisnici = 'SELECT * FROM korisnici WHERE id='.$_SESSION['user_id'];
	$dbResultUser = $oConnection->query($sQueryKorisnici);
	//Podaci korisnika
	$dataUser = $dbResultUser->fetch(PDO::FETCH_ASSOC);
	
	if(!empty($dataEmp['poslodavac_id']))
	{
		$oPoslodavac = new Poslodavac($dataEmp['poslodavac_id'], $dataUser['email'], $dataUser['lozinka'], $dataEmp['ime'], $dataEmp['opis'], $dataEmp['slika']);

		include 'templates/poslodavacTemplate.php';

		/*var_dump($oPoslodavac);*/
	}
	else
	{
		header('Location: index.php');
		session_destroy();
	}
}
else
{
	header('Location: index.php');
	session_destroy();
}
?>
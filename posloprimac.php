<?php 

include 'connection.php';

session_start();
if(!empty($_SESSION['user_id']))
{
	$sQueryPosloprimci = 'SELECT * FROM posloprimci WHERE posloprimac_id='.$_SESSION['user_id'];
	$dbResultEmp = $oConnection->query($sQueryPosloprimci);
	//Podaci posloprimca
	$dataEmp = $dbResultEmp->fetch(PDO::FETCH_ASSOC);


	$sQueryKorisnici = 'SELECT * FROM korisnici WHERE id='.$_SESSION['user_id'];
	$dbResultUser = $oConnection->query($sQueryKorisnici);
	//Podaci korisnika
	$dataUser = $dbResultUser->fetch(PDO::FETCH_ASSOC);

	if(!empty($dataEmp['posloprimac_id']))
	{
		$oPosloprimac = new Posloprimac($dataEmp['posloprimac_id'], $dataUser['email'], $dataUser['lozinka'], $dataEmp['ime'], $dataEmp['opis'], $dataEmp['kategorije'], $dataEmp['prezime'], $dataEmp['spol'], $dataEmp['slika']);

		include 'templates/posloprimacTemplate.php';

	/*var_dump($oPosloprimac);*/
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
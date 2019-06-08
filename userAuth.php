<?php 

include 'connection.php';
	
$data = "";

if(!empty($_POST['email']) && !empty($_POST['lozinka']))
{
	$sQuery = 'SELECT * FROM korisnici WHERE email="'.$_POST['email'].'" AND lozinka="'.$_POST['lozinka'].'"';
	$dbResult = $oConnection->query($sQuery);
	$data = $dbResult->fetch(PDO::FETCH_ASSOC);
}
	

if(!empty($data['id']))
{
	if($data['vrsta_korisnika'] == "poslodavac")
	{
		session_start();
		$_SESSION['user_id'] = $data['id'];
		header('Location: poslodavac.php');
	}
	else
	{
		session_start();
		$_SESSION['user_id'] = $data['id'];
		header('Location: posloprimac.php');
	}
}
else
{
?>
	<script type="text/javascript">
		alert("Netočni podaci za prijavu!");
		window.location.href = "index.php";
	</script>
<?php
}


?>
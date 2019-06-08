<?php 
include "classes.php";

$oConfig = new Config();

/*try
{*/
	$oConnection = new PDO("mysql:host=$oConfig->host;dbname=$oConfig->dbName;charset=latin2", $oConfig->username, $oConfig->password);
	/*
	 echo "Connected to DB $oConfig->dbName";
}
catch(PDOException $err)
{
	echo "Connection failed: ".$err->getMessage();
}*/
 ?>
<?php 

class Config
{
	public $host = "localhost";
	public $dbName = "pzpbaza";
	public $username = "root";
	public $password = "";

	public function __construct($host=null, $dbName=null, $username=null, $password=null)
	{
		if($host) $this->host = $host;
		if($dbName) $this->dbName = $dbName;
		if($username) $this->username = $username;
		if($password) $this->password = $password;
	}
}

class Korisnik
{
	public $id = "";
	public $email = "emailPosao";
	public $lozinka = "";
	public $ime = "N/A";
	public $opis = "N/A";

	/*public function  __construct($id=null, $email=null, $pass=null, $ime=null, $opis=null)
	{
		if($id) $this->id = $id;
		if($email) $this->email = $email;
		if($pass) $this->lozinka = $pass;
		if($ime) $this->ime = $ime;
		if($opis) $this->opis = $opis;
	}*/
}

class Poslodavac extends Korisnik
{
	public $slika = "images/poslodavacAvatar.png";

	public function __construct($id=null, $email=null, $pass=null, $ime=null, $opis=null, $slika=null)
	{
		if($id) $this->id = $id;
		if($email) $this->email = $email;
		if($pass) $this->lozinka = $pass;
		if($ime) $this->ime = $ime;
		if($opis) $this->opis = $opis;
		if($slika) $this->slika = $slika;
	}
}

class Posloprimac extends Korisnik
{
	public $kategorije = "N/A";
	public $prezime = "N/A";
	public $spol = "N/A";
	public $slika = "images/posloprimacMusko.png";

	public function __construct($id=null, $email=null, $pass=null, $ime=null, $opis=null, $kat=null, $prezime=null, $spol=null, $slika=null)
	{
		if($id) $this->id = $id;
		if($email) $this->email = $email;
		if($pass) $this->lozinka = $pass;
		if($ime) $this->ime = $ime;
		if($opis) $this->opis = $opis;
		if($kat) $this->kategorije = $kat;
		if($prezime) $this->prezime = $prezime;
		if($spol) $this->spol = $spol;
		if($slika) $this->slika = $slika;
	}
}

class Posao
{
	public $posao_id = "N/A";
	public $poslodavac_id = "N/A";
	public $naziv = "N/A";
	public $kategorija = "N/A";
	public $dostupnost = "N/A";
	public $opis = "N/A";

	public function __construct($p_id=null, $pd_id=null, $naziv_p=null, $kat_p=null, $dos_p=null, $opis_p=null)
	{
		if($p_id) $this->posao_id = $p_id;
		if($pd_id) $this->poslodavac_id = $pd_id;
		if($naziv_p) $this->naziv = $naziv_p;
		if($kat_p) $this->kategorija = $kat_p;
		if($dos_p) $this->dostupnost = $dos_p;
		if($opis_p) $this->opis = $opis_p;
	}
}

class Obavijest
{
	public $obavijest_id = "N/A";
	public $posao_id = "N/A";
	public $posloprimac_id = "N/A";

	public function __construct($id=null, $p_id=null, $pp_id=null)
	{
		if($id) $this->obavijest_id = $id;
		if($p_id) $this->posao_id = $p_id;
		if($pp_id) $this->posloprimac_id = $pp_id;
	}
}

?>
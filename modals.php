<?php
include 'connection.php';

$sModalId = $_GET['modal_id'];


switch($sModalId)
{
	case 'new_employer':
	
?>
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h2 class="modal-title">Registracija poslodavca</h2>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="action_registration.php" method="POST">
					<input type="hidden" name="reg_type" value="employer">
					<div class="form-group row">
						<label class="control-label col-lg-3 col-xs-3">Ime</label>
						<div class="col-lg-8 col-xs-8"><input class="form-control" type="text" name="employerName" required></div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">E-mail</label>
						<div class="col-lg-8 col-xs-8"><input class="form-control" type="email" name="empEmail" required></div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Lozinka</label>
						<div class="col-lg-8 col-xs-8"><input class="form-control" type="password" name="empPass" placeholder="Minimalno 8 znakova" minlength="8" required></div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Opis</label>
						<div class="col-lg-8 col-xs-8"><textarea maxlength="255" placeholder="Maksimalno 255 znakova" class="form-control" name="employerText" required/></div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Slika profila</label>
						<div class="col-lg-8 col-xs-8"><img src="images/poslodavacAvatar.png"/><input type="hidden" name="employerImg" value="images/poslodavacAvatar.png"></div>
					</div>

					<div class="modal-footer">
						<button data-dismiss="modal" class="btn btn-danger">Odustani</button>
						<button type="submit" class="btn btn-primary">Registriraj se</button>
					</div>
				</form>
			</div>
<?php 
		break;
	case 'new_employee':
?>
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h1 class="modal-title">Registracija posloprimca</h2>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="action_registration.php" method="POST">
					<input type="hidden" name="reg_type" value="employee">
					<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Ime</label>
						<div class="col-lg-8 col-xs-8"><input class="form-control" type="text" name="employeeName" required></div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Prezime</label>
						<div class="col-lg-8 col-xs-8"><input class="form-control" type="text" name="employeeLastName" required></div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Spol</label>
						<div class="col-lg-8 col-xs-8 radios">
							<label class="radio"><input type="radio" name="gender" value="M" required> Muško</label>
						</div>
						<div class="col-lg-3 col-xs-3"></div>
						<div class="col-lg-8 col-xs-8 radios">
							<label class="radio"><input type="radio" name="gender" value="Z"> Žensko</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">E-mail</label>
						<div class="col-lg-8 col-xs-8"><input class="form-control" type="email" name="empEmail" required></div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Lozinka</label>
						<div class="col-lg-8 col-xs-8"><input class="form-control" type="password" name="empPass" placeholder="Minimalno 8 znakova" minlength="8" required></div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Opis</label>
						<div class="col-lg-8 col-xs-8"><textarea maxlength="255" placeholder="Maksimalno 255 znakova" class="form-control" name="employeeText" required/></div>
					</div>
					<div class="form-group" onclick="GetUserCats()">
						<label class="control-label col-lg-3 col-xs-3">Moje kategorije</label>
						<div class="col-lg-5 col-xs-5">
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Administracija" required>Administracija</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Ekonomija" required>Ekonomija</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Elektrotehnika" required>Elektrotehnika</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="IT/Telekomunikacije" required>IT/Telekomunikacije</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Marketing" required>Marketing</label>
						</div>
						<div class="col-lg-4 col-xs-4">
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Obrazovanje" required>Obrazovanje</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Održavanje" required>Održavanje</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Transport" required>Transport</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Trgovina" required>Trgovina</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Turizam" required>Turizam</label>
						</div>
					</div>
					<input type="hidden" name="employeeCategories" id="empCats">
					<div class="modal-footer">
						<button data-dismiss="modal" class="btn btn-danger">Odustani</button>
						<button type="submit" class="btn btn-primary">Registriraj se</button>	
					</div>
				</form>
			</div>
<?php
		break;
	case 'update_employer':

		session_start();
		$empId = $_SESSION['user_id'];

		$sQueryKorisnik = "SELECT * FROM korisnici WHERE id=".$empId;
		$dbResultKorisnik = $oConnection->query($sQueryKorisnik);
		$userData = $dbResultKorisnik->fetch(PDO::FETCH_ASSOC);

		$sQueryPoslodavac = "SELECT * FROM poslodavci WHERE poslodavac_id=".$empId;
		$dbResultPoslodavac = $oConnection->query($sQueryPoslodavac);
		$empData = $dbResultPoslodavac->fetch(PDO::FETCH_ASSOC);
?>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h1 class="modal-title">Uredi Profil</h2>
		</div>
		<div class="modal-body">
			<form class="form-horizontal" action="action_korisnici.php" method="POST">
				<input type="hidden" name="action_id" value="uredi_poslodavca">

				<div class="form-group">
					<label class="control-label col-lg-3 col-xs-3">Ime</label>
					<div class="col-lg-8 col-xs-8">
						<input class="form-control" type="text" name="empName" value="<?php echo $empData['ime']; ?>" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-3 col-xs-3">Email</label>
					<div class="col-lg-8 col-xs-8">
						<input class="form-control" type="email" name="empEmail" value="<?php echo $userData['email']; ?>" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-3 col-xs-3">Lozinka</label>
					<div class="col-lg-8 col-xs-8">

						<input class="form-control" id="togglePassword" type="password" name="empPass" value="<?php echo $userData['lozinka']; ?>" required>

						<label><input type="checkbox" onclick="TogglePassword()" value="Prikaži lozinku"> Prikaži lozinku</label>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-3 col-xs-3">Opis</label>

					<div class="col-lg-8 col-xs-8">
						<textarea maxlength="255" class="form-control" name="empText" required><?php echo $empData['opis']; ?>
						</textarea>
					</div>
				</div>
				
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-danger">Odustani</button>
					<button type="submit" class="btn btn-primary">Ažuriraj profil</button>	
				</div>
			</form>
		</div>

<?php
		break;
	case 'update_employee':
		session_start();
		$empId = $_SESSION['user_id'];

		$sQueryKorisnik = "SELECT * FROM korisnici WHERE id=".$empId;
		$dbResultKorisnik = $oConnection->query($sQueryKorisnik);
		$userData = $dbResultKorisnik->fetch(PDO::FETCH_ASSOC);

		$sQueryPosloprimac = "SELECT * FROM posloprimci WHERE posloprimac_id=".$empId;
		$dbResultPosloprimac = $oConnection->query($sQueryPosloprimac);
		$empData = $dbResultPosloprimac->fetch(PDO::FETCH_ASSOC);
?>

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h1 class="modal-title">Uredi Profil</h2>
		</div>
		<div class="modal-body">
			<form class="form-horizontal" action="action_korisnici.php" method="POST">
				<input type="hidden" name="action_id" value="uredi_posloprimca">

				<div class="form-group">
					<label class="control-label col-lg-3 col-xs-3">Ime</label>
					<div class="col-lg-8 col-xs-8">
						<input class="form-control" type="text" name="empName" value="<?php echo $empData['ime']; ?>" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-3 col-xs-3">Prezime</label>
					<div class="col-lg-8 col-xs-8">
						<input class="form-control" type="text" name="empLastName" value="<?php echo $empData['prezime']; ?>" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-3 col-xs-3">Email</label>
					<div class="col-lg-8 col-xs-8">
						<input class="form-control" type="email" name="empEmail" value="<?php echo $userData['email']; ?>" required>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-3 col-xs-3">Lozinka</label>
					<div class="col-lg-8 col-xs-8">

						<input class="form-control" id="togglePassword" type="password" name="empPass" value="<?php echo $userData['lozinka']; ?>" required>

						<label><input type="checkbox" onclick="TogglePassword()" value="Prikaži lozinku"> Prikaži lozinku</label>
					</div>
				</div>

				<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Spol</label>
						<div class="col-lg-8 col-xs-8">
							<label><input type="radio" name="gender" value="M" required> Muško</label>
						</div>
						<script type="text/javascript">
							CheckGender("<?php echo $empData['spol']; ?>");
						</script>
						<div class="col-lg-3 col-xs-3"></div>
						<div class="col-lg-8 col-xs-8">
							<label><input type="radio" name="gender" value="Z"> Žensko</label>
						</div>
					</div>

				<div class="form-group">
					<label class="control-label col-lg-3 col-xs-3">Opis</label>

					<div class="col-lg-8 col-xs-8">
						<textarea maxlength="255" class="form-control" name="empText" required><?php echo $empData['opis']; ?>
						</textarea>
					</div>
				</div>

				<script type="text/javascript">
					CheckCats("<?php echo $empData['kategorije']; ?>");
				</script>
				<div class="form-group" onclick="GetUserCats()">
						<label class="control-label col-lg-3 col-xs-3">Moje kategorije</label>
						<div class="col-lg-5 col-xs-5">
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Administracija" required>Administracija</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Ekonomija" required>Ekonomija</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Elektrotehnika" required>Elektrotehnika</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="IT/Telekomunikacije" required>IT/Telekomunikacije</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Marketing" required>Marketing</label>
						</div>
						<div class="col-lg-4 col-xs-4">
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Obrazovanje" required>Obrazovanje</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Održavanje" required>Održavanje</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Transport" required>Transport</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Trgovina" required>Trgovina</label>
							<label class="checkbox"><input type="checkbox" name="kategorija" value="Turizam" required>Turizam</label>
						</div>
					</div>
					<input type="hidden" name="empCats" id="empCats" value="" required>
				
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-danger">Odustani</button>
					<button type="submit" class="btn btn-primary">Ažuriraj profil</button>	
				</div>
			</form>
		</div>

<?php
		break;
	case 'new_job':
?>
		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h1 class="modal-title">Novi Posao</h2>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="action_korisnici.php" method="POST">
					<input type="hidden" name="action_id" value="dodaj_posao">
					
					<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Naziv</label>
						<div class="col-lg-8 col-xs-8">
							<input class="form-control" type="text" name="jobName" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Kategorija</label>
						<div class="col-lg-8 col-xs-8">
							<select name="jobCategory" class="form-control" required>
								<option value="" selected disabled>Odaberite kategoriju</option>
								<option value="Administracija">Administracija</option>
								<option value="Ekonomija">Ekonomija</option>
								<option value="Elektrotehnika">Elektrotehnika</option>
								<option value="IT/Telekomunikacije">IT/Telekomunikacije</option>
								<option value="Marketing">Marketing</option>
								<option value="Obrazovanje">Obrazovanje</option>
								<option value="Održavanje">Održavanje</option>
								<option value="Transport">Transport</option>
								<option value="Trgovina">Trgovina</option>
								<option value="Turizam">Turizam</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Dostupnost</label>

						<div class="col-lg-8 col-xs-8">
							<div class="col-lg-8 col-xs-8">
								<label class="radio"><input type="radio" name="jobAvailability" value="dostupan" required>Dostupan</label>
							</div>
							<div class="col-lg-3 col-xs-3"></div>
							<div class="col-lg-8 col-xs-8">
								<label class="radio"><input type="radio" name="jobAvailability" value="nedostupan">Nedostupan</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Opis</label>

						<div class="col-lg-8 col-xs-8"><textarea maxlength="255" placeholder="Maksimalno 255 znakova" class="form-control" name="jobText" required/></div>
					</div>
					
					<div class="modal-footer">
						<button data-dismiss="modal" class="btn btn-danger">Odustani</button>
						<button type="submit" class="btn btn-primary">Dodaj posao</button>	
					</div>
				</form>
			</div>
<?php
		break;
	case 'job_info':
		$jobId = $_GET['job_id'];

		//DOHVATI PODATKE POSLA
		$sQueryPosao = "SELECT * FROM poslovi WHERE id=".$jobId;
		$dbResultPosao = $oConnection->query($sQueryPosao);
		$jobData = $dbResultPosao->fetch(PDO::FETCH_ASSOC);

		//DOHVATI PODATKE POSLODAVCA
		$sQueryPoslodavac = "SELECT * FROM poslodavci WHERE poslodavac_id=".$jobData['poslodavac_id'];
		$dbResultPoslodavac = $oConnection->query($sQueryPoslodavac);
		$empData = $dbResultPoslodavac->fetch(PDO::FETCH_ASSOC);
?>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h2 class="modal-title">
					<?php 
						echo $jobData['naziv'];
					 ?>
				</h2>
		</div>
		<div class="modal-body" id="jobInfo">
			<p><span class="jobInfoLabels">POSLODAVAC: </span>
				<?php 
					echo $empData['ime'];
				 ?>
			</p>
			<p><span class="jobInfoLabels">KATEGORIJA: </span>
				<?php 
					echo $jobData['kategorija'];
				 ?>
			</p>
			<p><span class="jobInfoLabels">OPIS: </span>
				<?php 
					echo $jobData['opis'];
				 ?>
			</p>

		</div>
		<div class="modal-footer">
			<button data-dismiss="modal" class="btn btn-danger">Zatvori</button>
		</div>
<?php
		break;
	case 'job_update':
		$jobId = $_GET['job_id'];
		$sQuery = "SELECT * FROM poslovi WHERE id=".$jobId;
		$dbResult = $oConnection->query($sQuery);
		$jobData = $dbResult->fetch(PDO::FETCH_ASSOC);
?>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h1 class="modal-title">Uredi Posao</h2>
		</div>
		<div class="modal-body">
			<form class="form-horizontal" action="action_korisnici.php" method="POST">
				<input type="hidden" name="action_id" value="uredi_posao">
				<input type="hidden" name="jobId" value="<?php echo $jobData['id'] ?>">

				<div class="form-group">
					<label class="control-label col-lg-3 col-xs-3">Naziv</label>
					<div class="col-lg-8 col-xs-8">
						<input class="form-control" type="text" name="jobName" value="<?php echo $jobData['naziv']; ?>" required>
					</div>
				</div>

				<div class="form-group">

					<script type="text/javascript">
						var options = document.querySelectorAll("select[name='jobCategory'] option");
						var phpOptionValue = "<?php echo $jobData['kategorija']; ?>"

						options.forEach(function(option){
							if(option.value == phpOptionValue)
							{
								option.setAttribute("selected", true);
							}
						});
					</script>

					<label class="control-label col-lg-3 col-xs-3">Kategorija</label>
					<div class="col-lg-8 col-xs-8">
						<select name="jobCategory" class="form-control" required>
							<option value="" disabled>Odaberite kategoriju</option>
							<option value="Administracija">Administracija</option>
							<option value="IT/Telekomunikacije">IT/Telekomunikacije</option>
							<option value="Elektrotehnika">Elektrotehnika</option>
							<option value="Obrazovanje">Obrazovanje</option>
							<option value="Trgovina">Trgovina</option>
							<option value="Turizam">Turizam</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-3 col-xs-3">Dostupnost</label>

					<script type="text/javascript">
						var radios = document.querySelectorAll(".updateRadio");
						var phpRadioValue = "<?php echo $jobData['dostupnost']; ?>"

						radios.forEach(function(radio){
							if(radio.value == phpRadioValue)
							{
								radio.setAttribute("checked", true);
							}
						});
					</script>

					<div class="col-lg-8 col-xs-8">
						<div class="col-lg-8 col-xs-8 radios">
							<label class="radio"><input class="updateRadio" type="radio" name="jobAvailability" value="dostupan" required>Dostupan</label>
						</div>
						<div class="col-lg-3 col-xs-3"></div>
						<div class="col-lg-8 col-xs-8 radios">
							<label class="radio"><input class="updateRadio" type="radio" name="jobAvailability" value="nedostupan">Nedostupan</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-3 col-xs-3">Opis</label>

					<div class="col-lg-8 col-xs-8">
						<textarea maxlength="255" class="form-control" name="jobText" required><?php echo $jobData['opis']; ?>
						</textarea>
					</div>
				</div>
				
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-danger">Odustani</button>
					<button type="submit" class="btn btn-primary">Ažuriraj posao</button>	
				</div>
			</form>
		</div>
<?php
		break;
	default: 
		echo 'Greška pri učitavanju modala.';
		break;
}

?>
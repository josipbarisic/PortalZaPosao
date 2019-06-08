<?php 

include 'connection.php';

$sQuery = 'CREATE TABLE IF NOT EXISTS `pzpbaza`.`korisnici` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `vrsta_korisnika` VARCHAR(20),
  `email` VARCHAR(100),
  `lozinka` VARCHAR(100),
  PRIMARY KEY (`id`))
DEFAULT CHARACTER SET latin2 COLLATE latin2_croatian_ci
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `pzpbaza`.`poslodavci` (
  `poslodavac_id` INT NOT NULL,
  `ime` VARCHAR(100),
  `opis` VARCHAR(300),
  `slika` VARCHAR(255),
  PRIMARY KEY (`poslodavac_id`),
  CONSTRAINT `fk_poslodavac_korisnik`
    FOREIGN KEY (`poslodavac_id`)
    REFERENCES `pzpbaza`.`korisnici` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
DEFAULT CHARACTER SET latin2 COLLATE latin2_croatian_ci
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `pzpbaza`.`posloprimci` (
  `posloprimac_id` INT NOT NULL,
  `ime` VARCHAR(100),
  `prezime` VARCHAR(100),
  `spol` CHAR(1),
  `kategorije` VARCHAR(300),
  `opis` VARCHAR(300),
  `slika` VARCHAR(255),
  PRIMARY KEY (`posloprimac_id`),
  CONSTRAINT `fk_posloprimac_korisnik`
    FOREIGN KEY (`posloprimac_id`)
    REFERENCES `pzpbaza`.`korisnici` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
DEFAULT CHARACTER SET latin2 COLLATE latin2_croatian_ci
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `pzpbaza`.`poslovi` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `poslodavac_id` INT NOT NULL,
  `naziv` VARCHAR(100),
  `kategorija` VARCHAR(100),
  `dostupnost` VARCHAR(20),
  `opis` VARCHAR(300),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_posao_poslodavac`
    FOREIGN KEY (`poslodavac_id`)
    REFERENCES `pzpbaza`.`poslodavci` (`poslodavac_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
DEFAULT CHARACTER SET latin2 COLLATE latin2_croatian_ci
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `pzpbaza`.`obavijesti` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `posao_id` INT NOT NULL,
  `poslodavac_id` INT NOT NULL,
  `posloprimac_id` INT NOT NULL,
  `korisnik` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_obavijest_posao`
    FOREIGN KEY (`posao_id`)
    REFERENCES `pzpbaza`.`poslovi` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
DEFAULT CHARACTER SET latin2 COLLATE latin2_croatian_ci
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `pzpbaza`.`razgovori` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `posloprimac_id` INT NOT NULL,
  `poslodavac_id` INT NOT NULL,
  PRIMARY KEY (`id`))
DEFAULT CHARACTER SET latin2 COLLATE latin2_croatian_ci
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `pzpbaza`.`poruke` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `razgovor_id` INT NOT NULL,
  `korisnik` VARCHAR(20) NOT NULL,
  `sadrzaj` VARCHAR(1000) NOT NULL,
  `vrijeme_datum` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_poruka_razgovor`
    FOREIGN KEY (`razgovor_id`)
    REFERENCES `pzpbaza`.`razgovori` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
DEFAULT CHARACTER SET latin2 COLLATE latin2_croatian_ci
ENGINE = InnoDB;';

try{
  $oConnection->query($sQuery);
    echo 'Successfully created tables';
}
catch(Exception $err){
  echo 'Error'.$err;
}

/*DB TEST QUERIES*/
/*
INSERT INTO pzpbaza.korisnici (vrsta_korisnika, email, lozinka) VALUES ('posloprimac', 'posloprimac@gmail.com', 'lozinka123');

INSERT INTO pzpbaza.poslodavci (poslodavac_id, ime, opis, slika) VALUES (2, 'poslodavacJedan', 'prviPoslodavacDB', 'slika.png');

DELETE FROM pzpbaza.korisnici WHERE id=3;

SELECT * FROM pzpbaza.poslodavci WHERE poslodavac_id=2;

INSERT INTO pzpbaza.posloprimci (posloprimac_id, kategorije, ime, prezime, spol, opis, slika) VALUES (4, 'automehanika, mehanika', 'imePosloprimca', 'prezimePosloprimca', 'M', 'Automehaničar s 3 godine iskustva', 'slika.png');
*/
?>

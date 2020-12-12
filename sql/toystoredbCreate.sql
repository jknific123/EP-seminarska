-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema toystoredb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema toystoredb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `toystoredb` DEFAULT CHARACTER SET utf8 COLLATE utf8_slovenian_ci ;
USE `toystoredb` ;

-- -----------------------------------------------------
-- Table `toystoredb`.`uporabnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `toystoredb`.`uporabnik` (
  `uporabnik_id` INT NOT NULL AUTO_INCREMENT,
  `uporabnik_ime` VARCHAR(45) NULL,
  `uporabnik_priimek` VARCHAR(45) NULL,
  `uporabnik_email` VARCHAR(45) NULL,
  `uporabnik_geslo` VARCHAR(255) NULL,
  `uporabnik_aktiviran` TINYINT NOT NULL DEFAULT 1,
  `uporabnik_naslov` VARCHAR(150) NULL,
  `uporabnik_vrsta` ENUM("stranka", "prodajalec", "administrator") NULL,
  PRIMARY KEY (`uporabnik_id`),
  UNIQUE INDEX `uporabnik_id_UNIQUE` (`uporabnik_id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toystoredb`.`narocilo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `toystoredb`.`narocilo` (
  `narocilo_id` INT NOT NULL AUTO_INCREMENT,
  `narocilo_status` ENUM("v obdelavi", "obdelano", "stornirano", "preklicano") NULL,
  `narocilo_postavka` FLOAT NULL,
  `uporabnik_id` INT NOT NULL,
  PRIMARY KEY (`narocilo_id`),
  INDEX `fk_narocilo_uporabnik_idx` (`uporabnik_id` ASC) VISIBLE,
  UNIQUE INDEX `narocilo_id_UNIQUE` (`narocilo_id` ASC) VISIBLE,
  CONSTRAINT `fk_narocilo_uporabnik`
    FOREIGN KEY (`uporabnik_id`)
    REFERENCES `toystoredb`.`uporabnik` (`uporabnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toystoredb`.`artikel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `toystoredb`.`artikel` (
  `artikel_id` INT NOT NULL AUTO_INCREMENT,
  `artikel_ime` VARCHAR(45) NULL,
  `artikel_cena` FLOAT NULL,
  `artikel_opis` VARCHAR(1000) NULL,
  `artikel_aktiviran` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (`artikel_id`),
  UNIQUE INDEX `artikel_id_UNIQUE` (`artikel_id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toystoredb`.`artikelnarocilo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `toystoredb`.`artikelnarocilo` (
  `artikel_id` INT NOT NULL,
  `narocilo_id` INT NOT NULL,
  `artikelnarocilo_kolicina` INT NULL,
  PRIMARY KEY (`artikel_id`, `narocilo_id`),
  INDEX `fk_artikel_has_narocilo_narocilo1_idx` (`narocilo_id` ASC) VISIBLE,
  INDEX `fk_artikel_has_narocilo_artikel1_idx` (`artikel_id` ASC) VISIBLE,
  CONSTRAINT `fk_artikel_has_narocilo_artikel1`
    FOREIGN KEY (`artikel_id`)
    REFERENCES `toystoredb`.`artikel` (`artikel_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_artikel_has_narocilo_narocilo1`
    FOREIGN KEY (`narocilo_id`)
    REFERENCES `toystoredb`.`narocilo` (`narocilo_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


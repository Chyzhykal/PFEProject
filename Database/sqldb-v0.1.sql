SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `db_teacherDay` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `db_teacherDay` ;

-- -----------------------------------------------------
-- Table `db_teacherDay`.`t_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_teacherDay`.`t_user` (
  `idUser` INT NOT NULL AUTO_INCREMENT,
  `useLogin` VARCHAR(100) NOT NULL,
  `usePwd` VARCHAR(255) NOT NULL,
  `useRight` VARCHAR(45) NOT NULL DEFAULT 'Standard',
  `useFirstName` VARCHAR(45) NULL,
  `useLastName` VARCHAR(45) NULL,
  `useRole` VARCHAR(45) NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE INDEX `idUser_UNIQUE` (`idUser` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_teacherDay`.`t_day`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_teacherDay`.`t_day` (
  `idDay` INT NOT NULL AUTO_INCREMENT,
  `dayName` VARCHAR(45) NOT NULL,
  `dayDate` VARCHAR(45) NOT NULL,
  `dayBeginTime` VARCHAR(45) NOT NULL,
  `dayEndTime` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idDay`),
  UNIQUE INDEX `idDay_UNIQUE` (`idDay` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_teacherDay`.`t_event`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_teacherDay`.`t_event` (
  `idEvent` INT AUTO_INCREMENT NOT NULL,
  `eveName` VARCHAR(255) NOT NULL,
  `eveType` VARCHAR(255) NOT NULL,
  `eveAuthor` VARCHAR(255) NOT NULL,
  `eveClass` VARCHAR(255) NOT NULL,
  `eveTotPlaceNum` DECIMAL(10,0) NOT NULL,
  `evePlaceLeft` DECIMAL(10,0) NOT NULL,
  `eveDescription` TEXT NOT NULL,
  `eveBeginTime` TIME NOT NULL,
  `eveEndTime` TIME NOT NULL,
  `fkDay` INT NULL,
  `fkLinkedEvent` INT NULL,
  `fkUser` INT NOT NULL,
  PRIMARY KEY (`idEvent`),
  UNIQUE INDEX `idEvent_UNIQUE` (`idEvent` ASC),
  INDEX `fk_t_event_t_day1_idx` (`fkDay` ASC),
  INDEX `fk_t_event_t_user1_idx` (`fkUser` ASC),
  CONSTRAINT `fk_t_event_t_day1`
    FOREIGN KEY (`fkDay`)
    REFERENCES `db_teacherDay`.`t_day` (`idDay`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_t_event_t_event1`
    FOREIGN KEY (`fkLinkedEvent`)
    REFERENCES `db_teacherDay`.`t_event` (`idEvent`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_t_event_t_user1`
    FOREIGN KEY (`fkUser`)
    REFERENCES `db_teacherDay`.`t_user` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_teacherDay`.`t_participant`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_teacherDay`.`t_participant` (
  `idParticipant` INT NOT NULL AUTO_INCREMENT,
  `parFirstname` VARCHAR(255) NOT NULL,
  `parLastname` VARCHAR(255) NOT NULL,
  `parRole` VARCHAR(45) NULL,
  PRIMARY KEY (`idParticipant`),
  UNIQUE INDEX `idParticipant_UNIQUE` (`idParticipant` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_teacherDay`.`t_event_has_t_participant`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_teacherDay`.`t_event_has_t_participant` (
  `fkEvent` INT NOT NULL,
  `fkParticipant` INT NOT NULL,
  PRIMARY KEY (`fkEvent`, `fkParticipant`),
  INDEX `fk_t_event_has_t_participant_t_participant1_idx` (`fkParticipant` ASC),
  INDEX `fk_t_event_has_t_participant_t_event_idx` (`fkEvent` ASC),
  CONSTRAINT `fk_t_event_has_t_participant_t_event`
    FOREIGN KEY (`fkEvent`)
    REFERENCES `db_teacherDay`.`t_event` (`idEvent`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_t_event_has_t_participant_t_participant1`
    FOREIGN KEY (`fkParticipant`)
    REFERENCES `db_teacherDay`.`t_participant` (`idParticipant`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

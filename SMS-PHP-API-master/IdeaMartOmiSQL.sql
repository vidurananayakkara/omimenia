SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `mydb` ;
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`user` ;

CREATE TABLE IF NOT EXISTS `mydb`.`user` (
  
  `username` VARCHAR(120) NOT NULL,
  `score` INT NOT NULL,
  `hash` VARCHAR(50) NOT NULL,
  `lastLoginTime` DATETIME NULL,
  `status` INT NOT NULL,
  PRIMARY KEY (`hash`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`game`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`game` ;

CREATE TABLE IF NOT EXISTS `mydb`.`game` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `gameState` INT NOT NULL,
  `truimph` VARCHAR(50)  NULL,
  `player1Hash` VARCHAR(50) NULL,
  `player2Hash` VARCHAR(50) NULL,
  `player3Hash` VARCHAR(50) NULL,
  `player4Hash` VARCHAR(50) NULL,
  `round` INT NULL,
  `group1Marks` INT NULL,
  `group2Marks` INT NULL,
  'next' INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;




-- -----------------------------------------------------
-- Table `mydb`.`player`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`player` ;

CREATE TABLE IF NOT EXISTS `mydb`.`player` (
 
  `playerHash` VARCHAR(50) NOT NULL,
  `cardSet` VARCHAR(120) NULL,
  `group_ch` CHAR NULL,
  `game_id` INT NOT NULL,
  'place' INT NULL;
  
  PRIMARY KEY (`playerHash`,'game_id'))
  
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

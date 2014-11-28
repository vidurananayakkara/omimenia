SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `techquad_db` ;
CREATE SCHEMA IF NOT EXISTS `techquad_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `techquad_db` ;

-- -----------------------------------------------------
-- Table `techquad_db`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `techquad_db`.`user` ;

CREATE TABLE IF NOT EXISTS `techquad_db`.`user` (
  
  `username` VARCHAR(120) NOT NULL,
  `score` INT NOT NULL,
  `hash` VARCHAR(50) NOT NULL,
  `lastLoginTime` DATETIME NULL,
  `status` INT NOT NULL,
  PRIMARY KEY (`hash`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `techquad_db`.`game`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `techquad_db`.`game` ;

CREATE TABLE IF NOT EXISTS `techquad_db`.`game` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `gameState` INT NOT NULL,
  `truimph` VARCHAR(50)  NULL,
  `player1Hash` VARCHAR(50) NULL,
  `player2Hash` VARCHAR(50) NULL,
  `player3Hash` VARCHAR(50) NULL,
  `player4Hash` VARCHAR(50) NULL,
  `currentHand` VARCHAR(50) NULL,
  `round` INT NULL,
  `group1Marks` INT NULL,
  `group2Marks` INT NULL,
  `next` INT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO `game` (`gameState`,`truimph`,`player1Hash`,`player2Hash`,`player3Hash`,`player4Hash`,`round`,`group1Marks`,`group2Marks`,`next`,`currentHand` )
VALUES ('0', 'Diamond','tel:94722545853','tel:94722545854','tel:94722545855','tel:94722545856', 1, 1, 2, 0, "Spade-9");

INSERT INTO `game` (`gameState`,`truimph`,`player1Hash`,`player2Hash`,`player3Hash`,`player4Hash`,`round`,`group1Marks`,`group2Marks`,`next`,`currentHand` )
VALUES ('0', 'Hearts', 'tel:94722545863','tel:94722545864','tel:94722545865','tel:94722545866',0, 0, 0, 2, "");

INSERT INTO `game` (`gameState`,`truimph`,`player1Hash`,`player2Hash`,`player3Hash`,`player4Hash`,`round`,`group1Marks`,`group2Marks`,`next`,`currentHand` )
VALUES ('0', 'Clubs', 'tel:94722545873','tel:94722545874','tel:94722545875','tel:94722545876',8, 5, 3, 3, "Spade-9 Diamond-A");





-- -----------------------------------------------------
-- Table `techquad_db`.`player`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `techquad_db`.`player` ;

CREATE TABLE IF NOT EXISTS `techquad_db`.`player` (
 
  `playerHash` VARCHAR(50) NOT NULL,
  `cardSet` VARCHAR(120) NULL,
  `group` VARCHAR(5) NULL,
  `game_id` INT NOT NULL,
  `place` INT NULL,

  PRIMARY KEY (`playerHash`,`game_id`)
) ENGINE = InnoDB;


INSERT INTO `player` VALUES ('tel:94722545853', 'A1', "A", 1, 1);
INSERT INTO `player` VALUES ('tel:94722545854', 'S10', "B", 1, 2);
INSERT INTO `player` VALUES ('tel:94722545856', 'D08', "A", 1, 4);
INSERT INTO `player` VALUES ('tel:94722545855', 'CA5', "B", 1, 3);

-- Dumping structure for table celebrity.sessions
DROP TABLE IF EXISTS `sessions`;

CREATE TABLE IF NOT EXISTS `techquad_db`.`sessions` (
  `sessionsid` varchar(100) NOT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `menu` varchar(50) DEFAULT NULL,
  `pg` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `others` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sessionsid`)
) ENGINE=InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

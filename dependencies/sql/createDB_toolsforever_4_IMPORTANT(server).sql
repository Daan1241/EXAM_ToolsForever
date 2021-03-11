-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema toolsforever
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `toolsforever` ;

-- -----------------------------------------------------
-- Schema toolsforever
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `toolsforever` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `toolsforever` ;

-- -----------------------------------------------------
-- Table `toolsforever`.`locations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`locations` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`locations` (
  `locationID` INT NOT NULL AUTO_INCREMENT,
  `locationname` VARCHAR(64) NULL,
  `locationdescription` VARCHAR(128) NULL DEFAULT NULL,
  `locationadress` VARCHAR(256) NULL,
  `zipcode_numbers` VARCHAR(4) NULL DEFAULT NULL,
  `zipcode_letters` VARCHAR(2) NULL DEFAULT NULL,
  PRIMARY KEY (`locationID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `toolsforever`.`products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`products` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`products` (
  `productID` INT NOT NULL AUTO_INCREMENT,
  `productname` VARCHAR(256) NULL,
  `productbrand` VARCHAR(64) NULL DEFAULT NULL,
  `producttype` VARCHAR(64) NULL DEFAULT NULL,
  `buyprice` VARCHAR(16) NULL DEFAULT NULL,
  `sellprice` VARCHAR(16) NULL DEFAULT NULL,
  PRIMARY KEY (`productID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `toolsforever`.`locations_has_products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`locations_has_products` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`locations_has_products` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `locations_locationID` INT NOT NULL,
  `products_productID` INT NOT NULL,
  `stock` INT NULL DEFAULT NULL,
  `min_stock` INT NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_locations_has_products_locations_idx` (`locations_locationID` ASC) VISIBLE,
  INDEX `fk_locations_has_products_products1_idx` (`products_productID` ASC) VISIBLE,
  CONSTRAINT `fk_locations_has_products_locations`
    FOREIGN KEY (`locations_locationID`)
    REFERENCES `toolsforever`.`locations` (`locationID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_locations_has_products_products1`
    FOREIGN KEY (`products_productID`)
    REFERENCES `toolsforever`.`products` (`productID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 129
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `toolsforever`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`users` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`users` (
  `UUID` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(64) NULL DEFAULT NULL,
  `username` VARCHAR(16) NULL DEFAULT NULL,
  `password` VARCHAR(512) NULL DEFAULT NULL,
  `privileges` VARCHAR(32) NULL DEFAULT NULL,
  `language` VARCHAR(2) NULL DEFAULT 'EN',
  `sessionID` VARCHAR(256) NULL DEFAULT NULL,
  `salt` VARCHAR(128) NULL DEFAULT NULL,
  `activationkey` VARCHAR(256) NULL DEFAULT NULL,
  PRIMARY KEY (`UUID`))
ENGINE = InnoDB
AUTO_INCREMENT = 29
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

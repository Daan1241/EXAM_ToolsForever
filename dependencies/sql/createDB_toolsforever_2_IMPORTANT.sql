-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema toolsforever3
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `toolsforever` ;

-- -----------------------------------------------------
-- Schema toolsforever3
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `toolsforever` DEFAULT CHARACTER SET utf8 ;
USE `toolsforever` ;

-- -----------------------------------------------------
-- Table `toolsforever3`.`locations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`locations` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`locations` (
  `locationID` INT(8) NULL,
  `locationname` VARCHAR(64) NOT NULL,
  `locationdescription` VARCHAR(128) NULL DEFAULT NULL,
  PRIMARY KEY (`locationname`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `toolsforever3`.`products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`products` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`products` (
  `productID` INT(11) NOT NULL AUTO_INCREMENT,
  `productname` VARCHAR(256) NOT NULL,
  `productbrand` VARCHAR(64) NULL DEFAULT NULL,
  `producttype` VARCHAR(64) NULL DEFAULT NULL,
  `buyprice` VARCHAR(16) NULL DEFAULT NULL,
  `sellprice` VARCHAR(16) NULL DEFAULT NULL,
  PRIMARY KEY (`productID`, `productname`))
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `toolsforever`.`locations_has_products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`locations_has_products` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`locations_has_products` (
  `ID` INT(8) NOT NULL AUTO_INCREMENT,
  `locations_locationname` VARCHAR(64) NOT NULL,
  `products_productname` VARCHAR(256) NOT NULL,
  `stock` INT(11) NULL DEFAULT NULL,
  `min_stock` INT(11) NULL DEFAULT NULL,
  `products_productID` INT(11) NOT NULL,
  `products_productname1` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_locations_has_products_locations1_idx` (`locations_locationname` ASC),
  INDEX `fk_locations_has_products_products1_idx` (`products_productname` ASC),
  INDEX `fk_locations_has_products_products1_idx1` (`products_productID` ASC, `products_productname1` ASC),
  CONSTRAINT `locations_locationname`
    FOREIGN KEY (`locations_locationname`)
    REFERENCES `toolsforever`.`locations` (`locationname`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_locations_has_products_products1`
    FOREIGN KEY (`products_productID` , `products_productname1`)
    REFERENCES `toolsforever`.`products` (`productID` , `productname`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `toolsforever`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`users` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`users` (
  `UUID` INT(8) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(64) NULL DEFAULT NULL,
  `username` VARCHAR(16) NULL DEFAULT NULL,
  `password` VARCHAR(512) NULL DEFAULT NULL,
  `privileges` VARCHAR(32) NULL DEFAULT NULL,
  `sessionID` VARCHAR(256) NULL DEFAULT NULL,
  `salt` VARCHAR(128) NULL DEFAULT NULL,
  PRIMARY KEY (`UUID`))
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

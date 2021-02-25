-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema toolsforever
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `toolsforever` ;

-- -----------------------------------------------------
-- Schema toolsforever
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `toolsforever` DEFAULT CHARACTER SET utf8 ;
-- -----------------------------------------------------
-- Schema toolsforever_old
-- -----------------------------------------------------
USE `toolsforever` ;

-- -----------------------------------------------------
-- Table `toolsforever`.`locations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`locations` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`locations` (
  `locationID` INT(8) NOT NULL AUTO_INCREMENT,
  `locationname` VARCHAR(64) NOT NULL,
  `locationdescription` VARCHAR(128) NULL,
  PRIMARY KEY (`locationID`, `locationname`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toolsforever`.`products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`products` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`products` (
  `productID` INT NOT NULL AUTO_INCREMENT,
  `productname` VARCHAR(256) NOT NULL,
  `buyprice` INT NULL,
  `sellprice` INT NULL,
  PRIMARY KEY (`productID`, `productname`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toolsforever`.`locations_has_products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`locations_has_products` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`locations_has_products` (
  `ID` INT(8) NOT NULL,
  `locations_locationID` INT(8) NOT NULL,
  `locations_locationname` VARCHAR(64) NOT NULL,
  `stock` INT NULL,
  `min_stock` INT NULL,
  `products_productID` INT NOT NULL,
  `products_productname` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_locations_has_products_locations1_idx` (`locations_locationID` ASC, `locations_locationname` ASC),
  INDEX `fk_locations_has_products_products1_idx` (`products_productID` ASC, `products_productname` ASC),
  CONSTRAINT `fk_locations_has_products_locations1`
    FOREIGN KEY (`locations_locationID` , `locations_locationname`)
    REFERENCES `toolsforever`.`locations` (`locationID` , `locationname`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_locations_has_products_products1`
    FOREIGN KEY (`products_productID` , `products_productname`)
    REFERENCES `toolsforever`.`products` (`productID` , `productname`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toolsforever`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`users` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`users` (
  `UUID` INT(8) NOT NULL,
  `username` VARCHAR(64) NULL DEFAULT NULL,
  `password` VARCHAR(512) NULL DEFAULT NULL,
  `privileges` VARCHAR(32) NULL DEFAULT NULL,
  `sessionID` VARCHAR(256) NULL DEFAULT NULL,
  PRIMARY KEY (`UUID`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

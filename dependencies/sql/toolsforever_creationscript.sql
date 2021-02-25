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
  `locationID` INT NOT NULL,
  `locationname` VARCHAR(128) NULL,
  `locationdescription` VARCHAR(128) NULL,
  PRIMARY KEY (`locationID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toolsforever`.`products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`products` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`products` (
  `productID` INT NOT NULL,
  `productname` VARCHAR(256) NULL,
  `buyprice` INT NULL,
  `sellprice` INT NULL,
  PRIMARY KEY (`productID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toolsforever`.`locations_has_products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`locations_has_products` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`locations_has_products` (
  `ID` INT NOT NULL,
  `locations_locationID` INT NULL,
  `products_productID` INT NULL,
  `stock` INT NULL,
  `min_stock` INT NULL,
  INDEX `fk_locations_has_products_products1_idx` (`products_productID` ASC),
  INDEX `fk_locations_has_products_locations_idx` (`locations_locationID` ASC),
  PRIMARY KEY (`ID`),
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
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toolsforever`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`users` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`users` (
  `UUID` INT NOT NULL,
  `username` VARCHAR(64) NULL DEFAULT NULL,
  `password` VARCHAR(512) NULL DEFAULT NULL,
  `privileges` VARCHAR(128) NULL DEFAULT NULL,
  `sessionID` VARCHAR(256) NULL DEFAULT NULL,
  PRIMARY KEY (`UUID`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

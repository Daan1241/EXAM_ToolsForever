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
  `locationID` INT NULL DEFAULT NULL,
  `locationname` VARCHAR(64) NOT NULL,
  `locationdescription` VARCHAR(128) NULL DEFAULT NULL,
  `locationadress` VARCHAR(256) NOT NULL,
  `zipcode_numbers` VARCHAR(4) NULL DEFAULT NULL,
  `zipcode_letters` VARCHAR(2) NULL DEFAULT NULL,
  PRIMARY KEY (`locationname`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `toolsforever`.`products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`products` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`products` (
  `productID` INT NOT NULL,
  `productname` VARCHAR(256) NOT NULL,
  `productbrand` VARCHAR(64) NULL DEFAULT NULL,
  `producttype` VARCHAR(64) NULL DEFAULT NULL,
  `buyprice` VARCHAR(16) NULL DEFAULT NULL,
  `sellprice` VARCHAR(16) NULL DEFAULT NULL,
  PRIMARY KEY (`productID`, `productname`))
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `toolsforever`.`locations_has_products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toolsforever`.`locations_has_products` ;

CREATE TABLE IF NOT EXISTS `toolsforever`.`locations_has_products` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `locations_locationname` VARCHAR(64) NOT NULL,
  `products_productID` INT NOT NULL,
  `products_productname` VARCHAR(256) NOT NULL,
  `stock` INT NULL DEFAULT NULL,
  `min_stock` INT NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_locations_has_products_locations1_idx` (`locations_locationname` ASC) VISIBLE,
  INDEX `fk_locations_has_products_products1_idx` (`products_productID` ASC, `products_productname` ASC) VISIBLE,
  CONSTRAINT `fk_locations_has_products_products1`
    FOREIGN KEY (`products_productID` , `products_productname`)
    REFERENCES `toolsforever`.`products` (`productID` , `productname`),
  CONSTRAINT `locations_locationname`
    FOREIGN KEY (`locations_locationname`)
    REFERENCES `toolsforever`.`locations` (`locationname`))
ENGINE = InnoDB
AUTO_INCREMENT = 26
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
AUTO_INCREMENT = 28
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

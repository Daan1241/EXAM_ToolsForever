CREATE TABLE `users` (
	`UUID` INT(8) NOT NULL,
	`username` varchar(64) NOT NULL,
	`password` varchar(512) NOT NULL,
	`privileges` varchar(128) NOT NULL,
	`sessionID` varchar(256) NOT NULL,
	PRIMARY KEY (`UUID`)
);

CREATE TABLE `locations` (
	`locationID` INT(8) NOT NULL,
	`locationname` varchar(128) NOT NULL,
	`locationdescription` varchar(128) NOT NULL,
	PRIMARY KEY (`locationID`)
);

CREATE TABLE `products` (
	`productID` INT NOT NULL,
	`productname` varchar(256) NOT NULL,
	`productdescription` varchar(256) NOT NULL,
	`stock` INT(6) NOT NULL,
	`buyprice` varchar(8) NOT NULL,
	`sellprice` varchar(8) NOT NULL,
	PRIMARY KEY (`productID`)
);

CREATE TABLE `locations_products` (
	`ID` INT(8) NOT NULL,
	`locationID` INT(8) NOT NULL,
	`locationname` varchar(128) NOT NULL,
	`locationdescription` varchar(128) NOT NULL,
	`productID` INT NOT NULL,
	`productname` varchar(256) NOT NULL,
	`productdescription` varchar(256) NOT NULL,
	`stock` INT(6) NOT NULL,
	`buyprice` varchar(8) NOT NULL,
	`sellprice` varchar(8) NOT NULL,
	PRIMARY KEY (`ID`)
);

ALTER TABLE `locations_products` ADD CONSTRAINT `locations_products_fk0` FOREIGN KEY (`locationID`) REFERENCES `locations`(`locationID`);

ALTER TABLE `locations_products` ADD CONSTRAINT `locations_products_fk1` FOREIGN KEY (`locationname`) REFERENCES `locations`(`locationname`);

ALTER TABLE `locations_products` ADD CONSTRAINT `locations_products_fk2` FOREIGN KEY (`locationdescription`) REFERENCES `locations`(`locationdescription`);

ALTER TABLE `locations_products` ADD CONSTRAINT `locations_products_fk3` FOREIGN KEY (`productID`) REFERENCES `products`(`productID`);

ALTER TABLE `locations_products` ADD CONSTRAINT `locations_products_fk4` FOREIGN KEY (`productname`) REFERENCES `products`(`productname`);

ALTER TABLE `locations_products` ADD CONSTRAINT `locations_products_fk5` FOREIGN KEY (`productdescription`) REFERENCES `products`(`productdescription`);

ALTER TABLE `locations_products` ADD CONSTRAINT `locations_products_fk6` FOREIGN KEY (`stock`) REFERENCES `products`(`stock`);

ALTER TABLE `locations_products` ADD CONSTRAINT `locations_products_fk7` FOREIGN KEY (`buyprice`) REFERENCES `products`(`buyprice`);

ALTER TABLE `locations_products` ADD CONSTRAINT `locations_products_fk8` FOREIGN KEY (`sellprice`) REFERENCES `products`(`sellprice`);


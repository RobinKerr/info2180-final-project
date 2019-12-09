DROP DATABASE IF EXISTS Bugdb;
CREATE DATABASE Bugdb;
USE Bugdb;

DROP TABLE IF EXISTS Users;

CREATE TABLE Users (`id` INT (11) AUTO_INCREMENT PRIMARY KEY, `firstname` VARCHAR(35) NOT NULL default '',
  `lastname` VARCHAR(35) NOT NULL default '',
  `hash` VARCHAR(35) NOT NULL default '',
  `email` VARCHAR(50) NOT NULL default '',
  `date` DATE,
  `salt` INT(10)
  );
  
INSERT INTO Users (
firstname,lastname, hash, email, date, salt)
VALUES('Raldon', 'Baxter', '47fe5b69916f46e0d6909b9bdc196167', 'admin@bugme.com', '2019-11-29', 12345);

CREATE TABLE Issues (`id` INT (11) AUTO_INCREMENT PRIMARY KEY,
`title` VARCHAR (135) NOT NULL default '',
`description` VARCHAR (200) NOT NULL default '',
`type` CHAR (10) NOT NULL default '',
`priority` CHAR (10) NOT NULL default '',
`status` CHAR (30) NOT NULL default '',
`assigned_to` CHAR (40) NOT NULL default '',
`created_by` CHAR (40) NOT NULL default '',
`created` DATE,
`updated` CHAR (60) NOT NULL default '');


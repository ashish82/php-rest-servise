create database rest;
use rest;
CREATE TABLE `books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `summary` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
INSERT INTO rest.books (id, title, author, summary) VALUES 
(1, 'Three Musketeers', 'Alexander Dumas', 'Three Musketeers'),
(2, 'Meditations', 'Marcus', 'Meditations');
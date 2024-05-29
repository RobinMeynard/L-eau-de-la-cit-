/*Création de la BDD*/
CREATE DATABASE IF NOT EXISTS `leaudelacitetest`;
USE `leaudelacitetest`;

/*Création de la table users pour enregistrer les données utilisateur afin d'implémenter une partie boutique au site vitrine*/
CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(64) NOT NULL,
    `surname` varchar(64) NOT NULL,
    `gender` varchar(8) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `tel` varchar(10) NOT NULL,
    `address` varchar(512) NOT NULL,
    `addresscomp` varchar(512),
    `country` varchar(128) NOT NULL,
    `city` varchar(128) NOT NULL,
    `cp` varchar(64) NOT NULL,
    `admin` BOOLEAN NOT NULL,
    PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


/*Création de la table products où se stocke chaque nouveau produit enregistré par un administrateur*/
CREATE TABLE IF NOT EXISTS `products` (
    `product_id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(128) NOT NULL,
    `type` varchar(128) NOT NULL,
    `description` TEXT NOT NULL,
    `price` float(28) NOT NULL,
    `qteStock` int(255),
    `imgProduct` varchar(512),
    `is_enabled` BOOLEAN NOT NULL,
    PRIMARY KEY (`product_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Création de la table head permettant de comparer les url des pages et ainsi de 
personnaliser le header en fonction de la page sur laquelle l'utilisateur se trouve*/
CREATE TABLE IF NOT EXISTS `head` (
    `page_id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(256) NOT NULL,
    `url` text,
    PRIMARY KEY (`page_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Insertion des valeurs de base du site 
(création du compte administrateur et insertion des pages pour personnaliser le header)*/
INSERT INTO `users` (
    `name`, `surname`, `gender`, `email`, `password`, `tel`, `address`, `country`, `city`, `cp`, `admin`)
    VALUES ('Meynard', 'Robin', 'Mr', 'robin.meynard92@gmail.com', 'adminRM!', '0679501796', 'UNDEFINED', 'France', 'UNDEFINED', 'UNDEFINED', 1);

INSERT INTO `head` (`title`, `url`) VALUES ("L'eau de la cité - Accueil", 'index.php');
INSERT INTO `head` (`title`, `url`) VALUES ("L'eau de la cité - Catalogue", 'catalogue.php');
INSERT INTO `head` (`title`, `url`) VALUES ("L'eau de la cité - Login", 'login.php');
INSERT INTO `head` (`title`, `url`) VALUES ("Où nous trouver ?", 'ounoustrouver.php');
INSERT INTO `head` (`title`, `url`) VALUES ("L'eau de la cité - Panier", 'panier.php');
INSERT INTO `head` (`title`, `url`) VALUES ("Qui sommes nous ?", 'quisommesnous.php');
INSERT INTO `head` (`title`, `url`) VALUES ("L'eau de la cité - Utilisateur", 'session.php');
INSERT INTO `head` (`title`, `url`) VALUES ("L'eau de la cité - inscription", 'sign-in.php');
INSERT INTO `head` (`title`, `url`) VALUES ("Gestion du catalogue", 'products.php');
INSERT INTO `head` (`title`, `url`) VALUES ("L'eau de la cité - ", 'productSheet.php');
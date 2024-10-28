-- Santi Onieva

CREATE DATABASE IF NOT EXISTS `Pt04_Santi_Onieva`;

USE `Pt04_Santi_Onieva`;

CREATE TABLE `usuaris` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alies` varchar(50) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `nom_complet` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- Modifiquem la taula d'usuaris per afegir la part del token de recuperació de contrasenya
ALTER TABLE `usuaris`
ADD COLUMN `token_recuperacio` VARCHAR(255) NULL DEFAULT NULL,
ADD COLUMN `expiracio_token` TIMESTAMP NULL DEFAULT NULL;

CREATE TABLE `articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titol` varchar(255) NOT NULL,
  `cos` text NOT NULL,
  `creat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modificat` timestamp NULL DEFAULT NULL,
  `autor` int NOT NULL,
  `ruta_imatge` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_autor` (`autor`),
  CONSTRAINT `fk_autor` FOREIGN KEY (`autor`) REFERENCES `usuaris` (`id`) ON DELETE CASCADE
);
-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Sam 26 Juin 2021 à 12:20
-- Version du serveur: 5.5.8
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `inscription`
--
CREATE DATABASE `inscription` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `inscription`;

-- --------------------------------------------------------

--
-- Structure de la table `demandes`
--

CREATE TABLE IF NOT EXISTS `demandes` (
  `id_demandes` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `id_user` varchar(15) NOT NULL,
  `id_etudiants` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_demandes`),
  KEY `id_user` (`id_user`),
  KEY `id_etudiants` (`id_etudiants`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `demandes`
--


-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE IF NOT EXISTS `etudiants` (
  `id_etudiants` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `habitation` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `seriebac` varchar(25) NOT NULL,
  `mentionbac` varchar(25) NOT NULL,
  `id_user` varchar(15) NOT NULL,
  `id_filieres` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id_etudiants`),
  KEY `id_user` (`id_user`),
  KEY `id_filieres` (`id_filieres`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `etudiants`
--

INSERT INTO `etudiants` (`id_etudiants`, `nom`, `prenom`, `habitation`, `email`, `seriebac`, `mentionbac`, `id_user`, `id_filieres`) VALUES
(1, 'Konan David', 'Vigile', 'Abidjan', 'salomondiei08@gamil.com', 'C', 'Bien', 'a', 1),
(2, 'Konan David', 'Vigile', 'Abidjan', 'salomondiei08@gamil.com', 'C', 'ABien', 'a', 2),
(3, 'Konan Kpele', 'Lucien', 'Korogho', 'salomondiei08@gamil.com', 'B', 'Bien', 'b', 3),
(4, 'Loli dmour', 'Pascal', 'Abidjan', 'salomondiei08@gamil.com', 'A1', 'ABien', 'd', 5),
(5, 'Julien Pall', 'Polo', 'Abidjan', 'salomondiei08@gamil.com', 'E', 'TBien', 'e', 6),
(6, 'Lucas Pesquet David', 'Tonto', 'Yamoussoukro', 'salomondiei08@gamil.com', 'D', 'ABien', 'f', 7),
(9, 'Salomon', 'Diei', 'Bouaké', 'salomondiei08@gmail.com', 'Serie E', 'Excellent', 'test', 1),
(10, 'lolo', 'Diei', 'Bouaké', 'salomondiei08@gmail.com', 'Serie E', 'Excellent', 'test', 0),
(11, 'lolo', 'lolo', 'Abidjan', 'salomondiei08@gmail.com', 'Serie D', 'Excellent', 'test', 1),
(12, 'zjsnd', 'cdzsqzexsaw', 'dzq', 'ezxsawq@oiu.vcpcù', 'Serie E', 'Excellent', 'test', 1),
(13, 'fezdsfzedsqx', 'zfed', 'dza', 'qsd', 'sqdzadaz', 'zad', 'test', 1),
(14, 'kouadio', 'lolo', 'Bouaké', 'salomondiei08@gmail.com', 'Serie E', 'Bien', 'test', 0),
(15, 'lLOLKD', 'GRDZ', 'REZD', 'FEZDQSEZFD', '4DZ', 'FEDS', 'test', 1),
(16, 'lalalal', 'Diei', 'Bouaké', 'salomondiei08@gmail.com', 'Serie D', 'Excellent', 'test', 1);

-- --------------------------------------------------------

--
-- Structure de la table `filieres`
--

CREATE TABLE IF NOT EXISTS `filieres` (
  `id_filieres` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id_filieres`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `filieres`
--

INSERT INTO `filieres` (`id_filieres`, `name`, `description`) VALUES
(1, 'L1 Genie Logiciel', 'Apprendre à developper des applications pour repondre aux besoins du monde réel.'),
(2, 'L1 Réseaux et Téléco', 'Etre capable de réaliser la conception de réseau et de systèmespour la transmission de donneés.'),
(3, 'L1 Marketing et Fina', 'Former des spécialistes en marketing et dans la finance.'),
(4, 'L1 Communication et ', 'Former des managers d entreprise competent et flexible.'),
(5, 'L1 Genie Logiciel', 'Apprendre à developper des applications pour repondre aux besoins du monde réel.'),
(6, 'L1 Réseaux et Téléco', 'Etre capable de réaliser la conception de réseau et de systèmespour la transmission de donneés.'),
(7, 'L1 Marketing et Fina', 'Former des spécialistes en marketing et dans la finance.'),
(8, 'L1 Communication et ', 'Former des managers d entreprise competent et flexible.');

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

CREATE TABLE IF NOT EXISTS `reponses` (
  `id_reponses` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `id_user` varchar(15) NOT NULL,
  `id_etudiants` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_reponses`),
  KEY `id_user` (`id_user`),
  KEY `id_etudiants` (`id_etudiants`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `reponses`
--


-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` varchar(15) NOT NULL,
  `passwd` varchar(15) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `passwd`, `name`, `firstname`, `email`) VALUES
('test', 'test', 'DIEI', 'salomondiei08@gmail.com', 'salomondiei08@gmail.com'),
('a', 'a', 'DIEI', 'salomondiei08@gmail.com', 'salomondiei08@gmail.com'),
('b', 'b', 'DIEI', 'salomondiei08@gmail.com', 'salomondiei08@gmail.com'),
('c', 'c', 'DIEI', 'salomondiei08@gmail.com', 'salomondiei08@gmail.com'),
('d', 'd', 'DIEI', 'salomondiei08@gmail.com', 'salomondiei08@gmail.com'),
('e', 'e', 'DIEI', 'salomondiei08@gmail.com', 'salomondiei08@gmail.com'),
('f', 'f', 'DIEI', 'salomondiei08@gmail.com', 'salomondiei08@gmail.com'),
('g', 'g', 'DIEI', 'salomondiei08@gmail.com', 'salomondiei08@gmail.com'),
('h', 'h', 'DIEI', 'salomondiei08@gmail.com', 'salomondiei08@gmail.com');

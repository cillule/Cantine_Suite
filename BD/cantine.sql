-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 18 Mars 2015 à 20:06
-- Version du serveur :  5.6.21
-- Version de PHP :  5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `cantine`
--
CREATE DATABASE IF NOT EXISTS `cantine` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cantine`;

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

CREATE TABLE IF NOT EXISTS `document` (
`id_document` int(10) NOT NULL,
  `nom_document` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `document`
--

INSERT INTO `document` (`id_document`, `nom_document`) VALUES
(2, 'autorisation_de_prelevement.pdf'),
(3, 'ReglementCantine_-2014-2015.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `enfant`
--

CREATE TABLE IF NOT EXISTS `enfant` (
`id_enfant` int(11) NOT NULL,
  `id_famille` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `classe` varchar(10) NOT NULL,
  `regime_alimentaire` varchar(30) NOT NULL,
  `allergie` varchar(30) NOT NULL,
  `type_inscription` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `enfant`
--

INSERT INTO `enfant` (`id_enfant`, `id_famille`, `nom`, `prenom`, `classe`, `regime_alimentaire`, `allergie`, `type_inscription`) VALUES
(1, 12, 'Foster', 'Sammy', 'CE2', 'Végétarien', '', 'Annuelle'),
(2, 12, 'Foster', 'Fancy', 'CP', 'Végétarien', '', 'Occasionnelle'),
(3, 12, 'Foster', 'Peter', 'CM1', 'Rien de particulier', 'Botox', 'Occasionnelle'),
(4, 11, 'Goura', 'Nacim', 'CE2', 'Végétarien', '', 'Annuelle'),
(5, 13, 'Guillot', 'Jeannine', 'CM2', 'Végétarien', '', 'Annuelle');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE IF NOT EXISTS `facture` (
`id_facture` int(11) NOT NULL,
  `montant` float NOT NULL,
  `mois` int(2) NOT NULL,
  `année` int(4) NOT NULL,
  `id_enfant` int(11) NOT NULL,
  `reglee` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `facture`
--

INSERT INTO `facture` (`id_facture`, `montant`, `mois`, `année`, `id_enfant`, `reglee`) VALUES
(1, 14, 3, 2015, 1, 1),
(2, 17.5, 4, 2015, 1, 1),
(3, 3.5, 2, 2015, 1, 1),
(4, 24.5, 3, 2015, 1, 1),
(5, 10.5, 3, 2015, 3, 1),
(6, 17.5, 4, 2015, 1, 1),
(7, 3.5, 2, 2015, 1, 1),
(8, 24.5, 3, 2015, 1, 1),
(9, 10.5, 3, 2015, 3, 1),
(10, 17.5, 4, 2015, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `famille`
--

CREATE TABLE IF NOT EXISTS `famille` (
`id_famille` int(11) NOT NULL,
  `nom_famille` varchar(30) NOT NULL,
  `id_resp_1` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `famille`
--

INSERT INTO `famille` (`id_famille`, `nom_famille`, `id_resp_1`) VALUES
(11, 'Francis', 3),
(12, 'Foster', 5),
(13, 'Guillot', 6);

-- --------------------------------------------------------

--
-- Structure de la table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
`id` int(11) NOT NULL,
  `question` varchar(200) NOT NULL,
  `reponse` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `faq`
--

INSERT INTO `faq` (`id`, `question`, `reponse`) VALUES
(1, 'Quelle sont les horaires d''ouverture de la cantine?', 'Du lundi au vendredi. '),
(2, 'Comment contacter la trésorière ?', 'A l''adresse suivante: katinka.sutter@gmail.com ');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
`id_message` int(20) NOT NULL,
  `contenu` varchar(350) NOT NULL,
  `intitule` varchar(52) NOT NULL,
  `id_recepteur` int(11) NOT NULL,
  `id_expediteur` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id_message`, `contenu`, `intitule`, `id_recepteur`, `id_expediteur`) VALUES
(1, 'Bonjour, je vous souhaite le bienvenue à la cantine!', 'Bienvenue à la Cantine', 11, 0),
(2, 'Bonjour, je vous souhaite le bienvenue à la cantine!', 'Bienvenue à la Cantine', 12, 0),
(3, 'Merci de votre gentilesse!', 'Merci', 1, 11);

-- --------------------------------------------------------

--
-- Structure de la table `repas`
--

CREATE TABLE IF NOT EXISTS `repas` (
  `date` date NOT NULL,
  `id_enfant_repas` int(11) NOT NULL,
  `present` tinyint(1) NOT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `repas`
--

INSERT INTO `repas` (`date`, `id_enfant_repas`, `present`, `prix`) VALUES
('2015-02-01', 1, 0, 3.5),
('2015-03-01', 3, 0, 3.5),
('2015-03-10', 3, 0, 3.5),
('2015-03-12', 4, 0, 3.5),
('2015-03-12', 5, 0, 3.5),
('2015-03-13', 5, 0, 3.5),
('2015-03-16', 1, 1, 3.5),
('2015-03-16', 2, 1, 4.5),
('2015-03-16', 3, 1, 4.5),
('2015-03-16', 4, 1, 4.5),
('2015-03-16', 5, 1, 3.5),
('2015-03-17', 1, 0, 3.5),
('2015-03-17', 4, 0, 3.5),
('2015-03-17', 5, 0, 3.5),
('2015-03-18', 1, 1, 4.5),
('2015-03-18', 4, 0, 3.5),
('2015-03-18', 5, 0, 3.5),
('2015-03-19', 1, 0, 3.5),
('2015-03-19', 4, 0, 3.5),
('2015-03-19', 5, 0, 3.5),
('2015-03-20', 5, 0, 3.5),
('2015-03-23', 1, 0, 3.5),
('2015-03-23', 5, 0, 3.5),
('2015-03-24', 4, 0, 3.5),
('2015-03-24', 5, 0, 3.5),
('2015-03-25', 4, 0, 3.5),
('2015-03-25', 5, 0, 3.5),
('2015-03-26', 4, 0, 3.5),
('2015-03-26', 5, 0, 3.5),
('2015-03-27', 1, 0, 3.5),
('2015-03-30', 1, 0, 3.5),
('2015-03-30', 5, 0, 3.5),
('2015-03-31', 4, 0, 3.5),
('2015-03-31', 5, 0, 3.5),
('2015-04-01', 4, 0, 3.5),
('2015-04-01', 5, 0, 3.5),
('2015-04-02', 4, 0, 3.5),
('2015-04-02', 5, 0, 3.5),
('2015-04-03', 5, 0, 3.5),
('2015-04-06', 1, 0, 3.5),
('2015-04-06', 5, 0, 3.5),
('2015-04-07', 1, 0, 3.5),
('2015-04-07', 4, 0, 3.5),
('2015-04-07', 5, 0, 3.5),
('2015-04-08', 1, 0, 3.5),
('2015-04-08', 4, 0, 3.5),
('2015-04-08', 5, 0, 3.5),
('2015-04-09', 1, 0, 3.5),
('2015-04-09', 4, 0, 3.5),
('2015-04-09', 5, 0, 3.5),
('2015-04-10', 1, 0, 3.5),
('2015-04-10', 5, 0, 3.5),
('2015-04-13', 5, 0, 3.5),
('2015-04-14', 4, 0, 3.5),
('2015-04-14', 5, 0, 3.5),
('2015-04-15', 4, 0, 3.5),
('2015-04-15', 5, 0, 3.5),
('2015-04-16', 4, 0, 3.5),
('2015-04-16', 5, 0, 3.5),
('2015-04-17', 5, 0, 3.5),
('2015-04-20', 5, 0, 3.5),
('2015-04-21', 4, 0, 3.5),
('2015-04-21', 5, 0, 3.5),
('2015-04-22', 4, 0, 3.5),
('2015-04-22', 5, 0, 3.5),
('2015-04-23', 4, 0, 3.5),
('2015-04-23', 5, 0, 3.5),
('2015-04-24', 5, 0, 3.5),
('2015-04-27', 5, 0, 3.5),
('2015-04-28', 4, 0, 3.5),
('2015-04-28', 5, 0, 3.5),
('2015-04-29', 4, 0, 3.5),
('2015-04-29', 5, 0, 3.5),
('2015-04-30', 4, 0, 3.5),
('2015-04-30', 5, 0, 3.5),
('2015-05-01', 5, 0, 3.5),
('2015-05-04', 5, 0, 3.5),
('2015-05-05', 4, 0, 3.5),
('2015-05-05', 5, 0, 3.5),
('2015-05-06', 4, 0, 3.5),
('2015-05-06', 5, 0, 3.5),
('2015-05-07', 4, 0, 3.5),
('2015-05-07', 5, 0, 3.5),
('2015-05-08', 5, 0, 3.5),
('2015-05-11', 5, 0, 3.5),
('2015-05-12', 4, 0, 3.5),
('2015-05-12', 5, 0, 3.5),
('2015-05-13', 4, 0, 3.5),
('2015-05-13', 5, 0, 3.5),
('2015-05-14', 4, 0, 3.5),
('2015-05-14', 5, 0, 3.5),
('2015-05-15', 5, 0, 3.5),
('2015-05-18', 5, 0, 3.5),
('2015-05-19', 4, 0, 3.5),
('2015-05-19', 5, 0, 3.5),
('2015-05-20', 4, 0, 3.5),
('2015-05-20', 5, 0, 3.5),
('2015-05-21', 4, 0, 3.5),
('2015-05-21', 5, 0, 3.5),
('2015-05-22', 5, 0, 3.5),
('2015-05-25', 5, 0, 3.5),
('2015-05-26', 4, 0, 3.5),
('2015-05-26', 5, 0, 3.5),
('2015-05-27', 4, 0, 3.5),
('2015-05-27', 5, 0, 3.5),
('2015-05-28', 4, 0, 3.5),
('2015-05-28', 5, 0, 3.5),
('2015-05-29', 5, 0, 3.5),
('2015-06-01', 5, 0, 3.5),
('2015-06-02', 4, 0, 3.5),
('2015-06-02', 5, 0, 3.5),
('2015-06-03', 4, 0, 3.5),
('2015-06-03', 5, 0, 3.5),
('2015-06-04', 4, 0, 3.5),
('2015-06-04', 5, 0, 3.5),
('2015-06-05', 5, 0, 3.5),
('2015-06-08', 5, 0, 3.5),
('2015-06-09', 4, 0, 3.5),
('2015-06-09', 5, 0, 3.5),
('2015-06-10', 4, 0, 3.5),
('2015-06-10', 5, 0, 3.5),
('2015-06-11', 4, 0, 3.5),
('2015-06-11', 5, 0, 3.5),
('2015-06-12', 5, 0, 3.5),
('2015-06-15', 5, 0, 3.5),
('2015-06-16', 4, 0, 3.5),
('2015-06-16', 5, 0, 3.5),
('2015-06-17', 4, 0, 3.5),
('2015-06-17', 5, 0, 3.5),
('2015-06-18', 4, 0, 3.5),
('2015-06-18', 5, 0, 3.5),
('2015-06-19', 5, 0, 3.5),
('2015-06-22', 5, 0, 3.5),
('2015-06-23', 4, 0, 3.5),
('2015-06-23', 5, 0, 3.5),
('2015-06-24', 4, 0, 3.5),
('2015-06-24', 5, 0, 3.5),
('2015-06-25', 4, 0, 3.5),
('2015-06-25', 5, 0, 3.5),
('2015-06-26', 5, 0, 3.5),
('2015-06-29', 5, 0, 3.5),
('2015-06-30', 4, 0, 3.5),
('2015-06-30', 5, 0, 3.5),
('2015-07-01', 4, 0, 3.5),
('2015-07-01', 5, 0, 3.5),
('2015-07-02', 4, 0, 3.5),
('2015-07-02', 5, 0, 3.5),
('2015-07-03', 5, 0, 3.5);

-- --------------------------------------------------------

--
-- Structure de la table `responsable`
--

CREATE TABLE IF NOT EXISTS `responsable` (
`id_responsable` int(11) NOT NULL,
  `identité` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `adresse` text NOT NULL,
  `ville` text NOT NULL,
  `mode_payement` text NOT NULL,
  `rib` int(11) NOT NULL,
  `mail` varchar(30) NOT NULL,
  `mdp` varchar(250) NOT NULL,
  `tel_mobile` varchar(20) NOT NULL,
  `tel_travail` varchar(10) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `gestionnaire` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `responsable`
--

INSERT INTO `responsable` (`id_responsable`, `identité`, `nom`, `prenom`, `adresse`, `ville`, `mode_payement`, `rib`, `mail`, `mdp`, `tel_mobile`, `tel_travail`, `admin`, `gestionnaire`) VALUES
(1, 0, 'admin', 'admin', '', '', '', 0, 'admin@yahoo.fr', '12345678', '0607050609', '0474653219', 1, 0),
(2, 0, 'responsable', 'responsable', '', '', '', 0, 'gestionnaire@yahoo.fr', '12345', '', '', 0, 1),
(3, 0, 'Pages', 'Francis', 'Sud', '', '', 0, 'francis.pages@yahoo.fr', '6r7KysDmvWTm', '02458596', '', 0, 0),
(5, 0, 'Foster', '', '', '', '', 0, 'foster_fam@yahoo.fr', 'GTErmRz8XBXm', '', '', 0, 0),
(6, 0, 'Guillot', 'Lucille', '1, allée des écoliers', '', '', 0, 'lucille.guillot@gmail.com', 'ysw51NIIb1bE', '04-74-51-39-03', '', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `tarifs`
--

CREATE TABLE IF NOT EXISTS `tarifs` (
  `id` int(8) NOT NULL,
  `prixAetM` float NOT NULL,
  `prixO` float NOT NULL,
  `prixHD` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tarifs`
--

INSERT INTO `tarifs` (`id`, `prixAetM`, `prixO`, `prixHD`) VALUES
(1, 3.5, 4, 4.5);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `document`
--
ALTER TABLE `document`
 ADD PRIMARY KEY (`id_document`);

--
-- Index pour la table `enfant`
--
ALTER TABLE `enfant`
 ADD PRIMARY KEY (`id_enfant`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
 ADD PRIMARY KEY (`id_facture`);

--
-- Index pour la table `famille`
--
ALTER TABLE `famille`
 ADD PRIMARY KEY (`id_famille`);

--
-- Index pour la table `faq`
--
ALTER TABLE `faq`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
 ADD PRIMARY KEY (`id_message`);

--
-- Index pour la table `repas`
--
ALTER TABLE `repas`
 ADD PRIMARY KEY (`date`,`id_enfant_repas`);

--
-- Index pour la table `responsable`
--
ALTER TABLE `responsable`
 ADD PRIMARY KEY (`id_responsable`), ADD UNIQUE KEY `id_responsable` (`id_responsable`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `document`
--
ALTER TABLE `document`
MODIFY `id_document` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `enfant`
--
ALTER TABLE `enfant`
MODIFY `id_enfant` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
MODIFY `id_facture` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `famille`
--
ALTER TABLE `famille`
MODIFY `id_famille` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `faq`
--
ALTER TABLE `faq`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
MODIFY `id_message` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `responsable`
--
ALTER TABLE `responsable`
MODIFY `id_responsable` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;



-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 19 Mars 2015 à 12:59
-- Version du serveur :  5.6.21
-- Version de PHP :  5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `cantine`
--

-- --------------------------------------------------------

--
-- Structure de la table `vacances`
--

CREATE TABLE IF NOT EXISTS `vacances` (
`id_vacances` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;



INSERT INTO `vacances` (`id_vacances`, `date_debut`, `date_fin`) VALUES
(1, '2015-10-20', '2015-11-02'),
(2, '2016-02-13', '2016-02-29'),
(3, '2016-02-13', '2016-02-29'),
(4, '2015-04-11', '2015-04-27'),
(5, '2015-07-05', '2015-08-31');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `vacances`
--
ALTER TABLE `vacances`
 ADD PRIMARY KEY (`id_vacances`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `vacances`
--
ALTER TABLE `vacances`
MODIFY `id_vacances` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

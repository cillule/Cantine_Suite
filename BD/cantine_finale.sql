-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 16 Juillet 2015 à 12:22
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
-- Structure de la table `classe`
--

CREATE TABLE IF NOT EXISTS `classe` (
`id_classe` int(11) NOT NULL,
  `niveau` varchar(50) NOT NULL,
  `nom_enseignant` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `document`
--

CREATE TABLE IF NOT EXISTS `document` (
`id_document` int(10) NOT NULL,
  `nom_document` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `enfant`
--

CREATE TABLE IF NOT EXISTS `enfant` (
`id_enfant` int(11) NOT NULL,
  `id_famille` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `classe` int(11) NOT NULL,
  `regime_alimentaire` varchar(30) NOT NULL,
  `allergie` varchar(30) NOT NULL,
  `type_inscription` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;


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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `famille`
--

CREATE TABLE IF NOT EXISTS `famille` (
`id_famille` int(11) NOT NULL,
  `nom_famille` varchar(30) NOT NULL,
  `id_resp_1` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;


--
-- Structure de la table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL,
  `question` varchar(200) NOT NULL,
  `reponse` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;



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
  `tel_travail` varchar(20) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `gestionnaire` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;



--
-- Structure de la table `schema_inscription_annuelle`
--

CREATE TABLE IF NOT EXISTS `schema_inscription_annuelle` (
`schem_id` int(11) NOT NULL,
  `schem_id_enfant` int(11) NOT NULL,
  `schem_lundi` tinyint(1) NOT NULL DEFAULT '0',
  `schem_mardi` tinyint(1) NOT NULL DEFAULT '0',
  `schem_mercredi` tinyint(1) NOT NULL DEFAULT '0',
  `schem_jeudi` tinyint(1) NOT NULL DEFAULT '0',
  `schem_vendredi` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;



--
-- Structure de la table `tarifs`
--

CREATE TABLE IF NOT EXISTS `tarifs` (
  `tarif_id` varchar(10) NOT NULL,
  `tarif_mont` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tarifs`
--

INSERT INTO `tarifs` (`tarif_id`, `tarif_mont`) VALUES
('prixAetM', 3.5),
('prixHD', 3.65),
('prixHebdo', 3.5),
('prixPasIns', 4.3);

-- --------------------------------------------------------

--
-- Structure de la table `vacances`
--

CREATE TABLE IF NOT EXISTS `vacances` (
`id_vacances` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `vacances`
--

INSERT INTO `vacances` (`id_vacances`, `date_debut`, `date_fin`) VALUES
(1, '2015-10-20', '2015-11-02'),
(2, '2016-02-13', '2016-02-29'),
(3, '2016-02-13', '2016-02-29'),
(4, '2015-04-11', '2015-04-29'),
(5, '2015-07-31', '2015-09-01');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
 ADD PRIMARY KEY (`id_classe`);

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
-- Index pour la table `schema_inscription_annuelle`
--
ALTER TABLE `schema_inscription_annuelle`
 ADD PRIMARY KEY (`schem_id`), ADD UNIQUE KEY `schem_id_enfant` (`schem_id_enfant`);

--
-- Index pour la table `tarifs`
--
ALTER TABLE `tarifs`
 ADD PRIMARY KEY (`tarif_id`);

--
-- Index pour la table `vacances`
--
ALTER TABLE `vacances`
 ADD PRIMARY KEY (`id_vacances`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `classe`
--
ALTER TABLE `classe`
MODIFY `id_classe` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `document`
--
ALTER TABLE `document`
MODIFY `id_document` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `enfant`
--
ALTER TABLE `enfant`
MODIFY `id_enfant` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
MODIFY `id_facture` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `famille`
--
ALTER TABLE `famille`
MODIFY `id_famille` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
MODIFY `id_message` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `responsable`
--
ALTER TABLE `responsable`
MODIFY `id_responsable` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `schema_inscription_annuelle`
--
ALTER TABLE `schema_inscription_annuelle`
MODIFY `schem_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT pour la table `vacances`
--
ALTER TABLE `vacances`
MODIFY `id_vacances` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

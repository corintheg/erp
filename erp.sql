-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 11 mars 2025 à 12:49
-- Version du serveur : 8.0.40
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `erp`
--

-- --------------------------------------------------------

--
-- Structure de la table `conges`
--

CREATE TABLE `conges` (
                          `id_conge` int NOT NULL,
                          `id_employe` int NOT NULL,
                          `type_conge` enum('RTT','CP','Maladie') NOT NULL,
                          `date_debut` date NOT NULL,
                          `date_fin` date NOT NULL,
                          `statut` enum('En attente','Validé','Annulé') NOT NULL DEFAULT 'En attente',
                          `commentaires` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `conges`
--

INSERT INTO `conges` (`id_conge`, `id_employe`, `type_conge`, `date_debut`, `date_fin`, `statut`, `commentaires`) VALUES
                                                                                                                      (1, 1, 'CP', '2025-07-01', '2025-07-15', 'Validé', 'Congés d\'été'),
                                                                                                                      (2, 2, 'RTT', '2025-06-10', '2025-06-12', 'Validé', 'RTT pris sur une période calme');

-- --------------------------------------------------------

--
-- Structure de la table `employes`
--

CREATE TABLE `employes` (
                            `id_employe` int NOT NULL,
                            `nom` varchar(100) NOT NULL,
                            `prenom` varchar(100) NOT NULL,
                            `email` varchar(150) NOT NULL,
                            `telephone` varchar(50) NOT NULL,
                            `date_embauche` date NOT NULL,
                            `date_debauche` date DEFAULT NULL,
                            `departement` enum('RH','Finance','Informatique','Livraison') NOT NULL,
                            `actif` tinyint NOT NULL DEFAULT '1',
                            `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                            `date_modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `employes`
--

INSERT INTO `employes` (`id_employe`, `nom`, `prenom`, `email`, `telephone`, `date_embauche`, `date_debauche`, `departement`, `actif`, `date_creation`, `date_modification`) VALUES
                                                                                                                                                                                 (1, 'Adjassa', 'Aime', 'adjassa.aime@erp.com', '0102030405', '2020-01-15', NULL, 'RH', 1, '2025-03-11 11:45:10', '2025-03-11 11:45:10'),
                                                                                                                                                                                 (2, 'Varrel', 'Mathis', 'varrel.mathis@erp.com', '0102030406', '2019-05-10', NULL, 'Finance', 1, '2025-03-11 11:45:10', '2025-03-11 11:45:10'),
                                                                                                                                                                                 (3, 'LeClech', 'Paul', 'leclech.paul@erp.com', '0102030407', '2018-07-20', NULL, 'Livraison', 1, '2025-03-11 11:45:10', '2025-03-11 11:45:10'),
                                                                                                                                                                                 (4, 'Guerain', 'Corinthe', 'guerain.corinthe@erp.com', '0102030408', '2021-03-05', NULL, 'Informatique', 1, '2025-03-11 11:45:10', '2025-03-11 11:45:10');

-- --------------------------------------------------------

--
-- Structure de la table `finances`
--

CREATE TABLE `finances` (
                            `id_finance` int NOT NULL,
                            `type_operation` enum('dépense','revenu','facture','taxe') NOT NULL,
                            `description` text,
                            `montant` decimal(10,2) NOT NULL,
                            `date_operation` date NOT NULL,
                            `categorie` enum('Marketing','Salaire','Fournisseur') DEFAULT NULL,
                            `id_fournisseur` int DEFAULT NULL,
                            `statut` enum('Payé','En attente','Annulé') DEFAULT 'En attente',
                            `reference_facture` varchar(100) DEFAULT NULL,
                            `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
                            `date_modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `finances`
--

INSERT INTO `finances` (`id_finance`, `type_operation`, `description`, `montant`, `date_operation`, `categorie`, `id_fournisseur`, `statut`, `reference_facture`, `date_creation`, `date_modification`) VALUES
                                                                                                                                                                                                            (1, 'dépense', 'Achat de fournitures', 200.00, '2025-03-01', 'Fournisseur', 1, 'Payé', 'FAC-001', '2025-03-11 13:47:30', '2025-03-11 13:47:30'),
                                                                                                                                                                                                            (2, 'revenu', 'Vente de produit A', 150.00, '2025-03-15', 'Marketing', NULL, 'Payé', NULL, '2025-03-11 13:47:30', '2025-03-11 13:47:30');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
                                `id_fournisseur` int NOT NULL,
                                `nom` varchar(100) NOT NULL,
                                `contact` varchar(100) DEFAULT NULL,
                                `email` varchar(150) NOT NULL,
                                `telephone` varchar(50) NOT NULL,
                                `adresse` text,
                                `site_web` varchar(150) DEFAULT NULL,
                                `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                `date_modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id_fournisseur`, `nom`, `contact`, `email`, `telephone`, `adresse`, `site_web`, `date_creation`, `date_modification`) VALUES
                                                                                                                                                       (1, 'Fournisseur A', 'Jean Dupont', 'contact@fournisseura.com', '0123456789', '123 rue A, Ville', 'www.fournisseura.com', '2025-03-11 11:45:10', '2025-03-11 11:45:10'),
                                                                                                                                                       (2, 'Fournisseur B', 'Marie Durant', 'contact@fournisseurb.com', '0987654321', '456 rue B, Ville', 'www.fournisseurb.com', '2025-03-11 11:45:10', '2025-03-11 11:45:10');

-- --------------------------------------------------------

--
-- Structure de la table `historique_salaires`
--

CREATE TABLE `historique_salaires` (
                                       `id_historique_salaires` int NOT NULL,
                                       `id_salaire` int NOT NULL,
                                       `montant_paye` decimal(10,2) NOT NULL,
                                       `date_paiement` date NOT NULL,
                                       `commentaire` text,
                                       `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
                                       `date_modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `historique_salaires`
--

INSERT INTO `historique_salaires` (`id_historique_salaires`, `id_salaire`, `montant_paye`, `date_paiement`, `commentaire`, `date_creation`, `date_modification`) VALUES
                                                                                                                                                                     (1, 1, 3000.00, '2025-02-28', 'Salaire du mois de février', '2025-03-11 13:47:08', '2025-03-11 13:47:08'),
                                                                                                                                                                     (2, 2, 3200.00, '2025-02-28', 'Salaire du mois de février', '2025-03-11 13:47:08', '2025-03-11 13:47:08'),
                                                                                                                                                                     (3, 3, 2800.00, '2025-02-28', 'Salaire du mois de février', '2025-03-11 13:47:08', '2025-03-11 13:47:08'),
                                                                                                                                                                     (4, 4, 2500.00, '2025-02-28', 'Salaire du mois de février', '2025-03-11 13:47:08', '2025-03-11 13:47:08');

-- --------------------------------------------------------

--
-- Structure de la table `livraisons`
--

CREATE TABLE `livraisons` (
                              `id_livraison` int NOT NULL,
                              `reference_commande` varchar(100) NOT NULL,
                              `id_fournisseur` int DEFAULT NULL,
                              `destinataire` varchar(150) NOT NULL,
                              `statut_livraison` enum('En cours','Livré','Annulé') NOT NULL DEFAULT 'En cours',
                              `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                              `date_livraison` datetime NOT NULL,
                              `commentaires` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `livraisons`
--

INSERT INTO `livraisons` (`id_livraison`, `reference_commande`, `id_fournisseur`, `destinataire`, `statut_livraison`, `date_creation`, `date_livraison`, `commentaires`) VALUES
                                                                                                                                                                             (1, 'CMD-001', 1, 'Client A', 'En cours', '2025-03-11 13:48:34', '2025-03-20 09:00:00', 'Livraison prévue pour le 20 mars'),
                                                                                                                                                                             (2, 'CMD-002', 2, 'Client B', 'Livré', '2025-03-11 13:48:34', '2025-03-18 14:00:00', 'Livraison effectuée');

-- --------------------------------------------------------

--
-- Structure de la table `mouvements_stock`
--

CREATE TABLE `mouvements_stock` (
                                    `id_mouvement` int NOT NULL,
                                    `id_produit` int NOT NULL,
                                    `type_mouvement` enum('Entrée','Sortie') NOT NULL,
                                    `quantite` int NOT NULL,
                                    `date_mouvement` datetime NOT NULL,
                                    `commentaire` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `mouvements_stock`
--

INSERT INTO `mouvements_stock` (`id_mouvement`, `id_produit`, `type_mouvement`, `quantite`, `date_mouvement`, `commentaire`) VALUES
                                                                                                                                 (1, 1, 'Entrée', 100, '2025-03-10 10:00:00', 'Réception initiale du stock'),
                                                                                                                                 (2, 2, 'Entrée', 50, '2025-03-10 10:05:00', 'Réception initiale du stock'),
                                                                                                                                 (3, 1, 'Sortie', 10, '2025-03-15 15:00:00', 'Vente');

-- --------------------------------------------------------

--
-- Structure de la table `planning_rh`
--

CREATE TABLE `planning_rh` (
                               `id_planning` int NOT NULL,
                               `id_employe` int DEFAULT NULL,
                               `type_evenement` enum('Réunion','Congés','Formation') NOT NULL,
                               `date_debut` datetime NOT NULL,
                               `date_fin` datetime NOT NULL,
                               `lieu` varchar(150) NOT NULL,
                               `description` text,
                               `cree_par` int NOT NULL,
                               `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                               `date_modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `planning_rh`
--

INSERT INTO `planning_rh` (`id_planning`, `id_employe`, `type_evenement`, `date_debut`, `date_fin`, `lieu`, `description`, `cree_par`, `date_creation`, `date_modification`) VALUES
                                                                                                                                                                                 (1, 1, 'Réunion', '2025-04-01 09:00:00', '2025-04-01 11:00:00', 'Salle A', 'Réunion de suivi RH.', 3, '2025-03-11 13:48:34', '2025-03-11 13:48:34'),
                                                                                                                                                                                 (2, NULL, 'Formation', '2025-04-05 14:00:00', '2025-04-05 17:00:00', 'Salle B', 'Formation sur les nouvelles procédures.', 2, '2025-03-11 13:48:34', '2025-03-11 13:48:34');

-- --------------------------------------------------------

--
-- Structure de la table `rapports`
--

CREATE TABLE `rapports` (
                            `id_rapport` int NOT NULL,
                            `titre` varchar(150) NOT NULL,
                            `type_rapport` enum('Financier','RH','Stock') NOT NULL,
                            `contenu` text,
                            `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                            `cree_par` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `rapports`
--

INSERT INTO `rapports` (`id_rapport`, `titre`, `type_rapport`, `contenu`, `date_creation`, `cree_par`) VALUES
                                                                                                           (1, 'Rapport Financier Q1', 'Financier', 'Analyse des revenus et dépenses du premier trimestre.', '2025-03-11 13:48:34', 4),
                                                                                                           (2, 'Rapport RH', 'RH', 'Bilan des embauches et départs.', '2025-03-11 13:48:34', 3);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
                         `id_role` int NOT NULL,
                         `nom_role` enum('superadmin','admin','manager','rh','finance','informatique','livreur') NOT NULL,
                         `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id_role`, `nom_role`, `description`) VALUES
                                                               (1, 'superadmin', 'Accès complet à l\'application'),
                                                               (2, 'admin', 'Accès administrateur'),
                                                               (3, 'manager', 'Gestion des équipes'),
                                                               (4, 'rh', 'Gestion des ressources humaines'),
                                                               (5, 'finance', 'Gestion financière'),
                                                               (6, 'informatique', 'Support informatique'),
                                                               (7, 'livreur', 'Gestion des livraisons');

-- --------------------------------------------------------

--
-- Structure de la table `salaires`
--

CREATE TABLE `salaires` (
                            `id_salaire` int NOT NULL,
                            `id_employe` int NOT NULL,
                            `montant` decimal(10,2) NOT NULL,
                            `date_debut` date NOT NULL,
                            `date_fin` date DEFAULT NULL,
                            `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
                            `date_modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `salaires`
--

INSERT INTO `salaires` (`id_salaire`, `id_employe`, `montant`, `date_debut`, `date_fin`, `date_creation`, `date_modification`) VALUES
                                                                                                                                   (1, 1, 3000.00, '2020-01-15', NULL, '2025-03-11 13:47:08', '2025-03-11 13:47:08'),
                                                                                                                                   (2, 2, 3200.00, '2019-05-10', NULL, '2025-03-11 13:47:08', '2025-03-11 13:47:08'),
                                                                                                                                   (3, 3, 2800.00, '2018-07-20', NULL, '2025-03-11 13:47:08', '2025-03-11 13:47:08'),
                                                                                                                                   (4, 4, 2500.00, '2021-03-05', NULL, '2025-03-11 13:47:08', '2025-03-11 13:47:08');

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

CREATE TABLE `stocks` (
                          `id_produit` int NOT NULL,
                          `nom_produit` varchar(150) NOT NULL,
                          `description` text,
                          `quantite` int NOT NULL,
                          `seuil_alerte` int NOT NULL,
                          `id_fournisseur` int NOT NULL,
                          `prix_achat` decimal(10,2) NOT NULL,
                          `prix_vente` decimal(10,2) NOT NULL,
                          `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          `date_modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `stocks`
--

INSERT INTO `stocks` (`id_produit`, `nom_produit`, `description`, `quantite`, `seuil_alerte`, `id_fournisseur`, `prix_achat`, `prix_vente`, `date_creation`, `date_modification`) VALUES
                                                                                                                                                                                      (1, 'Produit A', 'Produit de qualité A', 100, 20, 1, 10.00, 15.00, '2025-03-11 13:47:20', '2025-03-11 13:47:20'),
                                                                                                                                                                                      (2, 'Produit B', 'Produit de qualité B', 50, 10, 2, 20.00, 30.00, '2025-03-11 13:47:20', '2025-03-11 13:47:20');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
                                `id_utilisateur` int NOT NULL,
                                `id_employe` int DEFAULT NULL,
                                `username` varchar(50) NOT NULL,
                                `mot_de_passe` varchar(255) NOT NULL,
                                `email` varchar(150) NOT NULL,
                                `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                `date_modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `id_employe`, `username`, `mot_de_passe`, `email`, `date_creation`, `date_modification`) VALUES
                                                                                                                                           (1, NULL, 'superadmin', '$2y$10$1DqMbxUc2ZNtepxiJTz46elPHHDjh8Hdv4NQfVyhRMX6zyx9NJ5oG', 'superadmin@erp.com', '2025-03-11 11:46:07', '2025-03-11 11:46:07'),
                                                                                                                                           (2, 4, 'corinthe', '$2y$10$6cEPN9bOdHlpdfogxLb/W.3HnKijuZqYns6GOvw0mzj3euOEmmXhm', 'guerain.corinthe@erp.com', '2025-03-11 12:00:08', '2025-03-11 12:00:08'),
                                                                                                                                           (3, 1, 'aime', '$2y$10$g2mAl5XG3mBdJebFpGHIZe0PiG1rWDG7ecnyYEZfGmWXE.iBPf0p.', 'adjassa.aime@erp.com', '2025-03-11 13:41:06', '2025-03-11 13:41:06'),
                                                                                                                                           (4, 2, 'mathis', '$2y$10$v2L68XL/yL7iqMnGbiq3BeKFsFOwqPO6YkHcy5bs1LDccFjQQ5Pla', 'varrel.mathis@erp.com', '2025-03-11 13:41:32', '2025-03-11 13:41:32'),
                                                                                                                                           (5, 3, 'paul', '$2y$10$xKaOfRLelfhDCmZ0oQaunuVcuJHgDVUCbMubhdAUXc12Ezu.A7DR6', 'leclech.paul@erp.com', '2025-03-11 13:41:45', '2025-03-11 13:41:45');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs_roles`
--

CREATE TABLE `utilisateurs_roles` (
                                      `id_utilisateur` int NOT NULL,
                                      `id_role` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `utilisateurs_roles`
--

INSERT INTO `utilisateurs_roles` (`id_utilisateur`, `id_role`) VALUES
                                                                   (2, 2),
                                                                   (3, 4),
                                                                   (4, 5),
                                                                   (5, 7);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `conges`
--
ALTER TABLE `conges`
    ADD PRIMARY KEY (`id_conge`),
    ADD KEY `fk_conges_employes` (`id_employe`);

--
-- Index pour la table `employes`
--
ALTER TABLE `employes`
    ADD PRIMARY KEY (`id_employe`),
    ADD UNIQUE KEY `email_UNIQUE` (`email`),
    ADD UNIQUE KEY `telephone_UNIQUE` (`telephone`);

--
-- Index pour la table `finances`
--
ALTER TABLE `finances`
    ADD PRIMARY KEY (`id_finance`),
    ADD KEY `fk_finances_fournisseurs` (`id_fournisseur`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
    ADD PRIMARY KEY (`id_fournisseur`);

--
-- Index pour la table `historique_salaires`
--
ALTER TABLE `historique_salaires`
    ADD PRIMARY KEY (`id_historique_salaires`),
    ADD KEY `fk_hist_salaires_salaires` (`id_salaire`);

--
-- Index pour la table `livraisons`
--
ALTER TABLE `livraisons`
    ADD PRIMARY KEY (`id_livraison`),
    ADD KEY `fk_livraisons_fournisseurs` (`id_fournisseur`);

--
-- Index pour la table `mouvements_stock`
--
ALTER TABLE `mouvements_stock`
    ADD PRIMARY KEY (`id_mouvement`),
    ADD KEY `fk_mouvements_stock_produit` (`id_produit`);

--
-- Index pour la table `planning_rh`
--
ALTER TABLE `planning_rh`
    ADD PRIMARY KEY (`id_planning`),
    ADD KEY `fk_planning_rh_employes` (`id_employe`),
    ADD KEY `fk_planning_rh_utilisateurs` (`cree_par`);

--
-- Index pour la table `rapports`
--
ALTER TABLE `rapports`
    ADD PRIMARY KEY (`id_rapport`),
    ADD KEY `fk_rapports_utilisateurs` (`cree_par`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
    ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `salaires`
--
ALTER TABLE `salaires`
    ADD PRIMARY KEY (`id_salaire`),
    ADD KEY `fk_salaires_employes` (`id_employe`);

--
-- Index pour la table `stocks`
--
ALTER TABLE `stocks`
    ADD PRIMARY KEY (`id_produit`),
    ADD KEY `fk_stocks_fournisseurs` (`id_fournisseur`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
    ADD PRIMARY KEY (`id_utilisateur`),
    ADD UNIQUE KEY `email_UNIQUE` (`email`),
    ADD UNIQUE KEY `username_UNIQUE` (`username`),
    ADD KEY `fk_utilisateurs_employes` (`id_employe`);

--
-- Index pour la table `utilisateurs_roles`
--
ALTER TABLE `utilisateurs_roles`
    ADD PRIMARY KEY (`id_utilisateur`,`id_role`),
    ADD KEY `fk_utilisateurs_roles_role` (`id_role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `conges`
--
ALTER TABLE `conges`
    MODIFY `id_conge` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `employes`
--
ALTER TABLE `employes`
    MODIFY `id_employe` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `finances`
--
ALTER TABLE `finances`
    MODIFY `id_finance` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
    MODIFY `id_fournisseur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `historique_salaires`
--
ALTER TABLE `historique_salaires`
    MODIFY `id_historique_salaires` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `livraisons`
--
ALTER TABLE `livraisons`
    MODIFY `id_livraison` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `mouvements_stock`
--
ALTER TABLE `mouvements_stock`
    MODIFY `id_mouvement` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `planning_rh`
--
ALTER TABLE `planning_rh`
    MODIFY `id_planning` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `rapports`
--
ALTER TABLE `rapports`
    MODIFY `id_rapport` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
    MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `salaires`
--
ALTER TABLE `salaires`
    MODIFY `id_salaire` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
    MODIFY `id_produit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
    MODIFY `id_utilisateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `conges`
--
ALTER TABLE `conges`
    ADD CONSTRAINT `fk_conges_employes` FOREIGN KEY (`id_employe`) REFERENCES `employes` (`id_employe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `finances`
--
ALTER TABLE `finances`
    ADD CONSTRAINT `fk_finances_fournisseurs` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseurs` (`id_fournisseur`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `historique_salaires`
--
ALTER TABLE `historique_salaires`
    ADD CONSTRAINT `fk_hist_salaires_salaires` FOREIGN KEY (`id_salaire`) REFERENCES `salaires` (`id_salaire`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `livraisons`
--
ALTER TABLE `livraisons`
    ADD CONSTRAINT `fk_livraisons_fournisseurs` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseurs` (`id_fournisseur`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `mouvements_stock`
--
ALTER TABLE `mouvements_stock`
    ADD CONSTRAINT `fk_mouvements_stock_produit` FOREIGN KEY (`id_produit`) REFERENCES `stocks` (`id_produit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `planning_rh`
--
ALTER TABLE `planning_rh`
    ADD CONSTRAINT `fk_planning_rh_employes` FOREIGN KEY (`id_employe`) REFERENCES `employes` (`id_employe`) ON DELETE SET NULL ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_planning_rh_utilisateurs` FOREIGN KEY (`cree_par`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `rapports`
--
ALTER TABLE `rapports`
    ADD CONSTRAINT `fk_rapports_utilisateurs` FOREIGN KEY (`cree_par`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `salaires`
--
ALTER TABLE `salaires`
    ADD CONSTRAINT `fk_salaires_employes` FOREIGN KEY (`id_employe`) REFERENCES `employes` (`id_employe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `stocks`
--
ALTER TABLE `stocks`
    ADD CONSTRAINT `fk_stocks_fournisseurs` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseurs` (`id_fournisseur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
    ADD CONSTRAINT `fk_utilisateurs_employes` FOREIGN KEY (`id_employe`) REFERENCES `employes` (`id_employe`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateurs_roles`
--
ALTER TABLE `utilisateurs_roles`
    ADD CONSTRAINT `fk_utilisateurs_roles_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_utilisateurs_roles_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
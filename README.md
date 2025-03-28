# ERP System

Un système ERP (Enterprise Resource Planning) conçu pour gérer les employés, les finances, les stocks, les commandes, et bien plus encore.

## Table des matières

- [Fonctionnalités](#fonctionnalités)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Contribuer](#contribuer)
- [Licence](#licence)

---

## Fonctionnalités

- **Gestion des employés** : Ajout, modification, suppression et gestion des départements.
- **Gestion des congés** : Suivi des congés des employés.
- **Gestion des salaires** : Suivi des salaires avec un total.
- **Gestion des finances** : Revenus, dépenses et factures.
- **Gestion des stocks** : Suivi des produits et des fournisseurs.
- **Gestion des commandes** : Création et suivi des commandes.
- **Tableau de bord interactif** : Visualisation des données avec des graphiques (Chart.js).

---

## Prérequis

- PHP >= 8.0
- Composer
- Laravel
- Serveur web (Apache, Nginx, ou autre)
- Base de données MySQL

---

## Installation

1. Clonez le dépôt :

   ```bash
   git clone https://gitlab.com/41M3Dev/erp.git
   cd erp
   ```

2. Installez les dépendances PHP avec Composer :

   ```bash
   composer install
   ```

---

## Configuration

1. Copiez le fichier `.env.example` en `.env` :

   ```bash
   cp .env.example .env
   ```

2. Configurez les variables d'environnement dans le fichier `.env` (base de données, mail, etc.).

3. Bases de données dans la racine 'erp.sql' à importer sur phpmyadmin

4. (Optionnel) Ajoutez des données de test avec les seeders :

   ```bash
   php artisan db:seed
   ```

---

## Utilisation

1. Lancez le serveur de développement Laravel :

   ```bash
   php artisan serve
   ```

2. Accédez à l'application dans votre navigateur à l'adresse suivante :

   ```
   http://localhost:8000
   ```

3. Connectez-vous avec les identifiants administrateur (superadmin / superadmin).

---

## Fonctionnalités principales

### Tableau de bord

- Visualisation des finances (revenus, dépenses, factures) via un graphique circulaire.
- Suivi des stocks avec un graphique en barres.
- Répartition des employés par département.
- Nombre total d'employés actifs.

### Gestion des rôles

- Accès basé sur les rôles : `superadmin`, `admin`, `rh`, `finance`, `livreur`, `manager`, etc.
- Navigation dynamique dans la sidebar en fonction des permissions.

### Graphiques interactifs

- Utilisation de **Chart.js** pour afficher des données financières, des stocks et des employés.

---

## Contribuer

Les contributions sont les bienvenues ! Pour contribuer :

1. Forkez le projet.
2. Créez une branche pour votre fonctionnalité ou correction de bug (`git checkout -b feature/ma-fonctionnalite`).
3. Commitez vos modifications (`git commit -m 'Ajout de ma fonctionnalité'`).
4. Poussez votre branche (`git push origin feature/ma-fonctionnalite`).
5. Ouvrez une Pull Request.

---

## Licence

Ce projet est sous licence [MIT](LICENSE).

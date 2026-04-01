# Revieweo

Revieweo est une plateforme de critiques de films realisee en PHP 8.2, MySQL/MariaDB, Bootstrap 5 et JavaScript.
Le projet utilise un mini MVC maison avec un point d'entree unique, des repositories, des services, des vues Bootstrap et un systeme de roles.

## Fonctionnalites

- Accueil public avec mise en avant de critiques recentes
- Inscription, connexion, deconnexion et gestion de session
- Roles distincts : `user`, `critique`, `admin`
- Liste publique des critiques, page detail et filtre par categorie
- Likes / unlike en AJAX
- Espace critique pour creer, modifier et supprimer ses critiques
- Espace admin pour moderer, epingler et changer les roles

## Stack technique

- PHP 8.2.12
- MySQL / MariaDB
- Bootstrap 5.3
- JavaScript natif avec `fetch()`
- Architecture mini MVC

## Demarrage

### Option recommandee

Faire pointer le serveur web vers le dossier `public/`.

### URL de test locale

- `http://localhost/revieweo-app/public/index.php`

### Si vous utilisez un virtual host

- Document root : `.../travaille_a_rendre-Environnement_de_production_lier_a_git/public`
- Le front controller reste `public/index.php`

## Installation

1. Copier ou cloner le projet dans votre environnement local.
2. Creer la base `revieweo` avec `database/schema.sql`.
3. Importer ensuite `database/seed.sql` pour charger les comptes et les donnees de demo.
4. Verifier les identifiants de connexion dans `config/config.php`.
5. Demarrer Apache et MariaDB.
6. Ouvrir `http://localhost/revieweo-app/public/index.php`.

## Comptes de test

Mot de passe commun pour les comptes de demo : `revieweo123`

- `user@revieweo.test` -> role `user`
- `critique@revieweo.test` -> role `critique`
- `admin@revieweo.test` -> role `admin`

## Parcours de test rapide

- Ouvrir l'accueil
- Creer un compte ou se connecter avec un compte de demo
- Ouvrir la liste des critiques
- Ouvrir une critique detaillee
- Tester le like / unlike
- Tester l'espace critique avec un compte `critique`
- Tester l'espace admin avec un compte `admin`

## Structure du projet

- `public/` : front controller et assets web
- `app/Core/` : router, database, auth, rendu
- `app/Controllers/` : logique de navigation et orchestration
- `app/Repositories/` : acces SQL centralise
- `app/Services/` : regles metier
- `app/Models/` : objets metier simples
- `app/Views/` : affichage Bootstrap
- `database/` : schema et seed
- `config/` : configuration application

## Roles dans le projet

- Ayoub : cadrage, socle technique, securite, documentation, preuves et rendu
- Victor : pages publiques, interface, likes AJAX et administration visuelle
- Ilyass : base de donnees, repositories, services et logique metier

## Notes techniques

- La connexion BDD est centralisee dans `app/Core/Database.php`.
- Le routage passe par `public/index.php` et `app/Core/Router.php`.
- Les mots de passe sont haches avec `password_hash()` et verifies avec `password_verify()`.
- Les pages privees sont protegees par les gardes de `app/Core/Auth.php`.
- Les donnees de demo utilisent `INSERT IGNORE` pour limiter les doublons lors des imports.

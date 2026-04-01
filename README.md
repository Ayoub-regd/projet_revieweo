# Revieweo

Revieweo est une plateforme de critiques de films realisee en PHP 8.2, MySQL/MariaDB, Bootstrap 5 et JavaScript.
Le projet utilise un mini MVC maison avec un point d'entree unique, des repositories, des services, des vues Bootstrap et un systeme de roles.

## Contexte

Le projet Revieweo a ete realise dans le cadre du module web IPSSI afin de creer une plateforme simple de consultation et de publication de critiques de films.
Le sujet a ete volontairement garde lisible pour pouvoir montrer clairement la separation entre l'interface, la logique metier, la base de donnees et les droits d'acces.

## Objectif

- Permettre a un visiteur de consulter des critiques publiques
- Permettre a un utilisateur connecte de s'authentifier et de liker une critique
- Permettre a un compte critique de creer, modifier et supprimer ses propres critiques
- Permettre a un administrateur de moderer les contenus et de gerer les roles

## Problematique traitee

- Organiser le projet avec une architecture mini MVC simple et lisible
- Separer les responsabilites entre vues, controleurs, repositories et services
- Gerer des roles differents sans complexifier inutilement le code
- Proteger les actions sensibles et les zones privees
- Ajouter une interaction utilisateur simple avec les likes en AJAX

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

## Pre-requis

- PHP 8.2.x
- Apache
- MySQL ou MariaDB
- Extension PHP `pdo_mysql` active
- Base `revieweo` creee avant le lancement

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

## Donnees de demo

Le fichier `database/seed.sql` contient des comptes de demonstration et des critiques d'exemple.
Utiliser le mot de passe commun `revieweo123` pour les comptes de test.

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

## Limites connues

- Le README ne remplace pas le rapport ni la soutenance
- Le projet reste volontairement simple pour rester defendable a l'oral
- Les noms de certains fichiers techniques ont ete normalises au fil des commits

## Notes techniques

- La connexion BDD est centralisee dans `app/Core/Database.php`.
- Le routage passe par `public/index.php` et `app/Core/Router.php`.
- Les mots de passe sont haches avec `password_hash()` et verifies avec `password_verify()`.
- Les pages privees sont protegees par les gardes de `app/Core/Auth.php`.
- Les donnees de demo utilisent `INSERT IGNORE` pour limiter les doublons lors des imports.

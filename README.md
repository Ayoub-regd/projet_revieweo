# Revieweo

Revieweo est une plateforme web de critiques de films développée en PHP 8.2, MySQL/MariaDB, Bootstrap 5 et JavaScript.
Le projet repose sur une architecture mini MVC avec un point d’entrée unique, des repositories, des services, des vues Bootstrap et un système de rôles.

## Contexte

Le projet Revieweo a été réalisé dans le cadre du module web IPSSI afin de créer une plateforme simple de consultation et de publication de critiques de films.
Le périmètre a été volontairement maintenu simple afin de montrer clairement la séparation entre l’interface, la logique métier, la base de données et les droits d’accès.
Le projet répond au sujet Revieweo avec trois rôles distincts : utilisateur, critique et administrateur.

## Objectif

- Permettre à un visiteur de consulter des critiques publiques
- Permettre à un utilisateur connecté de s'authentifier et de liker une critique
- Permettre à un compte avec rôle critique de créer, modifier et supprimer ses propres critiques
- Permettre à un administrateur de modérer les contenus et de gérer les rôles

## Problématique traitée

- Organiser le projet avec une architecture mini MVC simple et lisible
- Séparer les responsabilités entre vues, contrôleurs, repositories et services
- Gérer des rôles différents sans complexifier inutilement le code
- Protéger les actions sensibles et les zones privées
- Ajouter une interaction utilisateur simple avec les likes en AJAX

## Fonctionnalités

- Accueil public avec mise en avant de critiques récentes
- Inscription, connexion, déconnexion et gestion de session
- Rôles distincts : `user`, `critique`, `admin`
- Liste publique des critiques, page détail et filtre par catégorie
- Like et retrait du like des critiques en AJAX sans rechargement de page
- Espace critique pour créer, modifier et supprimer ses critiques
- Espace admin pour modérer, épingler et changer les rôles

## Stack technique

- HTML5
- CSS3
- PHP 8.2.12
- MySQL / MariaDB
- Bootstrap 5.3
- JavaScript natif avec `fetch()`
- Git / GitHub
- Architecture mini MVC

## Démarrage

### Option recommandée

Faire pointer le serveur web vers le dossier `public/`.

### Exemple d’URL locale

Si le projet est placé dans `htdocs/revieweo-app` :

- `http://localhost/revieweo-app/public/index.php`

### Si vous utilisez un virtual host

- Document root : dossier `public/` du projet
- Le front controller reste `public/index.php`

## Prérequis

- PHP 8.2.x
- Apache
- MySQL ou MariaDB
- Extension PHP `pdo_mysql` active
- Base `revieweo` créée avant le lancement

## Installation

1. Copier ou cloner le projet dans votre environnement local.
2. Créer la base `revieweo` avec `database/schema.sql`.
3. Importer ensuite `database/seed.sql` pour charger les comptes et les données de démo.
4. Vérifier les identifiants de connexion dans `config/config.php`.
5. Démarrer Apache et MariaDB.
6. Ouvrir `http://localhost/revieweo-app/public/index.php`.

## Comptes de test

Mot de passe commun pour les comptes de démo : `revieweo123`

- `user@revieweo.test` -> rôle `user`
- `critique@revieweo.test` -> rôle `critique`
- `admin@revieweo.test` -> rôle `admin`

## Parcours de test rapide

- Ouvrir l’accueil
- Créer un compte ou se connecter avec un compte de démo
- Ouvrir la liste des critiques
- Ouvrir une critique détaillée
- Tester le like et le retrait du like
- Tester l’espace critique avec un compte `critique`
- Tester l’espace admin avec un compte `admin`

## Données de démo

Le fichier `database/seed.sql` contient des comptes de démonstration et des critiques d’exemple.
Utiliser le mot de passe commun `revieweo123` pour les comptes de test.

## Structure du projet

- `public/` : front controller et assets web
- `app/Core/` : router, database, auth, rendu
- `app/Controllers/` : logique de navigation et orchestration
- `app/Repositories/` : accès SQL centralisé
- `app/Services/` : règles métier
- `app/Models/` : objets métier simples
- `app/Views/` : affichage Bootstrap
- `database/` : schéma et seed
- `config/` : configuration application

## Rôles dans le projet

- Ayoub REGGAD : cadrage, socle technique, sécurité, documentation, preuves et préparation du rendu
- Victor REYDEL : pages publiques, interface, likes AJAX et administration visuelle
- Ilyass RIZEK EL MASRI : base de données, repositories, services et logique métier

## Limites connues

- Le README ne remplace pas le rapport ni la soutenance
- Le projet reste volontairement simple pour rester défendable à l’oral
- Certaines améliorations visuelles ou techniques restent possibles

## Notes techniques

- La connexion BDD est centralisée dans `app/Core/Database.php`.
- Le routage passe par `public/index.php` et `app/Core/Router.php`.
- Les mots de passe sont hachés avec `password_hash()` et vérifiés avec `password_verify()`.
- Les pages privées sont protégées par les gardes de `app/Core/Auth.php`.
- Les données de démo utilisent `INSERT IGNORE` pour limiter les doublons lors des imports.

# Revieweo

Plateforme de critiques de films pour le projet Web IPSSI.

## Architecture

- `public/` : point d'entree web et assets
- `app/Core/` : routeur, base de donnees, auth, rendu des vues
- `app/Controllers/` : orchestration des requetes
- `app/Repositories/` : SQL et acces aux donnees
- `app/Models/` : objets metier simples
- `app/Services/` : logique metier minimale
- `app/Views/` : affichage Bootstrap
- `config/` : configuration et routes
- `database/` : schema et donnees de test

## Demarrage

Le serveur web doit pointer vers `public/`.

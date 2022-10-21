# GobelinsGazette

## Concept
GobelinsGazette est un genre de Reddit adapté à l'école Gobelins.
Les utilisateurs peuvent :
+ Créer des posts et voter pour leurs posts préférés
+ Chercher un post par rapport à son titre et/ou les filtrer par date
+ Supprimer un post qu'ils ont publié

## Utilisation
Après avoir installé toutes les dépendances et Webpack :
+ `npm run watch` pour lancer Webpack
+ `symfony server:start` pour lancer le serveur Symfony
+ `symfony console doctrine:database:create` pour créer la base de données
+ `symfony console doctrine:migrations:migrate` pour créer les tables
+ `symfony console doctrine:fixtures:load` pour charger les fixtures

Une fois que le site et ready :
+ Vous pouvez créer un compte en cliquant sur le bouton "Sign up" ou vous connecter :
    + En tant qu'utilisateur par défaut : 
      + email : `foo@gmail.com`
      + password : `azerty`
    + En tant qu'admin : 
      + email : `test@gmail.com`
      + password : `azerty`

## Workflow
Arborescence des branches :
+ main
+ dev
  + dev-luca
  + dev-thomas

### Thomas
+ Base de données
+ Models
+ Authentification
+ Validation
+ Routes
+ Controllers
+ Recherche
+ Twig

### Luca
+ Front-end
+ Twig
+ Webpack
+ Workflow
+ UML
+ Filtres
+ Recherche

## Base de données
https://www.figma.com/file/3MSW4G1lM3H3NKTgFdU5bN/GobelinsGazette-UML?node-id=0%3A1


# Consignes
L'objectif du projet est de développer une application en binôme à l'aide du framework Symfony, le sujet est libre. Néanmoins, l'application devra implémenter des fonctionnalités permettant d'aborder les concepts et outils principaux du framework.

## Objectifs
    Appréhender les concepts et briques principales de Symfony
    Identifier problématique(s) et proposer une solution
    Imaginer et concevoir une application Symfony
    Travailler en groupe de façon efficace
    Gestion de projet (tâches, planning,..)

## Contraintes
    Utiliser le moteur de template twig
    Exploiter Webpack Encore pour "build" vos assets
    Gestion d'une base de données avec Doctrine
    Implémenter des fixtures
    Implémenter un formulaire imbriqué
    Valider les données envoyées depuis les formulaires
    Prévoir la possibilité de rendre l'outil multilangue
    Créer un espace "admin" avec authentification

## Tâches
    Définir l'application qui sera développée
    Concevoir un modèles de données pour répondre aux besoins spécifiées
    Définir un plannig et repartir les tâches
    Définir un workflow de travail collaboratif via GIT
    Implémenter les fonctionnalités spécifiées
    Mettre en place un fichier README.md permettant d'exploiter le projet


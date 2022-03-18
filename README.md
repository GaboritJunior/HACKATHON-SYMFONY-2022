# Hackathon Symfony

## Contexte

> Cet hackathon a pour but de vous faire progresser sur Symfony et ses technologies annexes.

> Le **thème** de cette année est le jeu !

> Vous développerez un univers basé sur un jeu réel ou inventé. Le but est de faire la partie back pour accueillir les participants.
> Faire partie d'une ou plusieurs équipes, se rencontrer, discuter, échanger...
> Gestion des scores...
> Vous ne développerez pas le jeu en lui-même mais toute la partie annexe de gestion.
> Partez sur un univers qui vous parle et donnez nous envie de vous rejoindre !!!

## Installation

- Placez vous dans le dossier de vos projets docker où se trouve le Makefile ainsi que le fichier docker-compose.yaml (devPhpLp par défaut)

```shell
# on crée un nouveau projet
make newSF hackathon
# on garde la connexion à la base de données
cp projets/hackathon/.env.local .
# on supprime le dossier de base
rm -rf projets/hackathon
# on récupère le projet de départ dans le dossier créé précédemment
git clone https://gitlab.univ-lr.fr/ntrugeon/hackathon-symfony-2022.git projets/hackathon
# on replace la connexion à la base de données
mv .env.local projets/hackathon
```

- Vous trouverez dans le dépôt git un fichier docker-compose permettant d'ajouter des fonctionnalités à votre projet

```shell
# on déplace ce fichier
mv projets/hackathon/docker-compose.override.yaml .
# on relance les services
make down && make up
# on installe les dépendances
make bash
cd hackathon
composer install
# on crée les tables
sf d:m:m
```

> http://hackathon.localhost:8000

- normalement, deux composants additionnels sont créés (je n'ai pas testé sous mac /-( )

## Composants additionnels

### Mailcatcher

> Ce composant permet d'envoyer des mails en local et de les recevoir

> http://localhost:1080

> Le fichier .env est déjà configuré...

### Mercure

> Ce composant permet d'envoyer des messages asynchrones à travers un hub pour gérer par exemple un chat, des alertes, ...

> http://localhost:3000

### Ce qui est déjà en place

- entité utilisateur
- enregistrement avec vérification d'email
- connexion avec cookie pour rester connecté
- rubrique d'aide dans le footer
- bootstrap mais vous pouvez, ~~devez~~ vous en passer

# top14server

J.F. Ramiara - 2018 - Tous droits réservés

Service Web RESTful fournissant la liste des équipes de Rugby du TOP 14

Fait partie d'une application de démonstration pour le cours SLAM4 du BTS SIO.
L'autre partie est un client Android

## Description

Service Web très simple et pas très respectueux des principes RESTful pour des raisons de simplification.
Il ne propose que deux services.
1. Authentification
2. Authentification + liste des clubs du top 14

## Authentification
Elle vise simplement à montrer le principe du token et n'est donc pas sécurisée.
Il faut envoyer une requête HTTP GET avec le user et le password comme ceci :

`http://localhost/projets/top14server/login.php?user=jef&password=jefjef`

Il n'y a que trois user par défaut : jef, bill et bob. Le password = 2x le user.
Pour les modifier, il faut ouvrir `inc/utilisateurs.inc.php`.

Si le user est authentifié, le service répond avec ce type de contenu JSON.

`{"date":"2018-03-11 15:40:36","message":"user authentifi\u00e9","token":"fc559e5b3bfda4965c3895f73d877c","clubs":null}`

Le token fourni devra être renvoyé en GET à chaque nouvelle requête.

Si le user n'est pas authentifié, le service répond avec ce type de contenu JSON.

`{"date":"2018-03-11 15:39:01","message":"user non authentifi\u00e9","token":null,"clubs":null}`

Une fois qu'il est authentifié, le token généré est stocké dans un fichier qui sera lu à chaque nouvelle requête.

`/files/tokens.txt`

Si le fichier est supprimé, il sera automatiquement reconstruit et mis à jour à chaque nouvelle authentification. 

Les tokens ne sont pas attachés à un user, on  ne fait que vérifier si le token fourni appartient à un de ceux qui sont dans le fichier.

## Authentification + liste des clubs du top 14
Permet de s'authentifier et de demander la liste des clubs du top14 en même temps :
`http://localhost/projets/top14server/clubs.php?token=c4c662e16b163a7824ef7522e45cc2`

ou

`http://localhost/projets/top14server/clubs.php?user=jef&password=jefjef`

Si le user est authentifié, le service répond avec ce type de contenu JSON.

`{
  "date": "2018-03-11 15:47:00",
  "message": "14 equipe(s)",
  "token": "c4c662e16b163a7824ef7522e45cc2",
  "clubs": [
    {
      "id": 1,
      "nom": "US Oyonnax",
      "couleurs": "Rouge et Noir",
      "stade": "Stade Charles Mathon",
      "ecusson": "us_oyonnax.png",
      "classement": 14
    },
    {
      "id": 2,
      "nom": "Montpellier H\u00e9rault Rugby",
      "couleurs": "Bleu et blanc",
      "stade": "Altrad Stadium",
      "ecusson": "montpellier_herault_rugby.png",
      "classement": 1
    },...`

Cette structure est décrite dans un exemple dans ce fichier.

`files/test.json`

Ce fichier JSON contient à la fois des tableaux et des objets JSON. Il contient aussi un message, un horodatage et éventuellement le token fourni par le service d'authentification.

Si le user n'est pas authentifié, le service répond avec ce type de contenu JSON.

`{"date":"2018-03-11 15:48:01","message":"user non authentifi\u00e9","token":"bidon","clubs":null}`


## IMPORTANT
-  La chaîne "\u00e9" est normale, cela fait partie de la norme JSON.
- Pour des raisons de simplification et de performance, le service n'accède pas à une base de données mais à des tableaux PHP construits dynamiquement ici : `inc/equipes.inc.php`.

## Aide
- On peut invoquer facilement ce service avec un navigateur, il suffit de copier-coller les URL dans la barre d'adresse.
- On peut examiner les requêtes et les réponses via les outils "développeur" des navigateurs (Outils>développeur Web sous Firefox par exemple)
## Sources
- https://en.wikipedia.org/wiki/Representational_state_transfer
- https://blog.nicolashachet.com/niveaux/confirme/larchitecture-rest-expliquee-en-5-regles/
- https://www.json.org/json-fr.html
## Changelog
- 2018-03-11 : dépôt initial
- 2018-03-11 : évo. pour s'authentifier et récupérer la liste des clubs en même temps

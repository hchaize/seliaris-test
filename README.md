Introduction
----------

**[TEST TECHNIQUE BACKEND ENGINEER SELIARIS]**  
Ce projet consiste en l'implémentation d'une route renvoyans la météo du actuel d'une ville  
On utilise L'API de OpenWeatherMap  
On peut passer le nom de la ville, l'id OpenWeatherMap de la ville ou la longitude et la latitude

Une documentation a été mise en place pour le endpoint api grâce au bundle nelmio_api_doc et est accessible à l'adresse http://localhost:8001/api/doc

Architectures mises en place dans le projet:
- Domain Driven Design, de façon très légère 
- Hexagonal Architecture avec ses principes de ports et d'adaptateurs
- Action Domain Responder, alternative a MVC, dont le principe est le controlleur mono action, le traitement métier dans un fichier séparé et l'utilisation de responders pour renvoyer la réponse
- le pattern CQRS n'a pas été utilisé ici car pas de base de donnée

Utilisation de `php-cs-fixer` et de `phpstan` pour la propreté du code

Test unitaire réalisés avec `phpunit` 

Prérequis
------------

-  [docker](https://www.docker.com/)
-  [Une Clé API OpenWeatherMap](https://openweathermap.org/)

Installation
----------
cloner le projet 
aller sur le repertoire, éxecuter `docker compose up --build`  
le serveur symfony est lancé sur le port `8001`, le reste se fera dans la console du container  
si utilisation de VsCode, réouvrir le projet dans le container via l'extension.  
sinon récupérer le nom du container avec `docker ps`  
accéder au terminal du container `docker exec -it {nom-du-container} bash`  
Éxécuter `composer install`  
Créer un fichier `.env.local` et mettez-y vôtre clé api OpenWeatherMap en respectant le modèle présent dans `.env`

Lancer les tests et la validation du code
-----------------------------

```
# Lancer les tests unitaires
composer test
# Les lancer avec la couverture de test
composer test:coverage
# Vérifier le formattage du code
composer cs:lint
# Réparer automatiquement le formattage du code
composer cs:fix
# Valider le code
composer phpstan
# Lancer l'ensemble, comme la CI gitlab (test + lint + phpstan)
composer dev:checks 
```

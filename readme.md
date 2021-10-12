# TeamBuilder
## Variable local
Les différentes variables locales se trouve dans le fichier .env.php qui doit se trouver à la racine du projet
### Autoconnexion
L'auto-connexion se défini avec une constante "USER_ID" suivit de l'ID de l'utilisateur souhaité.
L'ID de l'utilisateur se trouve en base de donnée
``
define("USER_ID", 1);
``
### Configuration Base de donnée
- ```define("DBHOST", "TO_CHANGE");```
- ```define("DBNAME", "TO_CHANGE");```
- ```define("DBUSERNAME", "TO_CHANGE");```
- ```define("DBPASSWORD", "TO_CHANGE");```
Description :

Projet du site du restaurant "Le quai antique".
* Gestion de profils d'utilisateurs
* Gestion des données du restaurant (heures d'ouverture/fermeture, plats, menus,...)
* Gestion des réservations et surveillance de la capacités

Installation:
* git clone
* composer install

(démarrage serveur database)
(php bin/console doctrine:database:create)

création Profil Admin du site :
* php bin/console CreateAdminCmd

Pour ajout données fictives initiales :
* php bin/console doctrine:fixtures:load

Utilisation:
possible pour 3 rôles : anonyme, ROLE_USER, ROLE_ADMIN

INSTALLATION DE COMPOSER

	1. Installation de PHP 7.2.7
		- Lancer UwAMP
		- Cliquer sur l'icone "puzzle" à côté de la version de PHP
		- Séléctionner le débot "UwAmp PHP dépot"
		- Séléctionner la version "php-7.2.7" et l'installer

	2. Installation de Composer
		- Lancer le .exe fourni dans ce dossier
		- Ne pas sélectionner le "Developer Mode"
		- Lors de la séléction du chemin de PHP, séléctionner celui-ci: "{CHEMIN-UWAMP}\bin\php\php-7.2.7\php.exe"
		- Ne pas choisir de proxy
		- Installer

	3. Vérifier que PHP et Composer sont installé 
		- Ouvrir un cmd
		- Entrer "php -v" et "composer --version"
		- Si les deux commandes répondent alors c'est installé

	4. Lancer un serveur
		- Avec le cmd, aller dans le dossier "Website"
		- Entrer la commande "php bin/console server:run"
		- Si le serveur s'est correctement lancé, il est accessible en rentrant "localhost:8000" dans l'URL d'un navigateur
INSTALLATION DE COMPOSER

	1. Installation de PHP 7.2.7
		- Lancer UwAMP
		- Cliquer sur l'icone "puzzle" � c�t� de la version de PHP
		- S�l�ctionner le d�bot "UwAmp PHP d�pot"
		- S�l�ctionner la version "php-7.2.7" et l'installer

	2. Installation de Composer
		- Lancer le .exe fourni dans ce dossier
		- Ne pas s�lectionner le "Developer Mode"
		- Lors de la s�l�ction du chemin de PHP, s�l�ctionner celui-ci: "{CHEMIN-UWAMP}\bin\php\php-7.2.7\php.exe"
		- Ne pas choisir de proxy
		- Installer

	3. V�rifier que PHP et Composer sont install� 
		- Ouvrir un cmd
		- Entrer "php -v" et "composer --version"
		- Si les deux commandes r�pondent alors c'est install�

	4. Lancer un serveur
		- Avec le cmd, aller dans le dossier "Website"
		- Entrer la commande "php bin/console server:run"
		- Si le serveur s'est correctement lanc�, il est accessible en rentrant "localhost:8000" dans l'URL d'un navigateur
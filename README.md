# PFEProject
Projet pour la journée formation continue : gestion des inscriptions

====== TUTORIAL for Symfony installation, composer and everything else needed for the project :
1.*	https://github.com/Chyzhykal/PFEProject  clone repository
2.*	If you don’t know how – download Git Kraken :
	a.	https://www.gitkraken.com/ 
	b.	Sign in with your account
	c.	Clone repository
		
* NOTE : You probably already have done that if you can read this text :D

3.	In resources/install open composer installation and install it
	a.	When php version is asked – give it php with 7.2.7 .exe file
4.	Open cmd and check php version :
	a.	php –v
	b.	Test composer with php composer.phar –version  
	c.	To auto update composer add php composer.phar self-update
5.	All that plus next steps you can find on this websites** :
	a.	https://openclassrooms.com/fr/courses/3619856-developpez-votre-site-web-avec-le-framework-symfony/5066156-installer-symfony-grace-a-composer
	b.	Symfony tutorial https://symfony.com/doc/current/page_creation.html

** Note : Website is in MVC version, means that it’s not just symfony/skeleton, but symfony/website-skeleton.

6.	To run Server on VS Code – open project folder, open VS terminal and type line :
	a.	Php bin/console server:run *:80
	i.	*:80  means that server will run on localhost with port 80, you can change that if you need



====== FILE structure in the project :

/bin/ - console and phpunit location, server load.
/config/ - configuration files.
/public/ -  index.php location. It was decided to put CSS and JS files here, so that templates could use assets for linking.
/src/ - php code folder, there are Controllers, Repos, Entities and Migrations
/templates/ - .twig files, same as .html but better


====== DATABASE using doctrine tutorial (METHOD A): 

1.	First of all developer (Chyzhyk Aleh, chyzhykal@gmail.com for questions)  configured the Database 
with .env file in the website directory. Changes are the next :
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
Where you simply put database username, password, ip address and database name.
You can also play with config/packages/doctrine.yaml file to configure db access. 
2.	After that i’ve used the following command :
php bin/console doctrine:mapping:import "App\Entity" annotation --path=src/Entity
This command imports an existing database to entities inside the project directory.
IMPORTANT : If there’s an exception which says that MySQL driver was not found then check 
if the module pdo_mysql in php.ini of your server is enabled (« ; » before the line means it’s not). 
Also check if you are using the correct server. In my case there were both problems. 

3.	Next command gives possibility to generate getter/setter methods. Also, you can change ORM 
in the file header to create the repository. Instead of @ORM :Entity 
put something like :
@ORM\Entity(repositoryClass="App\Repository\(repoName)")
In every Entity Header. Then use the command 
	php bin/console make:entity --regenerate App
This will generate repos and getters/setters.
If not all the repos were generated, then you must have an error somewhere in your code

NOTE : if your project has bad ( not functional ) code, then nothing will work. Composer will check everything before doing commands,
so be sure to not have any errors in your code. 

====== DATABASE using doctrine tutorial (METHOD B): 
1) Configurer doctrine dans le fichier .env, pour cela il faut modifier le champ "DATABASE_URL"
par "mysql://[username]:[password]@[server_ip]:[mysql_port]/[db_name]" 
(En remplaçant les informations entre crochets par ce que vous avez vous)
    - Chez moi ça donne: mysql://root:root@127.0.0.1:3306/db_webdyn3

2) Créer la base de données (et vérifier en même temps si tout fonctionne bien): php bin/console doctrine:database:create

3) Récupérer les tables actuels de la base de donnée:
    - Tester ce qu'on va récupérer php bin/console doctrine:schema:update --dump-sql 
(Cette commande va afficher les requêtes que doctrine va effectuer)
    - Récupérer réellement les tables: php bin/console doctrine:schema:update --force 
(Cette commande va créer les tables dans la base de donnée)



====== PDO MySql driver not found error fix : 
-> Reinstaller completement uWamp dans un nouveau dossier, donc il faut une installation propre 
(Je sais pas si c'est obligatoire, mais comme зa nos fichiers de config sont tout neuf)
-> Avec uWamp, installer la version 7.2.7 de php (etapes se trouvent dans le readme de l'install)
-> Reinstaller composer en lanзant le .exe dans le dossier install
-> Selectionner la version de PHP 7.2.7 se trouvant dans la nouvelle installation uWamp
-> Verifier que composer ait coche "Create php.ini file"
-> Terminer l'installation et ouvrir ce fichier php.ini
-> rechercher "extension:pdo_mysql" et le decommenter
-> relancer uWamp (le server Apache + SQL avec)
-> Verifier que tout s'est bien passe en faisant "php --ini" dans un cmd et regarder
que "Loaded Configuration File" ne soit pas а "(none)"
-> Verifier aussi que "php -m" affiche "pdo_mysql" dans la liste
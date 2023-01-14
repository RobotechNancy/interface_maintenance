**`ROBOTECH 2022-2023`**

<img src="https://www.coupederobotique.fr/wp-content/uploads/logo.png" width="100"/>

### **`INTERFACE DE MAINTENANCE, DE DIAGNOSTIC ET DE CONTRÔLE À DISTANCE DES ROBOTS`**  ###

Dépot officiel de l'équipe Robotech Nancy pour le projet Coupe de France de Robotique.

Le présent dépôt contient le code de l'interface de gestion, d'aide au diagnostic et à la maintenance prédictive à distance des robots collaboratifs de l'équipe Robotech Nancy.

> *Vestion actuelle de l'interface :* **v1.0.0 RELEASE (build 14/01/2023)**

### **`FONCTIONNALITES IMPLEMENTEES`**  ###

L'interface intègre les fonctionnalités suivantes : 

-	La gestion des comptes utilisateurs (création, suppression, accès, modification)
-	La mise en place de rôles offrant l’accès à différentes fonctionnalités de l’application
-	La gestion des erreurs web courantes pour une navigation complète
-	L’exécution d’autotests d’inter-opérabilité à destination de la carte d’odométrie et de la base roulante
-	La vérification de l’état de différents services web proposés par l’application 
-	La gestion de la base roulante avec des commandes personnalisées (en termes de vitesse et de distance) depuis les flèches directionnelles ou le clavier utilisateur
-	Un système de logs complets, détaillé et accessible permettant un débogage rapide et précis des éventuels dysfonctionnement (création, suppression, exportation, accès)
-	La mise en place de concepts de sécurité essentiels pour garantir l’intégrité de l’application (principe du moindre privilège, protection contre les failles usuelles lors de la communication avec la base de données, hachage des mots de passe stockés, connexion unique par compte, chiffrement SSL/TLS par clé RSA 2048 bits pour garantir l’intégrité des données en transit)

### **`UTILISATION DU CODE`**  ###

Clonage du dépôt :

```bash
git clone https://github.com/RobotechNancy/interface_maintenance.git
```

Accès au dossier :

```bash
cd interface_maintenance/
```

Installation des dépendances :

```bash
composer install 
```

Création des tables de la base de données :

```bash
php artisan migrate
```

> *Remarque :* Pensez à modifier les paramètres de connexion à la base de données en fonction de votre installation dans le fichier **.env** à la racine du dépôt

Démarrage du serveur :

```bash
php artisan serve
```

#### Vous devez avoir certains éléments installés et fonctionnels sur votre système :

- Laravel (version `^9.19`)
> Tutoriel d'installation multi-plateformes : https://laravel.com/docs/9.x/installation

- PHP (version `^8.0.2`)
> Fichiers de téléchargement : https://www.php.net/downloads

- Composer (version `^2.5.1`)
> Tutoriel d'installation multi-plateformes : https://getcomposer.org/download/

- Apache (version `>=2.4.54`) ou autre serveur web local

- MySQL (version `>=5.7.33`)

> Vous pouvez combiner l'installation d'Apache et de MySQL en utilisant une pile logicielle dédiée : LAMP (ubuntu) https://doc.ubuntu-fr.org/lamp - Laragon (windows) https://laragon.org/docs/install.html

### **`TECHNOLOGIES UTILISEES`**  ###

[PHP](https://www.php.net/) : `8.1.1`

[Composer](https://getcomposer.org/) : `2.5.1`

[Laravel](https://laravel.com/) : `9.19`

[JQuery](https://jquery.org/) : `3.6.1`

[Bootstrap](https://getbootstrap.com/) : `5.2.2`

[MySQL](https://www.mysql.com/fr/) : `5.7.33`

[FontAwesome](https://fontawesome.com) : `6.2.0`

[Apache](https://fontawesome.com) : `2.4.54`

### **`ARBORESCENCE DE NAVIGATION`**  ###

<img src="https://github.com/RobotechNancy/interface_maintenance/blob/main/images/architecture_fonctionnelle.png" width="500"/>

### **`ARCHITECTURE GLOBALE DE L'APPLICATION`**  ###

<img src="https://github.com/RobotechNancy/interface_maintenance/blob/main/images/architecture_globale.png"/>

### **`DOCUMENTATION`**  ###

Toute la documentation des fonctions a été spécifiée directement dans les fichiers concernés sous la norme Doxygen (fonctions Javascript) et sous la norme PHPDocumentator (fonctions PHP).
Le rapport explicatif du projet est disponible à la racine du dépôt, sous le nom de fichier [rapport_projet_interface_robotech_nancy_DITTEDESTREE_SANHAJI_MOUCHETTE.pdf](https://github.com/RobotechNancy/interface_maintenance/blob/main/rapport_projet_interface_robotech_nancy_DITTEDESTREE_SANHAJI_MOUCHETTE.pdf)


***
En cas de besoin, vous pouvez contacter les créateurs du projet sur Discord `@heatsink.ru#1183` ou par mail samueldittedestree@protonmail.com


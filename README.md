# TodoList [![Symfony insight Badge](https://insight.symfony.com/projects/6b1873c7-6f00-4dff-a2d9-dba82b504a04/analyses/13)]

## Description

This project is the 8th project of the [Developer PHP / Symfony](https://openclassrooms.com/fr/paths/59-developpeur-dapplication-php-symfony) formation of [Openclassrooms](https://openclassrooms.com/).

The first objective of this project was to **migrate a Symfony 3.1 project directly to a newer version**, here my choice fell on **the latest Symfony LTS, 6.1**.
The second objective after the corrections that we needed the migration was to implement an architecture respecting the SOLID principles through a refactoring
The third goal was to implement **unit and functional testing via [PHPUnit](https://phpunit.readthedocs.io/en/9.5/)** and fix/add some features.
Throughout the project, it was necessary to carry out a **project quality and performance audit, via [Blackfire](https://blackfire.io/) , [Symfony Insight](https://insight.symfony.com /)** mainly and with phpstan locally.

## Build with

### Server :

- [PHP v8.1.7](https://www.php.net/releases/index.php)
- [Apache v2.4.48](https://www.apachelounge.com/download/VC15/)
- [MySQL v8.0.24](https://downloads.mysql.com/archives/installer/)
- **Server** : *for the server you can turn to the classics: [WAMP](https://www.wampserver.com/), [MAMP](https://www.mamp.info/en/downloads/), [XAMPP](https://www.apachefriends.org/fr/index.html) ...Or test the best of the swiss knives server: [Laragon](https://laragon.org/), my favorite ❤️*

### Framework & Libraries :

- [Symfony 6.1.0](https://symfony.com/releases/6.1)
- [Composer](https://getcomposer.org/download/)
- [Bootstrap v5.1.3](https://getbootstrap.com/)

## Installation

### **Clone or download the repository**, and put files into your environment,

```
https://github.com/Roukoumanou/ToDo
```

### Install libraries with **composer**,

```
Go to the root of the project and type the command "composer install"
```

### Configure your environment with `.env` file :

```
# DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8"

```

### Initialise your Database :
#### *OPTION 1 - Use the shortcut of my Makefile* 
```
make db
```
#### *OPTION 2 - Use the next commands with the PHP console*
1 - create your database :

````
php bin/console d:d:c
````

2 - create the structure in your database :

```
php bin/console d:m:m
```

3 - and install fixturesfor have first contents and your Admin account :

```
php bin/console d:f:l -n
```

###> Fixture users to connect ###
```
ROLE_ADMIN
email='admin@gmail.com'
password='password'

ROLE_USER
email='anonyme@gmail.com'
password='password'
```
### Activate APCu cache on your Database :
1 - Download the latest version of the APCu file [👉HERE](https://pecl.php.net/package/APCU),

2 - Unzip the file,

3 - Copy/paste the `php_apcu.dll` file in your `php_last_version/ext` folder,

4 - Activate in the control panel of your server the APCu extension for PHP,

5 - Check the activation via the command `php -m`, where you should see the extension in the listed modules.
### Linux 20.04 option Enable APCu cache on your Database:
Visit [HERE](https://installati.one/ubuntu/20.04/php-apcu/)

### Voilà !

## Launched the tests :
- *OPTION 1 - Use the shortcut of my Makefile* ❤️
```
make t
```
- *OPTION 2 - Use the command with the PHP console*
```
php bin/phpunit
```

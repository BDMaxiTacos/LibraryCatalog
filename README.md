# Présentation

## Paramètres du projet

- Symfony 6.3.5
- PHP 8.1.2
- MySQL 8.0.34-0 (Linux)

## Installation

- Cloner le projet
 ```
 git clone https://github.com/BDMaxiTacos/LibraryCatalog.git
 ```
### Local

- Installer les dépendences
 ```
 composer install
 ```
### Serveur

- Installer les dépendences
 ```
 composer install --no-dev --optimize-autoloader
 ```
### Base de données

- Créer la base de données
```
php bin/console doctrine:database:create
```

- 3 façons de faire la base de données

    - Avec les migrations :
        ```
        php bin/console doctrine:migrations:migrate --all-or-nothing ALL
        ```
    - Avec schema update -- force :
        ```
        php bin/console doctrine:schema:update --force
        ```

    Pour les migrations et le schema update, il faut lancer les fixtures :
    ```
    php bin/console doctrine:fixtures:load
    ```

    - Avec le fichier .sql du projet :
    ```
    mysqldump -u <user> -p <dbname> < dumpsql22-10-2023.sql
    ```

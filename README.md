# Présentation

Cette installation a été effectuée sur une machine Ubuntu (Linux) en local

## Paramètres du projet

- Symfony 6.3.5
- PHP 8.1.2
- MySQL 8.0.34-0 (Linux)

## Installation

- Cloner le projet (être dans un dossier vide)
 ```
 git clone https://github.com/BDMaxiTacos/LibraryCatalog.git ./
 ```

- Copier le .env.bak en .env et en .env.local
 ```
 cp .env.bak .env
 cp .env.bak .env.local
 ```

### (Local)

- Modifier le fichier .env.local:
```
nano .env.local
```

- Mettre la variable "APP_ENV" en "dev":
```
APP_ENV=dev
```

- Remplir les champs "user" et "pass" de la variable "DATABASE_URL" et décommentez la ligne:
```
DATABASE_URL="mysql://<user>:<pass>@127.0.0.1:3306/library?serverVersion=8.0.32&charset=utf8mb4"
```

- Installer les dépendences
 ```
 composer install
 ```

### Base de données

- Créer la base de données
```
php bin/console doctrine:database:create
```

- 2 façons de faire la base de données

    - Avec les migrations :
        ```
        php bin/console doctrine:migrations:migrate --all-or-nothing ALL
        ```
    - Avec schema update -- force :
        ```
        php bin/console doctrine:schema:update --force
        ```

- Ensuite vous pouvez :
    - Soit lancer les fixtures (pas d'images mises sur les livres) :
    ```
    php bin/console doctrine:fixtures:load
    ```
    
    - Soit importer le fichier .sql du projet (images mises sur les livres) :
    ```
    mysql -u <user> -p <dbname> < dumpsql22-10-2023.sql
    ```

### Mailer

- Remplir les champs commençant avec "MAIL_":
```
MAIL_HOST=""
MAIL_PORT=
MAIL_FROM=""
MAIL_TO=""
```

### (Local)

```
symfony serve
```
ou
```
symfony server:start
```
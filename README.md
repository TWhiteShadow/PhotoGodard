# PhotoGodard

PhotoGodard

## Installation sans Docker

Initialisation du projet

```bash
  composer install
```

Lancement de la compilation de sass

```bash
  npm init
  
  npm install @symfony/stimulus-bridge
  
  npm run watch
```

Lancement de la compilation de sass sur terminal SSH

```bash
  npm run build
```

Initialisation de la base de données (tkt)

```bash
  symfony console doctrine:database:create
  
  symfony console doctrine:schema:update
  
  symfony console doctrine:fixtures:load
```



## Installation avec Docker

Initialisation du projet

```bash
  docker compose up
```

Accès au bash du conteneur php de docker

```bash
  docker compose exec php bash
```
```bash
  composer install
  
  bin/console doctrine:database:create

  bin/console doctrine:schema:update --force

  bin/console doctrine:fixtures:load -n

  bin/console liip:imagine:cache:resolve assets/images/image1.jpg 

```

Accès phpmyadmin

```bash
  127.0.0.1:8080
```
- ServerName :   #correspond au nom du container + port (mariadb:3306)


Lancement de la compilation de sass sur terminal SSH
```bash
  npm run build
```


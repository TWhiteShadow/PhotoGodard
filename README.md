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

Accès au bash du conteneur symfony de docker

```bash
  docker compose exec symfony bash
```
```bash
  composer install
  
  php bin/console doctrine:database:create

  php bin/console doctrine:schema:update --force

  php bin/console doctrine:fixtures:load -n
```

Lancement de la compilation de sass sur terminal SSH
```bash
  npm run build
```


<summary><h1>symfony-fast-install</h1></summary>

<details>
<summary><h1>🚀 1. Installation Docker Symfony (Dunglas)</h1></summary>
<details>

<summary><h2>1.1 - Clonage du repository</summary>

Naviguer dans votre dossier de travail souhaité
```bash
cd /chemin/vers/votre/dossier
```
Cloner le template Symfony Docker de Dunglas directement dans le dossier courant
```bash
git clone https://github.com/dunglas/symfony-docker.git .
```
</details>
<details>
<summary><h2>1.2 - Construction et démarrage initial<h2></summary>


Construire les images Docker (premier build)
```bash
docker compose build --pull --no-cache
``` 
Alternative pour builds suivants (plus rapide)
```bash
docker compose build
```

Démarrer les conteneurs
```bash
docker compose up -d
```
Vérifier l'état des conteneurs
```bash
docker compose ps
```
</details>
<details>
    <summary><h2>1.3 - Accès à l'application (PostgreSQL + Doctrine)</h2></summary>

- URL : `https://localhost`
- ⚠️ Accepter le certificat SSL auto-signé dans le navigateur
</details>
<details>
<summary><h2>1.4 - Installation de la base de données</summary>
<h3>Extension VS Code Docker</h3>

- Installer l'extension "Docker" par Microsoft
- Dans la sidebar Docker (icône baleine) :
   - Clic droit sur `symfony-docker-php-1`
   - Sélectionner "Attach Shell"
- Un terminal s'ouvre directement dans VS Code
- Exécuter : 
```bash
composer require symfony/orm-pack
``` 
</details>
</details>
<details>
    <summary><h2>✅Modification utile Dockerfile✅ (gaing de temps + optimisation)</h2></summary>
<details>
    <summary><h2>Alias sf = php bin/console</h2></summary>

```bash
# 🔧 Ajouter l'alias sf de façon permanente
RUN echo 'alias sf="php bin/console"' >> /root/.bashrc && \
    echo 'alias sf="php bin/console"' >> /etc/bash.bashrc
``` 
</details>

<details>
    <summary><h2>Node.js + npm install in php containeur</h2></summary>

```bash
RUN apt-get update && apt-get install -y --no-install-recommends \
    acl \
    file \          # <-- ajouter cette ligne
    gettext \
    git \           # <-- ajouter cette ligne
    curl \
    && rm -rf /var/lib/apt/lists/*
# Installer Node.js et npm
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g @dbml/cli
``` 

Résultat final du dockerfile 
```bash
# Base FrankenPHP image
FROM frankenphp_upstream AS frankenphp_base

WORKDIR /app

VOLUME /app/var/

# persistent / runtime deps
# hadolint ignore=DL3008
RUN apt-get update && apt-get install -y --no-install-recommends \
    acl \
    file \
    gettext \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# 🔧 Ajouter l'alias sf de façon permanente
RUN echo 'alias sf="php bin/console"' >> /root/.bashrc && \
    echo 'alias sf="php bin/console"' >> /etc/bash.bashrc

# Installer Node.js et npm
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g @dbml/cli

RUN set -eux; \
	install-php-extensions \
		@composer \
		apcu \
		intl \
		opcache \
		zip \
	;

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
``` 
- Permet l'obtention d'une base de données complète récente grâce à la commande :
```bash
db2dbml postgres 'postgresql://user:password@localhost:5432/dbname?schemas=schema1,schema2,schema3' -o database.dbml
``` 
```bash
db2dbml postgres 'postgresql://user_symfony:secret@database:5432/app' -o database1.dbml
``` 
</details>
<details>
    <summary><h2>Ajout d'Adminer - Interface graphique pour PostgreSQL</h2></summary>

- Qu'est-ce qu'Adminer ?
Adminer est une interface web légère pour gérer vos bases de données directement depuis votre navigateur, similaire à phpMyAdmin mais pour plusieurs types de bases.

- Ajout du service Adminer au compose.yaml

```yaml
services:
  adminer:
    image: adminer
    restart: always
    ports:
      - 8080:8080
``` 

- Accès à Adminer
    - URL : 
    ```bash
    http://localhost:8080
    ``` 
    - Interface : Web accessible depuis votre navigateur

- Connexion à PostgreSQL via Adminer
Dans l'interface Adminer, utiliser ces paramètres :
    - **Système** : PostgreSQL
    - **Serveur** : database
    - **Utilisateur** : user_symfony
    - **Mot de passe** : secret
    - **Base de données** : app

-  Fonctionnalités disponibles
    - 📊 **Visualisation des tables** - Structure et données
    - ✏️ **Édition directe** - Modifier les enregistrements
    - 🔍 **Exécution de requêtes SQL** - Interface de requêtage
    - 📈 **Schéma de base** - Vue d'ensemble des relations
    - 📤 **Import/Export** - Sauvegarde et restauration
</details>
</details>
<details>
    <summary><h2> ‼️⚠️‼️REBUILD après modification des fichiers Docker‼️⚠️‼️</h2></summary>

```bash
docker compose down
```
```bash
docker compose build
```
```bash
docker compose up -d
```

</details>

<details>
<summary><h1> 🔍 2. Vérification de la connexion PHP ↔ Database</h1></summary>
<details>
    <summary><h2>2.1 - Vérifier l'état des conteneurs</h2></summary>

- Voir les conteneurs actifs
```bash
docker compose ps
```
- Voir les logs en cas de problème
```bash
docker compose logs database
```
```bash
docker compose logs php
```
</details>
<details>
    <summary><h2>2.2 - Test de connexion via Doctrine</h2></summary>
    Entrer dans le conteneur PHP

   - Clic droit sur `symfony-docker-php-1`
   - Sélectionner "Attach Shell"

```bash
sf doctrine:query:sql "SELECT version();"
```
Résultat attendu :  
```bash
  version                                                                                   
 ------------------------------------------------------------------------------------------ 
  PostgreSQL 16.10 on x86_64-pc-linux-musl, compiled by gcc (Alpine 14.2.0) 14.2.0, 64-bit 
```
</details>
<details>
    <summary><h2>2.3 - Création de la base de données</h2></summary>
Dans le conteneur PHP

```bash
sf doctrine:database:create
```
Si erreur "database already exists" = Connexion OK !

</details>
<details>
    <summary><h2> 2.4 - Test direct PostgreSQL</h2></summary>
Entrer dans le conteneur PostgreSQL

   - Clic droit sur `symfony-docker-database-1`
   - Sélectionner "Attach Shell"
```bash
psql -U app -d app
```
Vérifier les utilisateurs
```bash
\du
```
Sortir
```bash
\q
```

</details>
</details>
<details>
    <summary><h1> 🆔 3. Création d'un utilisateur avec privilèges limités</h1></summary>
<details>
    <summary><h2> 3.1 - Création du script d'initialisation</h2></summary>

Créer le dossier 📂 pour les scripts
```bash
mkdir -p docker/postgres/init
```
Créer un fichier 📇 "01-create-symfony-user.sql"

```bash
-- Script de sécurisation PostgreSQL pour Symfony
-- Objectif: Créer un utilisateur avec permissions limitées pour l'application

-- 1. Créer un utilisateur Symfony avec permissions limitées
CREATE USER user_symfony WITH PASSWORD 'secret';

-- 2. Accorder seulement les permissions nécessaires sur la base de données
GRANT CONNECT ON DATABASE app TO user_symfony;

-- 3. Accorder les permissions sur le schéma public
GRANT USAGE ON SCHEMA public TO user_symfony;
GRANT CREATE ON SCHEMA public TO user_symfony;  -- AJOUTÉ: nécessaire pour les migrations

-- 4. Accorder les permissions CRUD sur toutes les tables existantes
GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO user_symfony;

-- 5. Accorder les permissions sur les futures tables (pour les migrations)
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT SELECT, INSERT, UPDATE, DELETE ON TABLES TO user_symfony;

-- 6. AJOUTÉ: Permissions pour créer/modifier les tables (migrations Doctrine)
GRANT CREATE ON DATABASE app TO user_symfony;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL PRIVILEGES ON TABLES TO user_symfony;

-- 7. Accorder les permissions sur les séquences (pour les auto-increment)
GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public TO user_symfony;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT USAGE, SELECT ON SEQUENCES TO user_symfony;

-- 8. AJOUTÉ: Permissions sur les séquences pour les migrations
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL PRIVILEGES ON SEQUENCES TO user_symfony;

-- 9. IMPORTANT: user_symfony peut maintenant:
-- - CREATE TABLE (nécessaire pour les migrations)
-- - ALTER TABLE (nécessaire pour les migrations)
-- - DROP TABLE (nécessaire pour rollback migrations)
-- Mais ne peut toujours PAS:
-- - DROP DATABASE
-- - Créer d'autres utilisateurs

\echo 'Utilisateur user_symfony créé avec permissions pour Doctrine migrations'
\echo 'SÉCURITÉ: Cet utilisateur peut gérer les tables mais pas la base de données'
```
</details>
<details>
    <summary><h2>3.2 - Modification du compose.yaml</h2></summary>

Ajouter cette ligne dans la section `volumes` du service `database` :
```yaml
volumes:
  - database_data:/var/lib/postgresql/data:rw
  - ./docker/postgres/init:/docker-entrypoint-initdb.d:ro  # <- Ajouter cette ligne
```
</details>
<details>
    <summary><h2>3.3 - Modification de la configuration d'utilisateur</h2></summary>
<details>
    <summary><h2>3.3.1 - Modification du .yaml</h2></summary>

Ajouter la section `env_file:` dans le service `php` :
```bash
    restart: unless-stopped
    env_file: # <- Ajouter cette ligne
      - .env # <- Ajouter cette ligne
      - .env.local # <- Ajouter cette ligne
    environment:
```
supprimer cette ligne dans la section `volumes` du service `php` :
```yaml
DATABASE_URL: postgresql://${POSTGRES_USER:-app}:${POSTGRES_PASSWORD:-!ChangeMe!}@database:5432/${POSTGRES_DB:-app}
```
Ajouter et modifier dans le service `database` :
```bash
    env_file: # <- Ajouter cette ligne
      - .env # <- Ajouter cette ligne
      - .env.local # <- Ajouter cette ligne
    environment:
      POSTGRES_DB: ${POSTGRES_DB} # <- modifier cette ligne
      POSTGRES_PASSWORD: ${POSTGRES_PASSWORD} # <- modifier cette ligne
      POSTGRES_USER: ${POSTGRES_USER} # <- modifier cette ligne
    healthcheck:
      test: ["CMD", "pg_isready", "-d", "${POSTGRES_DB}", "-U", "${POSTGRES_USER}"] # <- modifier cette ligne
      timeout: 5s
```
</details>
<details>
    <summary><h2>3.3.2 - Configuration du fichiers d'environnement non versionné</h2></summary>

Créer le fichier ".env.local", avec les vrais mots de passe
```bash
###> symfony/framework-bundle ###
APP_SECRET=cfd43436eff37492047bc654e4a13d0c
###< symfony/framework-bundle ###

###> Database Configuration ###
DATABASE_URL="postgresql://user_symfony:secret@database:5432/app?serverVersion=16&charset=utf8"
POSTGRES_USER=postgres
POSTGRES_PASSWORD=postgres_admin_secret_123
POSTGRES_DB=app
###< Database Configuration ###
```
</details>
<details>
    <summary><h2>3.3.3 - Configuration des fichiers d'environnement</h2></summary>

Modifier le fichier ".env" 
```bash
# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
DATABASE_URL="postgresql://user_symfony:CHANGE_ME@database:5432/app?serverVersion=16&charset=utf8" # <- modifier cette ligne
###< doctrine/doctrine-bundle ###

###> Docker PostgreSQL Configuration ### # <- ajouter cette ligne
POSTGRES_USER=postgres                   # <- ajouter cette ligne
POSTGRES_PASSWORD=CHANGE_ME              # <- ajouter cette ligne
POSTGRES_DB=app                          # <- ajouter cette ligne
###< Docker PostgreSQL Configuration ### # <- ajouter cette ligne
```

</details>
<details>
    <summary><h2>3.3.4 - ‼️⚠️‼️Application des modifications‼️⚠️‼️</h2></summary>

Arrêter et supprimer les volumes (pour réinitialiser PostgreSQL)
```bash
docker compose down -v
```
Rebuild avec la nouvelle configuration
```bash
docker compose build
```
Relancer la nouvelle configuration
```bash
docker compose up -d
```
</details>
</details>
</details>

<details>
    <summary><h1>⚙️ 4. Installation des bundles Symfony essentiels</h1></summary>
<details>
    <summary><h2>4.1 - Installation du Maker Bundle (outils de développement)</h2></summary>

- Dans le conteneur PHP
```bash
composer require --dev symfony/maker-bundle
```
- Vérifier l'installation
```bash
sf list make
```
- 🛠️ Ce que le Maker Bundle apporte :
    - `make:controller` - Créer des contrôleurs
    - `make:entity` - Créer des entités Doctrine
    - `make:form` - Créer des formulaires
    - `make:crud` - Générer un CRUD complet
    - `make:migration` - Créer des migrations de base de données
    - `make:user` - Créer un système d'utilisateurs
    - `make:auth` - Créer un système d'authentification
    - Et bien d'autres commandes de génération !
</details>
<details>
    <summary><h2>4.2 - Installation du WebApp Pack (stack complète)</h2></summary>

- Dans le conteneur PHP
```bash
composer require symfony/webapp-pack
```
- Sortir du conteneur
```bash
exit
```
- 🚀 Ce que le WebApp Pack apporte :
    - **Twig** - Moteur de templates pour les vues
    - **Doctrine Migrations** - Gestion des migrations de BDD
    - **Security Bundle** - Authentification et autorisation
    - **Form Component** - Création de formulaires
    - **Validator** - Validation des données
    - **Asset Component** - Gestion des assets (CSS, JS)
    - **Mailer** - Envoi d'emails
    - **Messenger** - Système de queues et messages asynchrones
    - **WebProfiler** - Outils de debug et profiling
    - **Et beaucoup d'autres composants essentiels !**

</details>
<details>
    <summary><h2>4.3 - ‼️⚠️‼️Reconstruction après installation‼️⚠️‼️</h2></summary>

Ces installations peuvent modifier les fichiers Docker et ajouter de nouveaux services
```bash
docker compose down 
```
Rebuild avec la nouvelle configuration
```bash
docker compose build
```
Relancer la nouvelle configuration
```bash
docker compose up -d
```
</details>
<details>
    <summary><h2>4.4 - Test des nouvelles fonctionnalités</h2></summary>

 - Dans le conteneur PHP
Voir toutes les commandes Symfony disponibles
```bash
sf list
```
Voir spécifiquement les commandes make
```bash
sf list make
```
Exemple : Créer votre première entité
```bash
sf make:entity Product
```
Créer une migration après avoir créé des entités
```bash
sf make:migration
```
Appliquer les migrations à la base de données
```bash
sf make:migrations:migrate
```
Générer un contrôleur
```bash
sf make:controller ProductController
```
Générer un CRUD complet pour une entité
```bash
sf make:crud Product
```
</details>
</details>


</details>





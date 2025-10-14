# 🏍️ Administration EasyAdmin - Guide d'utilisation

## Accès à l'interface d'administration

**URL** : `/admin`

L'interface d'administration vous permet de gérer tous les aspects de votre application de gestion de motos.

## Fonctionnalités disponibles

### 👥 Gestion des Utilisateurs

- **Voir tous les utilisateurs** : Liste complète avec pagination
- **Créer un utilisateur** : Formulaire complet avec validation
- **Modifier un utilisateur** : Édition des informations et rôles
- **Supprimer un utilisateur** : Suppression sécurisée
- **Gestion des rôles** :
  - `ROLE_USER` : Utilisateur standard (badge vert)
  - `ROLE_ADMIN` : Administrateur (badge orange)  
  - `ROLE_SUPER_ADMIN` : Super administrateur (badge rouge)

#### Champs disponibles :
- Email (requis, unique)
- Mot de passe (hashé automatiquement)
- Rôles (sélection multiple)
- Garage associé (optionnel)

### 🏍️ Gestion des Motos

- **CRUD complet** : Créer, lire, modifier, supprimer
- **Upload d'images** : Gestion automatique des fichiers
- **Validation avancée** : Contraintes sur tous les champs
- **Filtres et recherche** : Recherche rapide et filtres avancés

#### Champs disponibles :
- Marque (relation vers Marque) ✅ Requis
- Modèle ✅ Requis  
- Édition (optionnel)
- Catégorie (liste prédéfinie) ✅ Requis
- Année (1900-2030) ✅ Requis
- Couleur ✅ Requis
- Cylindrée (50-3000 cc) ✅ Requis
- Puissance (5-450 ch) ✅ Requis
- Description (texte long) ✅ Requis
- Utilité (optionnel)
- Image (upload automatique)
- Garage (relation vers Garage)

#### Catégories disponibles :
- Sportive
- Roadster
- Cruiser  
- Trail
- Scooter
- Custom
- Touring

### 🏷️ Gestion des Marques

- **CRUD complet** pour les marques de moto
- **Relations** : Voir les motos associées
- **Tri** : Par nom alphabétique

#### Champs disponibles :
- Nom de la marque ✅ Requis
- Pays d'origine (optionnel)
- Année de création (optionnel)
- Motos associées (lecture seule)

### 🏢 Gestion des Garages

- **CRUD complet** pour les garages
- **Relations** : Propriétaire et motos stockées
- **Géolocalisation** : Lieu et code postal

#### Champs disponibles :
- Nom du garage ✅ Requis
- Localisation ✅ Requis
- Code postal ✅ Requis
- Propriétaire (relation vers User)
- Motos dans ce garage (lecture seule)

## Navigation et Interface

### Menu principal :
- 🏠 **Dashboard** : Page d'accueil de l'admin
- 👥 **Utilisateurs** : Gestion complète des comptes
- 🏍️ **Motos** : Catalogue des véhicules
- 🏷️ **Marques** : Base de données des fabricants
- 🏢 **Garages** : Lieux de stockage
- 👁️ **Voir le site** : Retour au site public

### Fonctionnalités d'interface :
- ✅ Interface responsive (mobile-friendly)
- 🔍 Recherche et filtres avancés
- 📄 Pagination automatique (15-20 éléments/page)
- 🏷️ Badges colorés pour les statuts
- 📊 Actions en lot disponibles
- 💾 Sauvegarde automatique des préférences

## Création d'un administrateur

### Méthode 1 : Via console Symfony
```bash
# Dans le conteneur Docker
docker exec symfony-stack-php-1 php bin/console app:create-admin

# En local
php bin/console app:create-admin admin@example.com
```

### Méthode 2 : Via l'interface (si un admin existe)
1. Se connecter à `/admin`
2. Aller dans "Utilisateurs"  
3. Cliquer "Nouvel utilisateur"
4. Remplir le formulaire et assigner le rôle `ROLE_ADMIN`

## Sécurité

### Contrôles d'accès :
- **ROLE_ADMIN requis** pour accéder à `/admin`
- **Hashage automatique** des mots de passe
- **Validation** des données côté serveur et client
- **CSRF** protection intégrée

### Bonnes pratiques :
- ✅ Utiliser des mots de passe forts
- ✅ Limiter les rôles SUPER_ADMIN
- ✅ Vérifier régulièrement les accès
- ✅ Sauvegarder avant modifications importantes

## Upload de fichiers

### Configuration images motos :
- **Dossier** : `public/uploads/`
- **Formats** : JPG, PNG, GIF
- **Taille max** : Configurée dans PHP
- **Nommage** : Hash automatique pour éviter les conflits

## Dépannage

### Problèmes courants :

1. **Accès refusé à /admin**
   - Vérifier que l'utilisateur a le rôle `ROLE_ADMIN`
   - S'assurer d'être connecté

2. **Erreur 500 sur les formulaires**
   - Vider le cache : `php bin/console cache:clear`
   - Vérifier les relations entre entités

3. **Upload d'images impossible**
   - Vérifier les permissions du dossier `public/uploads/`
   - Contrôler la taille max des fichiers PHP

4. **Relations manquantes**
   - S'assurer que les entités liées existent
   - Vérifier la cohérence des données

### Commandes utiles :
```bash
# Vider le cache
php bin/console cache:clear

# Mettre à jour la BDD
php bin/console doctrine:schema:update --force

# Lister les utilisateurs
php bin/console doctrine:query:sql "SELECT * FROM user"

# Debug des routes admin
php bin/console debug:router | grep admin
```

## Personnalisation

L'interface peut être personnalisée en modifiant :
- `src/Controller/Admin/DashboardController.php` : Menu et configuration globale
- `src/Controller/Admin/*CrudController.php` : Configuration des entités
- Templates Twig personnalisés si nécessaire

---

🎉 **Votre interface d'administration est maintenant opérationnelle !**

Pour toute question, consultez la [documentation EasyAdmin](https://symfony.com/bundles/EasyAdminBundle/current/index.html).
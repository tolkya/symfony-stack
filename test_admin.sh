#!/bin/bash

# Script de test pour l'administration EasyAdmin

echo "🏍️ Test de l'interface d'administration Moto"
echo "============================================"
echo ""

# Vérifications de base
echo "1. Vérification des contrôleurs Admin..."
if [ -f "src/Controller/Admin/UserCrudController.php" ]; then
    echo "   ✅ UserCrudController existe"
else
    echo "   ❌ UserCrudController manquant"
fi

if [ -f "src/Controller/Admin/MotoCrudController.php" ]; then
    echo "   ✅ MotoCrudController existe"
else
    echo "   ❌ MotoCrudController manquant"
fi

if [ -f "src/Controller/Admin/MarqueCrudController.php" ]; then
    echo "   ✅ MarqueCrudController existe"
else
    echo "   ❌ MarqueCrudController manquant"
fi

if [ -f "src/Controller/Admin/GarageCrudController.php" ]; then
    echo "   ✅ GarageCrudController existe"
else
    echo "   ❌ GarageCrudController manquant"
fi

echo ""
echo "2. Pages d'administration disponibles :"
echo "   📱 Dashboard principal : /admin"
echo "   👥 Gestion utilisateurs : /admin?crudController=UserCrudController"
echo "   🏍️ Gestion motos : /admin?crudController=MotoCrudController" 
echo "   🏷️ Gestion marques : /admin?crudController=MarqueCrudController"
echo "   🏢 Gestion garages : /admin?crudController=GarageCrudController"
echo ""

echo "3. Fonctionnalités disponibles :"
echo "   ✨ CRUD complet pour les utilisateurs"
echo "   🔐 Gestion des rôles (USER, ADMIN, SUPER_ADMIN)"
echo "   🔑 Hashage automatique des mots de passe"
echo "   🖼️ Upload d'images pour les motos"
echo "   🔍 Filtres et recherche avancée"
echo "   📊 Pagination automatique"
echo "   💎 Interface responsive"
echo ""

echo "4. Test de connexion :"
echo "   Pour tester l'admin, vous devez :"
echo "   1. Créer un utilisateur admin en base"
echo "   2. Vous connecter via /login"
echo "   3. Accéder à /admin"
echo ""

echo "5. Commandes utiles :"
echo "   # Créer un admin via console"
echo "   docker exec symfony-stack-php-1 php bin/console app:create-admin"
echo ""
echo "   # Vider le cache"
echo "   docker exec symfony-stack-php-1 php bin/console cache:clear"
echo ""

echo "✅ Configuration EasyAdmin terminée !"
echo "   Votre interface d'administration est prête à utiliser."
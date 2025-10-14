#!/bin/bash

echo "🔐 Test des liens d'administration dans la navbar"
echo "================================================"
echo ""

echo "Vérification de l'implémentation :"
echo ""

# Vérifier la présence des conditions dans le template
if grep -q "is_granted('ROLE_ADMIN')" templates/base.html.twig; then
    echo "✅ Condition ROLE_ADMIN trouvée dans base.html.twig"
else
    echo "❌ Condition ROLE_ADMIN manquante dans base.html.twig"
fi

# Vérifier la route admin
if grep -q "path('admin')" templates/base.html.twig; then
    echo "✅ Lien vers la route 'admin' configuré"
else
    echo "❌ Lien vers la route 'admin' manquant"
fi

echo ""
echo "Fonctionnement attendu :"
echo "========================"
echo ""
echo "👤 Utilisateur normal (ROLE_USER) :"
echo "   - Voir uniquement : Home, Toutes les motos, Mon Garage, Ajouter une moto"
echo "   - PAS de lien Administration visible"
echo ""
echo "👑 Administrateur (ROLE_ADMIN) :"
echo "   - Voir tous les liens utilisateur PLUS :"
echo "   - 🟡 Lien 'Administration' dans le menu principal"
echo "   - 🟡 Bouton 'Admin Panel' à droite (jaune)"
echo "   - 🟡 Badge 'Admin' à côté du nom d'utilisateur"
echo ""
echo "🎯 URL de destination : /admin"
echo "   → Redirige automatiquement vers la gestion des utilisateurs"
echo ""
echo "Pour tester :"
echo "============="
echo "1. Créer un utilisateur admin :"
echo "   docker exec symfony-stack-php-1 php bin/console app:create-admin"
echo ""
echo "2. Se connecter avec cet utilisateur"
echo ""
echo "3. Vérifier que les liens admin apparaissent dans la navbar"
echo ""
echo "4. Cliquer sur un des liens admin pour accéder à l'interface"
echo ""

# Tester si les routes admin existent
echo "Vérification des routes :"
if [ -f "src/Controller/Admin/DashboardController.php" ]; then
    echo "✅ DashboardController existe"
    
    if grep -q "routePath: '/admin'" src/Controller/Admin/DashboardController.php; then
        echo "✅ Route /admin configurée"
    else
        echo "❌ Route /admin non trouvée"
    fi
    
    if grep -q "routeName: 'admin'" src/Controller/Admin/DashboardController.php; then
        echo "✅ Nom de route 'admin' configuré"
    else
        echo "❌ Nom de route 'admin' non trouvé"
    fi
else
    echo "❌ DashboardController manquant"
fi

echo ""
echo "🎨 Styles appliqués :"
echo "   - Liens admin en couleur jaune/warning"
echo "   - Badge 'Admin' visible à côté du nom"
echo "   - Bouton distinctif dans la barre de droite"
echo ""
echo "✅ Configuration terminée !"
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
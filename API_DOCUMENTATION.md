# API Motos - Documentation

## Endpoints disponibles

Votre API Motos est maintenant configurée avec API Platform ! Voici les endpoints disponibles :

### Motos

| Méthode | URL | Description | Paramètres |
|---------|-----|-------------|------------|
| GET | `/api/motos` | Récupère toutes les motos | Filtres disponibles |
| GET | `/api/motos/{id}` | Récupère une moto par ID | - |
| POST | `/api/motos` | Crée une nouvelle moto | Corps JSON requis |
| PUT | `/api/motos/{id}` | Met à jour une moto | Corps JSON requis |
| DELETE | `/api/motos/{id}` | Supprime une moto | - |

### Filtres disponibles sur GET /api/motos

- `marque.nom` (recherche partielle) : `/api/motos?marque.nom=yamaha`
- `Modele` (recherche partielle) : `/api/motos?Modele=ninja`
- `Categorie` (recherche exacte) : `/api/motos?Categorie=sportive`
- `Couleur` (recherche exacte) : `/api/motos?Couleur=rouge`
- `Annee` (plage) : `/api/motos?Annee[gte]=2020&Annee[lte]=2024`
- `Cylindree` (plage) : `/api/motos?Cylindree[gte]=600&Cylindree[lte]=1000`
- `Chevaux` (plage) : `/api/motos?Chevaux[gte]=100`

### Tri

- `order[Annee]=desc` : Trier par année (desc/asc)
- `order[Cylindree]=asc` : Trier par cylindrée
- `order[marque.nom]=asc` : Trier par nom de marque

### Pagination

- `page=1` : Numéro de page
- `itemsPerPage=20` : Nombre d'éléments par page (défaut: 20)

## Exemples d'utilisation

### Récupérer toutes les motos
```bash
curl -X GET "http://localhost/api/motos"
```

### Créer une nouvelle moto
```bash
curl -X POST "http://localhost/api/motos" \
  -H "Content-Type: application/json" \
  -d '{
    "marque": "/api/marques/1",
    "Modele": "CBR 600RR",
    "Categorie": "sportive", 
    "Annee": 2023,
    "Couleur": "rouge",
    "Cylindree": 600,
    "Chevaux": 120,
    "Description": "Moto sportive Honda"
  }'
```

### Filtrer les motos sportives de plus de 100 chevaux
```bash
curl -X GET "http://localhost/api/motos?Categorie=sportive&Chevaux[gte]=100"
```

## Interface de documentation

API Platform génère automatiquement une interface de documentation interactive accessible à :
- **Swagger UI** : `http://localhost/api/docs`
- **ReDoc** : `http://localhost/api/docs?ui=re_doc`

## Formats supportés

- JSON (par défaut)
- JSON-LD
- HAL+JSON
- XML (si configuré)

## Groupes de sérialisation

### Moto
- `moto:read` : Propriétés visibles lors de la lecture
- `moto:write` : Propriétés modifiables lors de l'écriture

### Marque  
- `marque:read` : Propriétés visibles lors de la lecture
- `marque:write` : Propriétés modifiables lors de l'écriture

### Garage
- `garage:read` : Propriétés visibles lors de la lecture  
- `garage:write` : Propriétés modifiables lors de l'écriture

## Test de l'API

Vous pouvez tester votre API avec :
- L'interface Swagger UI intégrée
- Postman ou Insomnia
- curl en ligne de commande
- Le endpoint de test : `GET /api/test/status`
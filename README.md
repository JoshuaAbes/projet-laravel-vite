# Fiction Interactive - "Le Chemin vers la Gloire"

Une application de fiction interactive où les choix de l'utilisateur influencent le déroulement de l'histoire. Cette application est développée avec Laravel pour le backend et Vue.js pour le frontend.

## 📖 À propos du projet

Ce projet est une fiction interactive qui raconte l'histoire d'un jeune footballeur, de ses débuts dans le quartier jusqu'à la finale de la Coupe du Monde. Les choix effectués par l'utilisateur déterminent le destin du personnage, avec plusieurs fins possibles.

L'application utilise :
- Backend : Laravel (API RESTful)
- Frontend : Vue.js
- Base de données : SQLite

## 📋 Fonctionnalités

- **Navigation interactive** : Progresser dans l'histoire à travers différents chapitres selon vos choix
- **Sauvegarde de progression** : Mémorisation du parcours de l'utilisateur
- **Interface responsive** : Expérience adaptée sur mobile et desktop
- **API RESTful** : Backend structuré avec contrôleurs, models et validation

## 🚀 Installation

### Prérequis

- PHP >= 8.1
- Composer
- Node.js et npm
- SQLite

### Étapes d'installation

1. **Cloner le dépôt**

```bash
git clone https://github.com/votre-username/projet-laravel-vite.git
cd projet-laravel-vite
```

2. **Installer les dépendances PHP**

```bash
composer install
```

3. **Configurer l'environnement**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurer la base de données**

Dans le fichier `.env`, configurez SQLite :

```
DB_CONNECTION=sqlite
DB_DATABASE=/chemin/absolu/vers/database/database.sqlite
```

Puis créez le fichier de base de données :

```bash
touch database/database.sqlite
```

5. **Exécuter les migrations et seeders**

```bash
php artisan migrate --seed
```

6. **Installer les dépendances JavaScript**

```bash
npm install
```

7. **Lancer le serveur de développement**

```bash
php artisan serve
npm run dev
```

L'application sera accessible à l'adresse [http://localhost:8000](http://localhost:8000)

## 📝 Structure de l'API

### Points d'accès (endpoints)

| Méthode | URI | Description |
|---------|-----|-------------|
| GET | /v1/stories | Liste toutes les histoires publiées |
| GET | /v1/stories/{id} | Récupère une histoire spécifique |
| GET | /v1/chapters/{id} | Récupère un chapitre spécifique avec ses choix |
| POST | /v1/progress | Sauvegarde la progression de l'utilisateur |
| GET | /v1/progress | Récupère la progression de l'utilisateur |

### Exemples d'utilisation

```bash
# Récupérer toutes les histoires
curl http://localhost:8000/v1/stories

# Récupérer un chapitre spécifique
curl http://localhost:8000/v1/chapters/1
```

## 🏗️ Architecture du projet

### Backend (Laravel)

- **Models**: Story, Chapter, Choice, UserProgress
- **Controllers**: StoryController, ChapterController, ChoiceController, UserProgressController
- **Requests**: Validation des données entrantes via FormRequest
- **Middlewares**: Protection des routes avec auth:sanctum

### Frontend (Vue.js)

- **Components**: StoryList, ChapterView, ChoiceSelector, etc.
- **Stores**: Pinia pour la gestion d'état
- **Routes**: Vue Router pour la navigation

## 👥 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à ouvrir une issue ou une pull request.

## 📄 License

Ce projet est sous license MIT.
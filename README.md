# EasyColoc – Plateforme Web de Gestion de Colocation

**EasyColoc** est une application web permettant de gérer facilement une colocation. Elle suit les dépenses communes et calcule automatiquement les dettes entre membres afin de savoir **qui doit quoi à qui**.

---

## 🏠 Fonctionnalités principales

### Utilisateurs
- Inscription et connexion
- Gestion du profil
- Blocage automatique des utilisateurs bannis
- Système de rôles :
  - **Member** : participe à une colocation, ajoute des dépenses, marque les paiements.
  - **Owner** : crée et gère une colocation, invite/retire des membres, annule la colocation.
  - **Global Admin** : gère la plateforme, accède aux statistiques globales, bannit/débannit les utilisateurs.

### Colocations
- Création, modification et annulation
- Invitations par lien/token avec email
- Une seule colocation active par utilisateur
- Départ des membres avec suivi des dettes

### Dépenses
- Ajout d’une dépense (titre, montant, date, catégorie, payeur)
- Historique et statistiques par catégorie
- Filtrage par mois
- Calcul automatique des soldes et affichage de la vue **« qui doit à qui »**
- Paiements simples via **« Marquer payé »**

### Réputation
- +1 ou -1 selon le comportement financier
- Ajustement des dettes si un owner retire un membre

### Administration
- Dashboard global pour statistiques (utilisateurs, colocations, dépenses)
- Gestion des utilisateurs bannis

---

## 💻 Technologies utilisées
- **Backend** : Laravel (PHP)
- **Frontend** : Blade + Tailwind CSS
- **Base de données** : MySQL / PostgreSQL
- **ORM** : Eloquent
- **Authentification** : Laravel Breeze / Jetstream
- **Gestion des versions** : Git / GitHub
- **Architecture** : MVC (Model – View – Controller)

---

## ⚙️ Installation

1. **Cloner le repository**
```bash
git clone https://github.com/ton-username/easycoloc.git
cd easycoloc
```

2. **Installer les dépendances**
```bash
composer install
npm install
npm run dev
```

3. **Configurer l’environnement**
```bash
cp .env.example .env
php artisan key:generate
```
- Modifier le fichier `.env` avec vos informations de base de données

4. **Exécuter les migrations et seeders**
```bash
php artisan migrate --seed
```

5. **Lancer le serveur**
```bash
php artisan serve
```

---

## 🔐 Sécurité et bonnes pratiques
- Protection CSRF avec `@csrf`
- Échappement automatique Blade pour XSS (`{{ }}`)
- Validation côté serveur avec Form Request ou `validate()`
- Validation côté client avec HTML5
- Requêtes sécurisées via Eloquent / Query Builder

---

## 📂 Structure du projet

```
app/
├─ Http/
│  ├─ Controllers/
│  └─ Requests/
├─ Models/
resources/
├─ views/
routes/
├─ web.php
database/
├─ migrations/
├─ seeders/
```

---

## 🧩 Diagrammes UML
- Diagramme des cas d’utilisation (Use Case)
- Diagramme de classes

---

## 📅 Dates importantes
- **Durée du projet** : 5 jours
- **Date de lancement** : 23/02/2026
- **Date limite** : 27/02/2026

---

## 📤 Livrables
- Repository GitHub
- Présentation
- Diagrammes UML

---

## 🎯 Objectifs
- Gérer les colocations et dépenses partagées
- Calcul automatique des dettes et soldes
- Gestion des rôles et autorisations
- Interface responsive et sécurisée
- Application maintenable et structurée selon les bonnes pratiques Laravel

---

## 🌟 Bonus (hors périmètre)
- Paiement en ligne (Stripe)
- Notifications en temps réel
- Export de données
- Calendrier

---

## 👨‍💻 Auteur
**Kadiri Mohamed** – Développeur web
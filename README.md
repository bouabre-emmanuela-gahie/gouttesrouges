# Gouttes Rouges — Site web dynamique

Site de l'association **Gouttes Rouges** (Côte d'Ivoire), réalisé selon le cahier des charges et les wireframes du projet de Licence Professionnelle.

## Technologies

- Front-end : HTML5, CSS3, JavaScript
- Back-end : PHP
- Base de données : MySQL
- Environnement local prévu : XAMPP (Apache, MySQL, phpMyAdmin)
- URL locale visée : `http://localhost/gouttes-rouges/`

## Installation avec XAMPP

1. Copier ce dossier dans `htdocs` et le nommer `gouttes-rouges`.
2. Démarrer Apache et MySQL dans XAMPP.
3. Ouvrir phpMyAdmin, importer `sql/gouttes_rouges.sql`.
4. Vérifier les identifiants dans `includes/config.php` (par défaut : utilisateur `root`, mot de passe vide).
5. Ouvrir `http://localhost/gouttes-rouges/`.

## Administration

- Adresse : `http://localhost/gouttes-rouges/admin/login.php`
- Email : `admin@gouttesrouges.org`
- Mot de passe : `GouttesRouges2026!`

L'espace admin permet de gérer les articles, campagnes, dons, messages et partenaires.

## Pages publiques

- Accueil
- Qui sommes-nous ?
- Nos actions
- Ressources
- Nous soutenir
- Contact
- Mentions légales, politique de confidentialité, conditions d'utilisation, plan du site

Les formulaires (dons, bénévolat, partenariat, contact, newsletter) s'enregistrent en MySQL. Sans base connectée, le site affiche tout de même les contenus et stocke les envois dans le dossier `data/`.

## Lancer sans XAMPP (PHP intégré)

```bash
php -S localhost:8080
```

Puis ouvrir `http://localhost:8080/`.

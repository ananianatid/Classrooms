# Classrooms

Application web de gestion de fichiers de classe organises par semestres. Permet de parcourir, uploader (jusqu'a 100 Mo) et telecharger des fichiers et dossiers (en ZIP) pour une classe scolaire.

## Stack technique

- PHP 8.3+
- Laravel 13
- Vite / Tailwind CSS 4
- SQLite

## Etat d'avancement

Production-ready -- fonctionnel avec exploration de fichiers, upload, historique et file d'attente.

## Demarrage

```bash
composer run dev
```

Lance artisan serve + queue worker + logs + Vite simultanement.

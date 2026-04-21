# Classrooms - Spécification Fonctionnelle Complète

> Documentation technique pour la reproduction du projet dans une autre technologie

## Vue d'ensemble

**Classrooms** est une application web de gestion et partage de ressources pédagogiques pour une classe. Elle permet aux étudiants d'accéder aux cours, TDs, et ressources par semestre et matière, avec un système d'upload, de téléchargement et un emploi du temps intégré.

---

## Architecture du Système de Fichiers

```
Classrooms/
├── index.php                 # Page d'accueil - liste des semestres
├── Functions/
│   ├── explorer.php          # Navigation dans les dossiers/fichiers
│   ├── metadata.php          # Métadonnées (taille, date, nom)
│   ├── upload_functions.php  # Gestion des uploads
│   ├── download_functions.php# Gestion des téléchargements (ZIP)
│   └── agenda.php            # Emploi du temps (affichage/calculs)
├── Web-pages/
│   ├── fileExplorer.php      # Explorateur de fichiers
│   ├── upload.php            # Formulaire d'upload
│   ├── agenda.php            # Vue emploi du temps
│   ├── up_history.php        # Historique des uploads
│   └── semesters_list.php    # Liste des semestres
├── HTML-elements/
│   ├── header.php            # En-tête avec navigation
│   └── footer.php            # Pied de page
├── Data-base/
│   └── timetable.php         # Données emploi du temps (hardcodées)
├── Semesters/                # Structure de stockage des fichiers
│   ├── S1/
│   │   ├── Mathematiques/
│   │   │   ├── Cours/
│   │   │   └── TDs/
│   │   └── Physique/
│   └── S2/
├── Upload/                   # Zone de dépôt temporaire (uploads)
├── Css/                      # Styles CSS
└── Js/                       # JavaScript (header interactif)
```

---

## Fonctionnalités Principales

### 1. Navigation dans les Semestres et Matières

**Fichier clé :** `Functions/explorer.php`

#### Fonctions :

| Fonction | Paramètres | Retour | Description |
|----------|------------|--------|-------------|
| `get_semesters_list()` | Aucun | `array` | Retourne tous les semestres depuis le dossier `Semesters/` |
| `get_directory_items($path)` | `$path: string` | `array` | Liste tous les éléments d'un dossier |
| `get_project_name()` | Aucun | `string` | Nom du projet (dernier segment du chemin) |
| `get_relative_path($path)` | `$path: string` | `string` | Chemin relatif depuis la racine du projet |
| `get_folder_title($path)` | `$path: string` | `string` | Nom du dossier/fichier (sans extension) |
| `show_folder_content($path, $target)` | `$path: array|string`, `$target: string` | `void` (HTML) | Affiche le contenu d'un dossier avec icônes et métadonnées |
| `backbutton($path)` | `$path: string` | `string` | Génère le lien de retour au dossier parent |
| `fileDeleter($path)` | `$path: string` | `void` | Supprime les fichiers de +1 heure dans un dossier |

#### Algorithme de `show_folder_content` :
```
POUR CHAQUE élément dans le dossier:
    SI élément EST un dossier:
        - Afficher icône dossier
        - Afficher nom du dossier
        - Afficher nombre d'éléments contenus
        - Afficher date de création
        - Lien vers fileExplorer.php?target=<chemin>
    
    SINON SI élément EST un fichier:
        - Afficher icône selon extension (.svg)
        - Afficher nom tronqué (21 chars max) + extension
        - Afficher taille (Ko, Mo, Go)
        - Afficher date de modification
        - Lien de téléchargement direct
```

---

### 2. Système de Métadonnées

**Fichier clé :** `Functions/metadata.php`

#### Fonctions :

| Fonction | Paramètres | Retour | Description |
|----------|------------|--------|-------------|
| `file_size($path)` | `$path: string` | `string` | Taille formatée (B, KB, MB, GB) |
| `creation_date($path)` | `$path: string` | `string` | Date au format "M d, Y" (ex: "Jan 15, 2024") |
| `filename_limiter($filename)` | `$filename: string` | `string` | Nom tronqué à 21 caractères + "(...)" |
| `folder_items($path)` | `$path: string` | `int` | Nombre d'éléments dans un dossier |

#### Logique de `file_size` :
```php
SI taille > 1GB: retourner (taille/1GB) + "Gb"
SINON SI taille > 1MB: retourner (taille/1MB) + "Mb"
SINON SI taille > 1KB: retourner (taille/1KB) + "Kb"
SINON: retourner taille + "B"
```

---

### 3. Système d'Upload

**Fichier clé :** `Functions/upload_functions.php`

#### Fonctions :

| Fonction | Paramètres | Retour | Description |
|----------|------------|--------|-------------|
| `uploader()` | Aucun (utilise `$_FILES`) | `string` (HTML) | Gère l'upload et affiche un message de statut |

#### Algorithme d'upload :
```
SI méthode HTTP == POST:
    SI $_FILES["file"] existe ET aucune erreur:
        extraire: nom, type, taille
        
        SI dossier "../Upload/" existe:
            SI fichier existe déjà:
                retourner "échec: fichier existe"
            SINON:
                déplacer fichier vers "../Upload/<nom>"
                retourner "succès"
        SINON:
            créer dossier "../Upload/" (permissions 777)
            retourner "erreur: dossier créé"
```

#### Page d'upload (`Web-pages/upload.php`) :
- Formulaire `multipart/form-data`
- Input file unique
- Bouton submit "Upload"
- Affichage du message de retour (succès/échec)

---

### 4. Système de Téléchargement

**Fichier clé :** `Functions/download_functions.php`

#### Fonctions :

| Fonction | Paramètres | Retour | Description |
|----------|------------|--------|-------------|
| `zipper($source, $destination)` | `$source: string`, `$destination: string` | `void` | Crée une archive ZIP d'un dossier |

#### Algorithme de `zipper` :
```
CRÉER nouvelle instance ZipArchive
OUVRIR destination en mode CRÉATION

POUR CHAQUE fichier dans source (récursivement):
    fichier = chemin réel
    SI fichier EST dossier:
        ajouter dossier vide dans ZIP
    SINON SI fichier EST fichier:
        ajouter fichier dans ZIP avec contenu

FERMER ZIP
```

#### Téléchargement individuel :
- Utilise l'attribut HTML5 `download` sur les liens `<a>`
- Format : `<a href="<chemin>" download="<nom_fichier>">`

---

### 5. Emploi du Temps

**Fichier clé :** `Functions/agenda.php` + `Data-base/timetable.php`

#### Structure des données (`timetable.php`) :
```php
$subjects = ["infographie", "Environnement des telecommunications", ...];

$lundi = [
    ["heure d'étude", "700", "1000", "Pas de professeur"],  // [sujet, heure_début, heure_fin, professeur]
    ["Pause", "1000", "1030", "Pas de professeur"],
    ["infographie", "1030", "1230", ""],
    ...
];

$time_table = [
    'Mon' => $lundi,
    'Tue' => $mardi,
    'Wed' => $mercredi,
    'Thu' => $jeudi,
    'Fri' => $vendredi
];

$days_name = [
    'Mon' => "Lundi",
    'Tue' => "Mardi",
    ...
];
```

#### Fonctions (`agenda.php`) :

| Fonction | Paramètres | Retour | Description |
|----------|------------|--------|-------------|
| `day_timetable($today, $day_key)` | `$today: array`, `$day_key: string` | `void` (HTML) | Affiche les cours d'un jour |
| `day_timetable_nav($today, $day_key)` | `$today: array`, `$day_key: string` | `void` (HTML) | Version navigation (dropdown) |
| `week_timetable($timetable, $dayname)` | `$timetable: array`, `$dayname: array` | `void` (HTML) | Affiche la semaine complète |
| `counter_after_school_started($startDate)` | `$startDate: int` (timestamp) | `array` | [jours écoulés, semaines écoulées] |
| `counter_before_holidays($endDate)` | `$endDate: int` (timestamp) | `array` | [jours restants, semaines restantes] |

#### Logique d'affichage :
```
POUR CHAQUE jour dans la semaine:
    SI jour == jour_actuel:
        ajouter classe CSS "active_day"
    
    POUR CHAQUE cours du jour:
        heure_début = cours[1]  // ex: "700" = 7:00
        heure_fin = cours[2]    // ex: "1000" = 10:00
        
        SI heure_actuelle >= heure_début ET heure_actuelle < heure_fin:
            ajouter classe CSS "active_hour"
        
        AFFICHER cours avec style approprié
```

#### Compteurs de temps :
```php
// Jours depuis la rentrée
$seconds = time() - $startDate
$days = ceil($seconds / 86400)  // 86400 = secondes dans un jour
$weeks = ceil($days / 7)

// Jours avant les vacances
$seconds = $endDate - time()
$days = ceil($seconds / 86400)
$weeks = ceil($days / 7)
```

---

### 6. Historique des Uploads

**Fichier clé :** `Web-pages/up_history.php`

- Affiche le contenu du dossier `Upload/`
- Utilise `show_folder_content()` pour l'affichage
- Liste tous les fichiers uploadés
- Permet le téléchargement individuel

---

### 7. Navigation et UI

#### Header (`HTML-elements/header.php`) :
- Logo "DEFITECH CLASSROOMS" (lien vers index)
- Bouton de navigation (icône boussole)
- Liens : "Semestres" → `semesters_list.php`, "Agenda" → `agenda.php`

#### Footer (`HTML-elements/footer.php`) :
- Affiche le titre de la page courante
- Contient un bouton retour (via `backbutton()`)

#### JavaScript (`Js/header.js`) :
- Gère l'ouverture/fermeture du menu de navigation

---

## Pages de l'Application

| Page | URL | Fonction |
|------|-----|----------|
| Accueil | `index.php` | Liste les semestres disponibles |
| Explorateur | `Web-pages/fileExplorer.php?target=<chemin>` | Affiche le contenu d'un dossier |
| Upload | `Web-pages/upload.php` | Formulaire d'upload de fichier |
| Emploi du temps | `Web-pages/agenda.php` | Vue hebdomadaire des cours |
| Historique | `Web-pages/up_history.php` | Liste des fichiers uploadés |
| Liste semestres | `Web-pages/semesters_list.php` | Vue complète des semestres |

---

## Règles de Gestion

### Structure des Semestres
```
Semesters/
├── <Semestre_N>/          # Ex: "Semestre_1"
│   ├── <Matière_N>/       # Ex: "Mathematiques"
│   │   ├── Cours/         # Cours magistraux
│   │   ├── TDs/           # Travaux dirigés
│   │   └── TP/            # Travaux pratiques (optionnel)
│   └── <Matière_N+1>/
└── <Semestre_N+1>/
```

### Conventions de Nommage
- **Dossiers** : Pas d'espaces, caractères alphanumériques
- **Fichiers** : Noms descriptifs, extensions en minuscules
- **Extensions supportées** : pdf, docx, xlsx, pptx, jpg, png, mp4, etc. (voir `Pictures/Extensions/`)

### Gestion des Fichiers
- **Upload** : Dossier temporaire `Upload/`
- **Stockage permanent** : Dossier `Semesters/<semestre>/<matière>/<catégorie>/`
- **Nettoyage** : `fileDeleter()` supprime les fichiers de +1 heure dans `Upload/`

---

## Spécifications pour Reproduction

### Pré-requis Techniques (à adapter)

| Composant | Technologie Originale | Équivalents Possibles |
|-----------|----------------------|----------------------|
| Backend | PHP 7+ | Node.js/Express, Python/Django, Ruby/Rails |
| Frontend | HTML5 + CSS3 + JS vanilla | React, Vue, Svelte, Angular |
| Stockage | Système de fichiers local | AWS S3, Google Cloud Storage, Azure Blob |
| ZIP | ZipArchive (PHP) | archiver (Node), zipfile (Python) |

### API à Implémenter

#### 1. Gestion des Fichiers
```
GET  /api/semesters           # Liste des semestres
GET  /api/folders/:path       # Contenu d'un dossier
GET  /api/files/:path         # Télécharger un fichier
POST /api/upload              # Upload un fichier
DELETE /api/files/:path       # Supprimer un fichier
```

#### 2. Emploi du Temps
```
GET /api/timetable            # Emploi du temps complet
GET /api/timetable/:day       # Emploi du temps d'un jour
GET /api/counters             # Jours/semaines depuis la rentrée
```

#### 3. Métadonnées
```
GET /api/metadata/:path       # Taille, date, nom d'un fichier
```

### Structure de Données (JSON)

#### Emploi du Temps
```json
{
  "subjects": ["Mathématiques", "Physique", "Informatique"],
  "timetable": {
    "Mon": [
      {"subject": "Mathématiques", "start": "08:00", "end": "10:00", "professor": "M. Dupont"},
      {"subject": "Pause", "start": "10:00", "end": "10:30", "professor": ""},
      {"subject": "Physique", "start": "10:30", "end": "12:30", "professor": "Mme Martin"}
    ]
  },
  "days_name": {
    "Mon": "Lundi",
    "Tue": "Mardi"
  }
}
```

#### Fichier/Dossier
```json
{
  "name": "Cours_Chapitre1.pdf",
  "type": "file",
  "path": "/Semesters/S1/Mathematiques/Cours/",
  "size": 1048576,
  "sizeFormatted": "1Mb",
  "createdAt": "2024-01-15T10:30:00Z",
  "extension": "pdf",
  "icon": "/images/extensions/pdf.svg"
}
```

---

## Workflows Utilisateur

### 1. Consulter un Cours
```
1. Utilisateur arrive sur l'accueil
2. Voit la liste des semestres
3. Clique sur un semestre → ouvre fileExplorer.php
4. Voit les matières
5. Clique sur une matière → ouvre le dossier
6. Voit les catégories (Cours, TDs, TP)
7. Clique sur un fichier → téléchargement automatique
```

### 2. Uploader un Fichier
```
1. Utilisateur navigue vers upload.php
2. Sélectionne un fichier via input[type=file]
3. Clique sur "Upload"
4. Le fichier est déplacé vers ../Upload/
5. Message de confirmation/erreur s'affiche
6. (Optionnel) Un admin déplace le fichier vers Semesters/
```

### 3. Consulter l'Emploi du Temps
```
1. Utilisateur clique sur "Agenda" dans le header
2. La page agenda.php charge timetable.php
3. Affiche 5 colonnes (Lundi → Vendredi)
4. Le cours en cours est surligné (classe .active_hour)
5. Le jour actuel est surligné (classe .active_day)
```

---

## Classes CSS Principales

| Classe | Usage |
|--------|-------|
| `.container` | Conteneur principal de page |
| `.box` | Zone de contenu |
| `.items` | Élément fichier/dossier cliquable |
| `.icon` | Conteneur d'icône |
| `.fileinfo` | Métadonnées du fichier |
| `.filename` | Nom du fichier |
| `.filesize` | Taille du fichier |
| `.filedate` | Date du fichier |
| `.active_hour` | Cours en cours (emploi du temps) |
| `.active_day` | Jour actuel (emploi du temps) |
| `.uploadstate.succes` | Message de succès upload |
| `.uploadstate.halfFail` | Message d'échec upload |
| `.downloader` | Bouton de téléchargement ZIP |

---

## Tests et Validation

**Fichier :** `Tests/functions_test.php`

Tests unitaires pour :
- `get_semesters_list()` - vérifie l'existence des semestres
- `get_directory_items()` - vérifie le contenu des dossiers
- `file_size()` - vérifie le formatage des tailles
- `creation_date()` - vérifie le format des dates
- `filename_limiter()` - vérifie la troncation à 21 caractères
- `fileDeleter()` - vérifie la suppression des anciens fichiers

---

## Évolutions Possibles

1. **Authentification** : Ajouter login/mot de passe pour restreindre l'accès
2. **Base de données** : Remplacer le stockage fichier par MySQL/PostgreSQL
3. **Recherche** : Ajouter une barre de recherche de fichiers
4. **Drag & Drop** : Upload par glisser-déposer
5. **Prévisualisation** : Aperçu PDF/images sans téléchargement
6. **Notifications** : Alertes pour nouveaux fichiers uploadés
7. **API REST** : Exposer toutes les fonctionnalités via API
8. **Mobile** : Application mobile native ou PWA

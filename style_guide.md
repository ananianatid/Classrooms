# Guide de Style — Anthropic Design System

> Instructions de style pour reproduire l'esthétique du site Anthropic dans une application web.

---

## Philosophie

L'esthétique Anthropic repose sur trois principes fondamentaux : **clarté radicale**, **chaleur sobre**, et **confiance par la retenue**. Aucune surcharge visuelle. Chaque élément mérite sa place. Le contenu respire.

Ce n'est pas du minimalisme froid — c'est du minimalisme chaud. La différence réside dans la palette, les arrondis, et le rythme typographique.

---

## Palette de Couleurs

### Variables CSS

```css
:root {
  /* Fonds */
  --color-bg-primary:    #F2EDE3;   /* Crème chaud — fond principal */
  --color-bg-secondary:  #EDE8DD;   /* Crème plus sombre — sections alternées */
  --color-bg-card:       #FDFAF5;   /* Presque blanc — cartes et panneaux */
  --color-bg-dark:       #1A1713;   /* Brun très sombre — sections sombres */

  /* Texte */
  --color-text-primary:  #1A1713;   /* Presque noir chaud — titres, corps */
  --color-text-secondary:#5C564E;   /* Gris-brun — sous-titres, métadonnées */
  --color-text-muted:    #9C9589;   /* Gris clair — labels, placeholders */
  --color-text-inverse:  #F2EDE3;   /* Crème — texte sur fond sombre */

  /* Accent */
  --color-accent:        #D97757;   /* Corail-terracotta — CTA, liens actifs */
  --color-accent-hover:  #C4663F;   /* Corail plus sombre — hover */
  --color-accent-light:  #F0D5C8;   /* Corail très clair — badges, tags */

  /* Bordures */
  --color-border:        #E0D9CE;   /* Beige — séparateurs, inputs */
  --color-border-strong: #C8BFB2;   /* Beige plus sombre — cartes avec relief */
}
```

### Usage par contexte

| Élément               | Couleur recommandée          |
|-----------------------|------------------------------|
| Background page       | `--color-bg-primary`         |
| Header / nav          | `--color-bg-primary`         |
| Footer                | `--color-bg-dark`            |
| Cartes                | `--color-bg-card`            |
| Bouton primaire       | `--color-accent`             |
| Bouton secondaire     | transparent + border         |
| Texte courant         | `--color-text-primary`       |
| Labels, dates         | `--color-text-secondary`     |
| Liens                 | `--color-accent`             |
| Bordures              | `--color-border`             |

---

## Typographie

### Pile de polices

```css
:root {
  --font-display: 'Tiempos Headline', 'Georgia', serif;
  --font-body:    'Söhne', 'DM Sans', 'Helvetica Neue', sans-serif;
  --font-mono:    'Söhne Mono', 'JetBrains Mono', monospace;
}
```

Si `Tiempos Headline` et `Söhne` ne sont pas disponibles, les meilleures alternatives Google Fonts sont :

```css
/* Alternative libre */
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500&family=JetBrains+Mono&display=swap');

:root {
  --font-display: 'DM Serif Display', serif;
  --font-body:    'DM Sans', sans-serif;
  --font-mono:    'JetBrains Mono', monospace;
}
```

### Échelle typographique

```css
/* Titres */
.text-hero    { font-size: clamp(2.5rem, 5vw, 4.5rem); font-family: var(--font-display); font-weight: 400; line-height: 1.1; letter-spacing: -0.02em; }
.text-h1      { font-size: clamp(2rem, 3.5vw, 3rem);   font-family: var(--font-display); font-weight: 400; line-height: 1.2; letter-spacing: -0.015em; }
.text-h2      { font-size: clamp(1.5rem, 2.5vw, 2rem); font-family: var(--font-display); font-weight: 400; line-height: 1.3; }
.text-h3      { font-size: 1.25rem;  font-family: var(--font-body);    font-weight: 500; line-height: 1.4; }

/* Corps */
.text-lead    { font-size: 1.125rem; font-weight: 300; line-height: 1.7; color: var(--color-text-secondary); }
.text-body    { font-size: 1rem;     font-weight: 400; line-height: 1.65; }
.text-small   { font-size: 0.875rem; font-weight: 400; line-height: 1.6; color: var(--color-text-secondary); }
.text-label   { font-size: 0.75rem;  font-weight: 500; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-text-muted); }
```

### Règles typographiques

- Les titres héros et H1 utilisent toujours la police serif, en poids normal (400) — pas bold.
- Les sous-titres et corps utilisent la police sans-serif en poids léger (300) ou normal (400).
- Le poids 500 est réservé aux labels, boutons, et éléments interactifs.
- Éviter le gras `font-weight: 700+` sauf pour les highlights ponctuels.
- Toujours utiliser `letter-spacing: -0.02em` sur les grands titres pour resserrer le texte.

---

## Espacement et Grille

### Variables d'espacement

```css
:root {
  --space-1:   0.25rem;   /*  4px */
  --space-2:   0.5rem;    /*  8px */
  --space-3:   0.75rem;   /* 12px */
  --space-4:   1rem;      /* 16px */
  --space-6:   1.5rem;    /* 24px */
  --space-8:   2rem;      /* 32px */
  --space-12:  3rem;      /* 48px */
  --space-16:  4rem;      /* 64px */
  --space-24:  6rem;      /* 96px */
  --space-32:  8rem;      /* 128px */
}
```

### Grille de mise en page

```css
.container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 var(--space-8);
}

.container--narrow {
  max-width: 720px;    /* Articles, textes longs */
}

.container--wide {
  max-width: 1400px;   /* Tableaux de bord, galeries */
}
```

### Sections

Chaque section de page doit avoir un padding vertical généreux :

```css
.section {
  padding: var(--space-24) 0;
}

.section--hero {
  padding: var(--space-32) 0;
}
```

---

## Composants

### Boutons

```css
/* Base */
.btn {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  padding: 0.625rem 1.25rem;
  border-radius: 6px;
  font-family: var(--font-body);
  font-size: 0.9375rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.15s ease;
  border: 1.5px solid transparent;
  text-decoration: none;
}

/* Primaire */
.btn--primary {
  background: var(--color-accent);
  color: #fff;
  border-color: var(--color-accent);
}
.btn--primary:hover {
  background: var(--color-accent-hover);
  border-color: var(--color-accent-hover);
}

/* Secondaire */
.btn--secondary {
  background: transparent;
  color: var(--color-text-primary);
  border-color: var(--color-border-strong);
}
.btn--secondary:hover {
  border-color: var(--color-text-primary);
}

/* Ghost (sur fond sombre) */
.btn--ghost {
  background: transparent;
  color: var(--color-text-inverse);
  border-color: rgba(242, 237, 227, 0.4);
}
.btn--ghost:hover {
  border-color: var(--color-text-inverse);
}
```

### Cartes

```css
.card {
  background: var(--color-bg-card);
  border: 1px solid var(--color-border);
  border-radius: 12px;
  padding: var(--space-8);
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
  border-color: var(--color-border-strong);
  box-shadow: 0 4px 24px rgba(26, 23, 19, 0.06);
}

/* Carte sombre */
.card--dark {
  background: rgba(255, 255, 255, 0.05);
  border-color: rgba(255, 255, 255, 0.1);
}
```

### Navigation (Header)

```css
.nav {
  position: sticky;
  top: 0;
  z-index: 100;
  background: var(--color-bg-primary);
  border-bottom: 1px solid var(--color-border);
  padding: var(--space-4) 0;
  backdrop-filter: blur(12px);
}

.nav__inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: var(--space-8);
}

.nav__logo {
  font-family: var(--font-body);
  font-size: 1rem;
  font-weight: 500;
  color: var(--color-text-primary);
  letter-spacing: -0.01em;
  text-decoration: none;
}

.nav__links {
  display: flex;
  align-items: center;
  gap: var(--space-6);
  list-style: none;
}

.nav__link {
  font-size: 0.9375rem;
  font-weight: 400;
  color: var(--color-text-secondary);
  text-decoration: none;
  transition: color 0.15s ease;
}

.nav__link:hover,
.nav__link--active {
  color: var(--color-text-primary);
}
```

### Inputs et Formulaires

```css
.input {
  width: 100%;
  padding: 0.625rem var(--space-4);
  background: var(--color-bg-card);
  border: 1.5px solid var(--color-border);
  border-radius: 8px;
  font-family: var(--font-body);
  font-size: 0.9375rem;
  color: var(--color-text-primary);
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
  outline: none;
}

.input::placeholder {
  color: var(--color-text-muted);
}

.input:focus {
  border-color: var(--color-accent);
  box-shadow: 0 0 0 3px var(--color-accent-light);
}

.label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--color-text-secondary);
  margin-bottom: var(--space-2);
}
```

### Tags et Badges

```css
.badge {
  display: inline-flex;
  align-items: center;
  padding: 0.25rem 0.625rem;
  border-radius: 100px;
  font-size: 0.75rem;
  font-weight: 500;
  letter-spacing: 0.02em;
}

.badge--accent {
  background: var(--color-accent-light);
  color: var(--color-accent-hover);
}

.badge--neutral {
  background: var(--color-bg-secondary);
  color: var(--color-text-secondary);
  border: 1px solid var(--color-border);
}
```

### Séparateurs

```css
.divider {
  border: none;
  border-top: 1px solid var(--color-border);
  margin: var(--space-12) 0;
}
```

---

## Motifs de Mise en Page

### Hero Section

Structure classique Anthropic : label + grand titre serif + sous-titre léger + deux boutons côte à côte.

```html
<section class="section--hero">
  <div class="container container--narrow" style="text-align: center;">
    <span class="badge badge--accent" style="margin-bottom: 1.5rem;">Nouveauté</span>
    <h1 class="text-hero">Le titre principal<br>sur deux lignes</h1>
    <p class="text-lead" style="margin: 1.5rem 0 2.5rem;">
      Un sous-titre descriptif, léger, qui donne envie de continuer.
      Deux phrases maximum.
    </p>
    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
      <a href="#" class="btn btn--primary">Action principale</a>
      <a href="#" class="btn btn--secondary">En savoir plus</a>
    </div>
  </div>
</section>
```

### Grille de Cartes 3 colonnes

```css
.grid-3 {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
}

@media (max-width: 768px) {
  .grid-3 { grid-template-columns: 1fr; }
}
```

### Section avec alternance de fond

```css
.section--alt {
  background: var(--color-bg-secondary);
}

.section--dark {
  background: var(--color-bg-dark);
  color: var(--color-text-inverse);
}
```

---

## Icônes et Visuels

- Utiliser des icônes de trait fin (`stroke-width: 1.5`) — jamais filled ni trop grasses.
- La bibliothèque recommandée est Lucide Icons (cohérente avec ce style).
- Taille standard : `20px` dans le corps, `24px` dans les titres de cartes.
- Couleur par défaut : `currentColor` pour hériter du contexte.

---

## Animations

Les animations Anthropic sont discrètes, fonctionnelles et rapides. Jamais ostentatoires.

```css
/* Durées standard */
:root {
  --duration-fast:   100ms;  /* Hover léger */
  --duration-normal: 200ms;  /* Apparition d'éléments */
  --duration-slow:   300ms;  /* Modales, drawers */
}

/* Transitions globales */
* {
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Apparition au scroll (classe ajoutée par JS) */
.fade-in {
  opacity: 0;
  transform: translateY(12px);
  transition: opacity 0.4s ease, transform 0.4s ease;
}

.fade-in.visible {
  opacity: 1;
  transform: translateY(0);
}
```

---

## Ce qu'il faut éviter

- Les dégradés violets ou bleu-violet sur fond blanc — cliché IA générique.
- Le `font-weight: 700` ou `800` sur les titres — trop agressif.
- Les ombres portées lourdes (`box-shadow: 0 20px 60px rgba(0,0,0,0.3)`) — trop dramatique.
- Les bordures arrondies excessives (`border-radius: 24px+` sur les cartes).
- Les animations longues ou les transitions en `ease-in` sur les éléments interactifs.
- Le blanc pur `#FFFFFF` comme fond de page — trop froid pour cette esthétique.
- Les polices génériques : Inter, Roboto, Open Sans.

---

## Checklist rapide

Avant de pousser une page, vérifier :

- [ ] Le fond utilise `--color-bg-primary` (crème), pas du blanc pur
- [ ] Les titres sont en serif, les corps en sans-serif
- [ ] Le bouton CTA principal est en corail `--color-accent`
- [ ] Les cartes ont un `border-radius: 12px` et une bordure `--color-border`
- [ ] Les icônes sont en trait fin (Lucide)
- [ ] Le contenu textuel a un `max-width: 720px` si c'est du texte long
- [ ] Les sections ont un padding vertical d'au moins `--space-16`
- [ ] Aucun violet, aucun dégradé flashy
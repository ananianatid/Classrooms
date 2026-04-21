<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Classrooms - DEFITECH')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500&family=JetBrains+Mono&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Fonds */
            --color-bg-primary:    #F2EDE3;
            --color-bg-secondary:  #EDE8DD;
            --color-bg-card:       #FDFAF5;
            --color-bg-dark:       #1A1713;

            /* Texte */
            --color-text-primary:  #1A1713;
            --color-text-secondary:#5C564E;
            --color-text-muted:    #9C9589;
            --color-text-inverse:  #F2EDE3;

            /* Accent */
            --color-accent:        #D97757;
            --color-accent-hover:  #C4663F;
            --color-accent-light:  #F0D5C8;

            /* Bordures */
            --color-border:        #E0D9CE;
            --color-border-strong: #C8BFB2;

            /* Espacement */
            --space-1:   0.25rem;
            --space-2:   0.5rem;
            --space-3:   0.75rem;
            --space-4:   1rem;
            --space-6:   1.5rem;
            --space-8:   2rem;
            --space-12:  3rem;
            --space-16:  4rem;
            --space-24:  6rem;

            /* Typographie */
            --font-display: 'DM Serif Display', serif;
            --font-body:    'DM Sans', sans-serif;
            --font-mono:    'JetBrains Mono', monospace;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background: var(--color-bg-primary);
            min-height: 100vh;
            color: var(--color-text-primary);
            line-height: 1.65;
        }

        header {
            background: var(--color-bg-primary);
            padding: var(--space-4) var(--space-8);
            border-bottom: 1px solid var(--color-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(12px);
        }

        header h1 {
            font-family: var(--font-body);
            font-size: 1rem;
            color: var(--color-text-primary);
            cursor: pointer;
            font-weight: 500;
            letter-spacing: -0.01em;
        }

        nav {
            display: flex;
            align-items: center;
            gap: var(--space-6);
        }

        nav a {
            text-decoration: none;
            color: var(--color-text-secondary);
            font-size: 0.9375rem;
            font-weight: 400;
            transition: color 0.15s ease;
        }

        nav a:hover,
        nav a.active {
            color: var(--color-text-primary);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: var(--space-12) var(--space-8);
        }

        .box {
            background: var(--color-bg-card);
            border-radius: 12px;
            padding: var(--space-8);
            border: 1px solid var(--color-border);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .box:hover {
            border-color: var(--color-border-strong);
        }

        .alert {
            padding: var(--space-4);
            margin-bottom: var(--space-4);
            border-radius: 8px;
            border-left: 4px solid;
            font-family: var(--font-body);
            font-size: 0.9375rem;
        }

        .alert-success {
            background: #E8F5E9;
            color: #2E7D32;
            border-left-color: #2E7D32;
        }

        .alert-error {
            background: #FFEBEE;
            color: #C62828;
            border-left-color: #C62828;
        }

        button, .btn {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: 0.625rem 1.25rem;
            background: var(--color-accent);
            color: #fff;
            border: 1.5px solid var(--color-accent);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            font-family: var(--font-body);
            font-size: 0.9375rem;
            font-weight: 500;
        }

        button:hover, .btn:hover {
            background: var(--color-accent-hover);
            border-color: var(--color-accent-hover);
        }

        .btn--secondary {
            background: transparent;
            color: var(--color-text-primary);
            border-color: var(--color-border-strong);
        }

        .btn--secondary:hover {
            border-color: var(--color-text-primary);
        }

        h1 {
            font-family: var(--font-display);
            font-size: clamp(1.75rem, 3vw, 2.5rem);
            font-weight: 400;
            line-height: 1.2;
            letter-spacing: -0.015em;
            color: var(--color-text-primary);
            margin-bottom: var(--space-2);
        }

        h2 {
            font-family: var(--font-body);
            font-size: 1.25rem;
            font-weight: 500;
            color: var(--color-text-primary);
        }

        p {
            color: var(--color-text-secondary);
            line-height: 1.7;
        }

        @yield('extra-styles')
    </style>
</head>
<body>
    <header>
        <a href="{{ route('semesters.index') }}" style="text-decoration: none;">
            <h1>DEFITECH CLASSROOMS</h1>
        </a>
        <nav>
            <a href="{{ route('semesters.index') }}" {{ request()->routeIs('semesters.*') ? 'class="active"' : '' }}>Semestres</a>
            <a href="{{ route('upload.form') }}" {{ request()->routeIs('upload.*') ? 'class="active"' : '' }}>Upload</a>
            <a href="{{ route('upload.history') }}" {{ request()->routeIs('upload.history') ? 'class="active"' : '' }}>Historique</a>
        </nav>
    </header>

    <div class="container">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-error">{{ $error }}</div>
            @endforeach
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>

@extends('layouts.app')

@section('title', 'Semestres - Classrooms')

@section('extra-styles')
    <style>
        .page-header {
            text-align: center;
            margin-bottom: var(--space-12);
        }

        .page-label {
            display: inline-flex;
            padding: 0.25rem 0.625rem;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.02em;
            background: var(--color-accent-light);
            color: var(--color-accent-hover);
            margin-bottom: var(--space-4);
        }

        .page-description {
            font-size: 1.125rem;
            font-weight: 300;
            color: var(--color-text-secondary);
            margin-top: var(--space-2);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: var(--space-6);
            margin-top: var(--space-8);
        }

        .semester-card {
            background: var(--color-bg-card);
            padding: var(--space-8);
            border-radius: 12px;
            border: 1px solid var(--color-border);
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            text-align: center;
            color: var(--color-text-primary);
        }

        .semester-card:hover {
            border-color: var(--color-border-strong);
            box-shadow: 0 4px 24px rgba(26, 23, 19, 0.06);
            transform: translateY(-2px);
        }

        .semester-card h2 {
            font-family: var(--font-display);
            font-size: 1.5rem;
            margin-bottom: var(--space-2);
            color: var(--color-text-primary);
            font-weight: 400;
        }

        .semester-card p {
            font-size: 0.9375rem;
            color: var(--color-text-secondary);
            font-weight: 400;
        }

        .empty-state {
            text-align: center;
            padding: var(--space-12);
            color: var(--color-text-muted);
        }

        .empty-state h2 {
            font-family: var(--font-body);
            color: var(--color-text-secondary);
            margin-bottom: var(--space-2);
        }

        .empty-state p {
            font-size: 0.9375rem;
        }

        .empty-state code {
            background: var(--color-bg-secondary);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-family: var(--font-mono);
            font-size: 0.875rem;
            color: var(--color-text-secondary);
        }
    </style>
@endsection

@section('content')
    <div class="box">
        <div class="page-header">
            <span class="page-label">Explorateur</span>
            <h1>Semestres Disponibles</h1>
            <p class="page-description">Sélectionnez un semestre pour explorer les matières et ressources</p>
        </div>

        @if (count($semesters) > 0)
            <div class="grid">
                @foreach ($semesters as $semester)
                    <a href="{{ route('semesters.show', $semester['name']) }}" class="semester-card">
                        <h2>{{ $semester['name'] }}</h2>
                        <p>{{ $semester['itemsCount'] }} matière(s)</p>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <h2>Aucun semestre trouvé</h2>
                <p>Assurez-vous que le dossier <code>storage/app/Semesters</code> est correctement structuré.</p>
            </div>
        @endif
    </div>
@endsection

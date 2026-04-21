@extends('layouts.app')

@section('title', $semester . ' - Classrooms')

@section('extra-styles')
    <style>
        .breadcrumb {
            display: flex;
            gap: var(--space-2);
            margin-bottom: var(--space-8);
            font-size: 0.875rem;
            color: var(--color-text-secondary);
            flex-wrap: wrap;
            align-items: center;
        }

        .breadcrumb a {
            color: var(--color-accent);
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .breadcrumb a:hover {
            color: var(--color-accent-hover);
            text-decoration: underline;
        }

        .breadcrumb span {
            color: var(--color-border-strong);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: var(--space-8);
            flex-wrap: wrap;
            gap: var(--space-4);
        }

        .section-title {
            font-family: var(--font-display);
            font-size: clamp(1.5rem, 2.5vw, 2rem);
            font-weight: 400;
            color: var(--color-text-primary);
        }

        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: var(--space-6);
            margin-top: var(--space-4);
        }

        .item-card {
            background: var(--color-bg-card);
            border: 1px solid var(--color-border);
            border-radius: 12px;
            padding: var(--space-6);
            text-align: center;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            color: var(--color-text-primary);
        }

        .item-card:hover {
            border-color: var(--color-border-strong);
            box-shadow: 0 4px 24px rgba(26, 23, 19, 0.06);
        }

        .item-icon {
            font-size: 2.5rem;
            margin-bottom: var(--space-3);
        }

        .item-name {
            font-family: var(--font-body);
            font-weight: 500;
            font-size: 0.9375rem;
            color: var(--color-text-primary);
            word-break: break-word;
            line-height: 1.4;
        }

        .item-meta {
            font-size: 0.8125rem;
            color: var(--color-text-muted);
            margin-top: var(--space-2);
            font-weight: 400;
        }

        .empty-state {
            text-align: center;
            padding: var(--space-12);
            color: var(--color-text-muted);
        }

        .empty-state p {
            font-size: 0.9375rem;
        }
    </style>
@endsection

@section('content')
    <div class="box">
        <div class="breadcrumb">
            <a href="{{ route('semesters.index') }}">Accueil</a>
            <span>/</span>
            <span>{{ $semester }}</span>
        </div>

        <div class="section-header">
            <h1 class="section-title">{{ $semester }}</h1>
            <a href="{{ route('semesters.index') }}" class="btn btn--secondary">← Retour</a>
        </div>

        @if (count($items) > 0)
            <div class="items-grid">
                @foreach ($items as $item)
                    @if ($item['type'] === 'directory')
                        <a href="{{ route('explorer.show', $item['encodedPath']) }}" class="item-card">
                            <div class="item-icon">{{ $item['icon'] }}</div>
                            <div class="item-name">{{ $item['name'] }}</div>
                            <div class="item-meta">{{ $item['itemsCount'] }} élément(s)</div>
                        </a>
                    @else
                        <a href="{{ route('download.file', $item['encodedPath']) }}" class="item-card" title="Télécharger">
                            <div class="item-icon">{{ $item['icon'] }}</div>
                            <div class="item-name">{{ substr($item['name'], 0, 20) }}{{ strlen($item['name']) > 20 ? '...' : '' }}</div>
                            <div class="item-meta">{{ $item['sizeFormatted'] }}</div>
                        </a>
                    @endif
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <p>📭 Ce semestre est vide</p>
            </div>
        @endif
    </div>
@endsection

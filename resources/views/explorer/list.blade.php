@extends('layouts.app')

@section('title', 'Explorateur de Fichiers - Classrooms')

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

        .controls {
            display: flex;
            gap: var(--space-4);
            margin-bottom: var(--space-8);
            flex-wrap: wrap;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: var(--space-4);
        }

        .items-table thead {
            border-bottom: 2px solid var(--color-border);
        }

        .items-table th {
            padding: var(--space-4) var(--space-4);
            text-align: left;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--color-text-muted);
        }

        .items-table td {
            padding: var(--space-4);
            border-bottom: 1px solid var(--color-border);
            font-size: 0.9375rem;
        }

        .items-table tbody tr {
            transition: background 0.15s ease;
        }

        .items-table tbody tr:hover {
            background: var(--color-bg-secondary);
        }

        .item-name {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            color: var(--color-accent);
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .item-name:hover {
            color: var(--color-accent-hover);
        }

        .item-icon {
            font-size: 1.25rem;
        }

        .item-name strong {
            font-weight: 500;
            color: var(--color-text-primary);
        }

        .download-folder-btn {
            background: #2E7D32;
            border-color: #2E7D32;
        }

        .download-folder-btn:hover {
            background: #1B5E20;
            border-color: #1B5E20;
        }

        .empty-state {
            text-align: center;
            padding: var(--space-12);
            color: var(--color-text-muted);
        }

        .empty-state p {
            font-size: 0.9375rem;
        }

        .text-secondary {
            color: var(--color-text-secondary);
        }
    </style>
@endsection

@section('content')
    <div class="box">
        @if ($breadcrumbs)
            <div class="breadcrumb">
                <a href="{{ route('semesters.index') }}">Accueil</a>
                <span>/</span>
                @foreach ($breadcrumbs as $crumb)
                    <a href="{{ route('explorer.show', $crumb['path']) }}">{{ $crumb['name'] }}</a>
                    @if (!$loop->last)
                        <span>/</span>
                    @endif
                @endforeach
            </div>
        @endif

        <div class="controls">
            @if ($parentPath)
                <a href="{{ route('explorer.show', $parentPath) }}" class="btn btn--secondary">← Dossier parent</a>
            @else
                <a href="{{ route('semesters.index') }}" class="btn btn--secondary">← Retour aux semestres</a>
            @endif

            @if (count($items) > 0 && $currentPath !== 'Semesters')
                <a href="{{ route('download.folder', $encodedPath) }}" class="btn download-folder-btn">📥 Télécharger en ZIP</a>
            @endif
        </div>

        @if (count($items) > 0)
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 50%;">Nom</th>
                        <th style="width: 25%;">Taille</th>
                        <th style="width: 25%;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                @if ($item['type'] === 'directory')
                                    <a href="{{ route('explorer.show', $item['encodedPath']) }}" class="item-name">
                                        <span class="item-icon">{{ $item['icon'] }}</span>
                                        <strong>{{ $item['name'] }}</strong>
                                    </a>
                                @else
                                    <a href="{{ route('download.file', $item['encodedPath']) }}" class="item-name">
                                        <span class="item-icon">{{ $item['icon'] }}</span>
                                        {{ $item['name'] }}
                                    </a>
                                @endif
                            </td>
                            <td class="text-secondary">
                                @if ($item['type'] === 'directory')
                                    {{ $item['itemsCount'] }} élément(s)
                                @else
                                    {{ $item['sizeFormatted'] }}
                                @endif
                            </td>
                            <td class="text-secondary">{{ $item['createdAtFormatted'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <p>📭 Ce dossier est vide</p>
            </div>
        @endif
    </div>
@endsection

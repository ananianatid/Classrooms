@extends('layouts.app')

@section('title', 'Historique des Uploads - Classrooms')

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

        .download-btn {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
    </style>
@endsection

@section('content')
    <div class="box">
        <div class="page-header">
            <span class="page-label">Fichiers</span>
            <h1>Historique des Uploads</h1>
            <p class="page-description">Retrouvez tous vos fichiers téléversés</p>
        </div>

        <div class="controls">
            <a href="{{ route('upload.form') }}" class="btn">📤 Nouveau fichier</a>
            <a href="{{ route('semesters.index') }}" class="btn btn--secondary">← Retour</a>
        </div>

        @if (count($items) > 0)
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 50%;">Nom</th>
                        <th style="width: 20%;">Taille</th>
                        <th style="width: 20%;">Date</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        @if ($item['type'] === 'file')
                            <tr>
                                <td>
                                    <a href="{{ route('download.file', $item['encodedPath']) }}" class="item-name">
                                        <span class="item-icon">{{ $item['icon'] }}</span>
                                        {{ $item['name'] }}
                                    </a>
                                </td>
                                <td class="text-secondary">{{ $item['sizeFormatted'] }}</td>
                                <td class="text-secondary">{{ $item['modifiedAtFormatted'] }}</td>
                                <td>
                                    <a href="{{ route('download.file', $item['encodedPath']) }}" class="download-btn btn btn--secondary">
                                        📥
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <p>📭 Aucun fichier uploadé pour le moment</p>
                <a href="{{ route('upload.form') }}" class="btn" style="margin-top: var(--space-4);">
                    📤 Uploader un fichier
                </a>
            </div>
        @endif
    </div>
@endsection

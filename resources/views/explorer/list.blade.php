@extends('layouts.app')

@section('title', 'Explorateur de Fichiers - Classrooms')

@section('extra-styles')
    <style>
        .breadcrumb {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            color: #666;
            flex-wrap: wrap;
        }

        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb span {
            color: #999;
        }

        .controls {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }

        .items-table thead {
            background: #f8f9fa;
            border-bottom: 2px solid #667eea;
        }

        .items-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #333;
        }

        .items-table td {
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .items-table tbody tr:hover {
            background: #f8f9fa;
        }

        .item-name {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s;
        }

        .item-name:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .item-icon {
            font-size: 1.5rem;
        }

        .file-download {
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s;
        }

        .file-download:hover {
            color: #764ba2;
        }

        .download-folder-btn {
            background: #28a745;
        }

        .download-folder-btn:hover {
            background: #218838;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #999;
        }
    </style>
@endsection

@section('content')
    <div class="box">
        @if ($breadcrumbs)
            <div class="breadcrumb">
                <a href="{{ route('semesters.index') }}">🏠 Accueil</a>
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
                <a href="{{ route('explorer.show', $parentPath) }}" class="btn">← Dossier parent</a>
            @else
                <a href="{{ route('semesters.index') }}" class="btn">← Retour aux semestres</a>
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
                                    <a href="{{ route('download.file', $item['encodedPath']) }}" class="item-name file-download">
                                        <span class="item-icon">{{ $item['icon'] }}</span>
                                        {{ $item['name'] }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if ($item['type'] === 'directory')
                                    {{ $item['itemsCount'] }} élément(s)
                                @else
                                    {{ $item['sizeFormatted'] }}
                                @endif
                            </td>
                            <td>{{ $item['createdAtFormatted'] }}</td>
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

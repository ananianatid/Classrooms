@extends('layouts.app')

@section('title', 'Historique des Uploads - Classrooms')

@section('extra-styles')
    <style>
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

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #999;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            margin-right: 0.5rem;
        }

        .delete-btn {
            background: #dc3545;
        }

        .delete-btn:hover {
            background: #c82333;
        }
    </style>
@endsection

@section('content')
    <div class="box">
        <h1>📋 Historique des Uploads</h1>

        <div class="controls">
            <a href="{{ route('upload.form') }}" class="btn">📤 Nouveau fichier</a>
            <a href="{{ route('semesters.index') }}" class="btn">← Retour</a>
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
                                <td>{{ $item['sizeFormatted'] }}</td>
                                <td>{{ $item['modifiedAtFormatted'] }}</td>
                                <td>
                                    <a href="{{ route('download.file', $item['encodedPath']) }}" class="action-btn btn">
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
                <a href="{{ route('upload.form') }}" class="btn" style="margin-top: 1rem;">
                    📤 Uploader un fichier
                </a>
            </div>
        @endif
    </div>
@endsection

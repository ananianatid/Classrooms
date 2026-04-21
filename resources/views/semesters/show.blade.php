@extends('layouts.app')

@section('title', $semester . ' - Classrooms')

@section('extra-styles')
    <style>
        .breadcrumb {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            color: #666;
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

        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .item-card {
            background: white;
            border: 2px solid #f0f0f0;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: #333;
        }

        .item-card:hover {
            border-color: #667eea;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
            transform: translateY(-3px);
        }

        .item-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .item-name {
            font-weight: 600;
            color: #333;
            word-break: break-word;
        }

        .item-meta {
            font-size: 0.8rem;
            color: #999;
            margin-top: 0.5rem;
        }

        .back-button {
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="box">
        <div class="back-button">
            <a href="{{ route('semesters.index') }}" class="btn">← Retour aux semestres</a>
        </div>

        <h1>📚 {{ $semester }}</h1>

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
            <div style="text-align: center; padding: 3rem; color: #999;">
                <p>📭 Ce semestre est vide</p>
            </div>
        @endif
    </div>
@endsection

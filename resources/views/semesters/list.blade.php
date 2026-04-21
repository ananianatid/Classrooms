@extends('layouts.app')

@section('title', 'Semestres - Classrooms')

@section('extra-styles')
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .semester-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
        }

        .semester-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }

        .semester-card h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .semester-card p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #999;
        }

        .empty-state h2 {
            color: #667eea;
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="box">
        <h1>📚 Semestres Disponibles</h1>
        <p style="color: #666; margin-top: 0.5rem;">Sélectionnez un semestre pour explorer les matières et ressources</p>

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

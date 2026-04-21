@extends('layouts.app')

@section('title', 'Upload un Fichier - Classrooms')

@section('extra-styles')
    <style>
        .upload-container {
            max-width: 640px;
            margin: 0 auto;
        }

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

        .form-group {
            margin-bottom: var(--space-6);
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--color-text-secondary);
            margin-bottom: var(--space-2);
        }

        .file-drop-zone {
            border: 2px dashed var(--color-border-strong);
            border-radius: 12px;
            padding: var(--space-8);
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            background: var(--color-bg-card);
        }

        .file-drop-zone:hover {
            background: var(--color-bg-secondary);
            border-color: var(--color-accent);
        }

        .file-drop-zone.active {
            background: var(--color-accent-light);
            border-color: var(--color-accent);
        }

        .file-drop-zone p {
            color: var(--color-text-primary);
            margin: var(--space-2) 0;
        }

        .file-drop-zone p strong {
            font-weight: 500;
        }

        .file-info {
            color: var(--color-text-muted);
            font-size: 0.875rem;
            margin-top: var(--space-3);
            font-family: var(--font-mono);
        }

        .submit-btn {
            width: 100%;
            padding: var(--space-4);
            font-size: 1rem;
            justify-content: center;
        }

        .info-box {
            background: var(--color-bg-secondary);
            border-left: 4px solid var(--color-accent);
            padding: var(--space-4);
            border-radius: 8px;
            margin-bottom: var(--space-8);
            color: var(--color-text-secondary);
        }

        .info-box strong {
            color: var(--color-text-primary);
            display: block;
            margin-bottom: var(--space-2);
        }

        .info-box small {
            color: var(--color-text-secondary);
            font-size: 0.875rem;
            line-height: 1.6;
        }

        .action-links {
            display: flex;
            gap: var(--space-4);
            margin-top: var(--space-6);
        }

        .action-links .btn {
            flex: 1;
            justify-content: center;
        }
    </style>
@endsection

@section('content')
    <div class="box upload-container">
        <div class="page-header">
            <span class="page-label">Fichier</span>
            <h1>Uploader un Fichier</h1>
            <p class="page-description">Ajoutez des documents à votre espace de stockage</p>
        </div>

        <div class="info-box">
            <strong>ℹ️ Informations</strong>
            <small>
                Taille maximum : 100 MB<br>
                Types acceptés : PDF, Office, Images, Vidéos, ZIP, Texte
            </small>
        </div>

        <form method="POST" action="{{ route('upload.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <div class="file-drop-zone" id="dropZone">
                    <p>📁 <strong>Glissez-déposez votre fichier ici</strong></p>
                    <p style="color: var(--color-text-muted);">ou</p>
                    <input type="file" name="file" id="fileInput" style="display: none;" required>
                    <button type="button" onclick="document.getElementById('fileInput').click()" class="btn btn--secondary">
                        Sélectionner un fichier
                    </button>
                    <div class="file-info" id="fileName">Aucun fichier sélectionné</div>
                </div>
            </div>

            <button type="submit" class="btn submit-btn">✅ Uploader</button>
        </form>

        <div class="action-links">
            <a href="{{ route('upload.history') }}" class="btn btn--secondary">
                📋 Voir l'historique
            </a>
            <a href="{{ route('semesters.index') }}" class="btn btn--secondary">
                ← Retour
            </a>
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const fileName = document.getElementById('fileName');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('active'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('active'), false);
        });

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            updateFileName();
        }

        fileInput.addEventListener('change', updateFileName);

        function updateFileName() {
            if (fileInput.files.length > 0) {
                fileName.textContent = '✅ ' + fileInput.files[0].name;
            } else {
                fileName.textContent = 'Aucun fichier sélectionné';
            }
        }
    </script>
@endsection

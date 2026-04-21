@extends('layouts.app')

@section('title', 'Upload un Fichier - Classrooms')

@section('extra-styles')
    <style>
        .upload-form {
            max-width: 600px;
            margin: 2rem auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .form-group input[type="file"],
        .form-group input[type="text"] {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #f0f0f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input[type="file"]:focus,
        .form-group input[type="text"]:focus {
            outline: none;
            border-color: #667eea;
        }

        .file-drop-zone {
            border: 2px dashed #667eea;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #f8f9ff;
        }

        .file-drop-zone:hover {
            background: #f0f1ff;
            border-color: #764ba2;
        }

        .file-drop-zone.active {
            background: #e8ebff;
            border-color: #764ba2;
        }

        .file-drop-zone p {
            color: #666;
            margin: 0.5rem 0;
        }

        .file-info {
            color: #999;
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            font-size: 1.1rem;
        }

        .info-box {
            background: #e8f4f8;
            border-left: 4px solid #667eea;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 2rem;
            color: #333;
        }

        .info-box strong {
            color: #667eea;
        }
    </style>
@endsection

@section('content')
    <div class="box upload-form">
        <h1>📤 Upload un Fichier</h1>

        <div class="info-box">
            <strong>ℹ️ Informations :</strong><br>
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
                    <p style="color: #999;">ou</p>
                    <input type="file" name="file" id="fileInput" style="display: none;" required>
                    <button type="button" onclick="document.getElementById('fileInput').click()" class="btn">
                        Sélectionner un fichier
                    </button>
                    <div class="file-info" id="fileName">Aucun fichier sélectionné</div>
                </div>
            </div>

            <button type="submit" class="btn submit-btn">✅ Uploader</button>
        </form>

        <a href="{{ route('upload.history') }}" class="btn" style="margin-top: 1rem; width: 100%; text-align: center;">
            📋 Voir l'historique des uploads
        </a>
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

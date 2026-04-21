<?php

namespace App\Http\Controllers;

use App\Services\FileSystemService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FileUploadController extends Controller
{
    protected $fileSystemService;

    public function __construct(FileSystemService $fileSystemService)
    {
        $this->fileSystemService = $fileSystemService;
    }

    /**
     * Affiche le formulaire d'upload
     */
    public function showForm(): View
    {
        return view('explorer.upload');
    }

    /**
     * Traite l'upload d'un fichier
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'file' => [
                'required',
                'file',
                'max:' . (100 * 1024), // 100 MB
                'mimes:pdf,docx,xlsx,pptx,jpg,jpeg,png,gif,mp4,zip,txt,csv',
            ],
        ], [
            'file.required' => 'Veuillez sélectionner un fichier',
            'file.file' => 'Le fichier est invalide',
            'file.max' => 'Le fichier ne doit pas dépasser 100 MB',
            'file.mimes' => 'Type de fichier non accepté',
        ]);

        try {
            $uploadDir = 'Upload';
            $this->fileSystemService->ensureDirectoryExists($uploadDir);

            $filename = $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs($uploadDir, $filename, 'local');

            return redirect()
                ->route('upload.form')
                ->with('success', "Fichier '{$filename}' uploadé avec succès !");
        } catch (\Exception $e) {
            return redirect()
                ->route('upload.form')
                ->with('error', 'Erreur lors de l\'upload : ' . $e->getMessage());
        }
    }

    /**
     * Affiche l'historique des uploads
     */
    public function history(): View
    {
        $uploadDir = 'Upload';
        $items = [];

        if ($this->fileSystemService->pathExists($uploadDir)) {
            $items = $this->fileSystemService->getDirectoryItems($uploadDir);
        }

        return view('explorer.upload-history', [
            'items' => $items,
            'currentPath' => $uploadDir,
        ]);
    }
}

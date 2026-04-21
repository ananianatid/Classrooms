<?php

namespace App\Http\Controllers;

use App\Services\FileSystemService;
use App\Services\ZipService;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileDownloadController extends Controller
{
    protected $fileSystemService;
    protected $zipService;

    public function __construct(
        FileSystemService $fileSystemService,
        ZipService $zipService
    ) {
        $this->fileSystemService = $fileSystemService;
        $this->zipService = $zipService;
    }

    /**
     * Télécharge un fichier unique
     */
    public function downloadFile(string $path): StreamedResponse|RedirectResponse
    {
        $decodedPath = base64_decode(urldecode($path));

        if (!$this->fileSystemService->pathExists($decodedPath)) {
            abort(404, 'Fichier non trouvé');
        }

        $fullPath = storage_path("app/{$decodedPath}");

        if (!is_file($fullPath)) {
            return redirect()->back()->with('error', 'Ce n\'est pas un fichier');
        }

        return response()->download($fullPath);
    }

    /**
     * Télécharge un dossier en ZIP
     */
    public function downloadFolder(string $path): StreamedResponse|RedirectResponse
    {
        $decodedPath = base64_decode(urldecode($path));

        if (!$this->fileSystemService->pathExists($decodedPath)) {
            abort(404, 'Dossier non trouvé');
        }

        $fullPath = storage_path("app/{$decodedPath}");

        if (!is_dir($fullPath)) {
            return redirect()->back()->with('error', 'Ce n\'est pas un dossier');
        }

        try {
            $folderName = basename($decodedPath);
            $zipPath = $this->zipService->createFromFolder($fullPath, $folderName);

            return response()->download($zipPath, "{$folderName}.zip", [
                'Content-Type' => 'application/zip',
            ])->deleteFileAfterSend();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du ZIP : ' . $e->getMessage());
        }
    }
}

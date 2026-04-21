<?php

namespace App\Http\Controllers;

use App\Services\FileSystemService;
use Illuminate\View\View;

class FileExplorerController extends Controller
{
    protected $fileSystemService;

    public function __construct(FileSystemService $fileSystemService)
    {
        $this->fileSystemService = $fileSystemService;
    }

    /**
     * Affiche le contenu d'un dossier
     */
    public function show(string $path = ''): View
    {
        $decodedPath = $path ? base64_decode(urldecode($path)) : 'Semesters';

        if (!$this->fileSystemService->pathExists($decodedPath)) {
            abort(404, 'Chemin non trouvé');
        }

        if (!is_dir(storage_path("app/{$decodedPath}"))) {
            abort(404, 'Ce n\'est pas un dossier');
        }

        $items = $this->fileSystemService->getDirectoryItems($decodedPath);
        $parentPath = $this->fileSystemService->getParentPath($decodedPath);
        $breadcrumbs = $this->fileSystemService->getBreadcrumbs($decodedPath);

        return view('explorer.list', [
            'items' => $items,
            'currentPath' => $decodedPath,
            'encodedPath' => urlencode(base64_encode($decodedPath)),
            'parentPath' => $parentPath ? urlencode(base64_encode($parentPath)) : null,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}

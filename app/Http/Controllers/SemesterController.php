<?php

namespace App\Http\Controllers;

use App\Services\FileSystemService;
use Illuminate\View\View;

class SemesterController extends Controller
{
    protected $fileSystemService;

    public function __construct(FileSystemService $fileSystemService)
    {
        $this->fileSystemService = $fileSystemService;
    }

    /**
     * Affiche la liste des semestres
     */
    public function index(): View
    {
        $semesters = $this->fileSystemService->getSemesters();

        return view('semesters.list', [
            'semesters' => $semesters,
        ]);
    }

    /**
     * Affiche les matières d'un semestre
     */
    public function show(string $semester): View
    {
        $path = "Semesters/{$semester}";

        if (!$this->fileSystemService->pathExists($path)) {
            abort(404, 'Semestre non trouvé');
        }

        $items = $this->fileSystemService->getDirectoryItems($path);

        return view('semesters.show', [
            'semester' => $semester,
            'items' => $items,
            'currentPath' => $path,
        ]);
    }
}

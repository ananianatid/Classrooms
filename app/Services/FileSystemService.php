<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileSystemService
{
    protected $disk = 'local';
    protected $baseStoragePath = 'app';

    /**
     * Récupère la liste des semestres
     */
    public function getSemesters(): array
    {
        $semesterDir = 'Semesters';
        $directories = [];

        if (!$this->pathExists($semesterDir)) {
            return [];
        }

        $items = $this->getDirectoryItems($semesterDir);

        return array_filter($items, fn($item) => $item['type'] === 'directory');
    }

    /**
     * Récupère le contenu d'un dossier
     */
    public function getDirectoryItems(string $path): array
    {
        $fullPath = storage_path("{$this->baseStoragePath}/{$path}");

        if (!is_dir($fullPath)) {
            return [];
        }

        $items = [];
        $files = scandir($fullPath);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = "{$path}/{$file}";
            $fullFilePath = "{$fullPath}/{$file}";

            $items[] = $this->getItemMetadata($filePath, $fullFilePath);
        }

        // Trier : dossiers en premier, puis alphabétique
        usort($items, function ($a, $b) {
            if ($a['type'] === 'directory' && $b['type'] !== 'directory') {
                return -1;
            }
            if ($a['type'] !== 'directory' && $b['type'] === 'directory') {
                return 1;
            }
            return strcmp($a['name'], $b['name']);
        });

        return $items;
    }

    /**
     * Récupère les métadonnées d'un élément
     */
    protected function getItemMetadata(string $path, string $fullPath): array
    {
        $isDir = is_dir($fullPath);
        $name = basename($path);
        $extension = !$isDir ? pathinfo($name, PATHINFO_EXTENSION) : null;

        return [
            'name' => $name,
            'path' => $path,
            'encodedPath' => urlencode(base64_encode($path)),
            'type' => $isDir ? 'directory' : 'file',
            'extension' => $extension,
            'size' => $isDir ? null : filesize($fullPath),
            'sizeFormatted' => $isDir ? null : $this->formatFileSize(filesize($fullPath)),
            'itemsCount' => $isDir ? count(array_diff(scandir($fullPath), ['.', '..'])) : null,
            'createdAt' => filectime($fullPath),
            'createdAtFormatted' => date('M d, Y', filectime($fullPath)),
            'modifiedAt' => filemtime($fullPath),
            'modifiedAtFormatted' => date('M d, Y H:i', filemtime($fullPath)),
            'icon' => $this->getIcon($extension, $isDir),
        ];
    }

    /**
     * Formate la taille de fichier
     */
    public function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Récupère l'icône pour un type de fichier
     */
    protected function getIcon(?string $extension, bool $isDir): string
    {
        if ($isDir) {
            return '📁';
        }

        $icons = [
            'pdf' => '📄',
            'doc' => '📝',
            'docx' => '📝',
            'xls' => '📊',
            'xlsx' => '📊',
            'ppt' => '📈',
            'pptx' => '📈',
            'jpg' => '🖼️',
            'jpeg' => '🖼️',
            'png' => '🖼️',
            'gif' => '🖼️',
            'mp4' => '🎬',
            'zip' => '🗜️',
            'txt' => '📄',
            'csv' => '📊',
        ];

        return $icons[strtolower($extension)] ?? '📎';
    }

    /**
     * Vérifie si un chemin existe
     */
    public function pathExists(string $path): bool
    {
        $fullPath = storage_path("{$this->baseStoragePath}/{$path}");
        return file_exists($fullPath);
    }

    /**
     * Assure qu'un répertoire existe
     */
    public function ensureDirectoryExists(string $path): void
    {
        $fullPath = storage_path("{$this->baseStoragePath}/{$path}");

        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
    }

    /**
     * Récupère le chemin parent
     */
    public function getParentPath(string $path): ?string
    {
        if ($path === 'Semesters' || $path === '') {
            return null;
        }

        $parent = dirname($path);
        return $parent === '.' ? null : $parent;
    }

    /**
     * Génère le fil d'Ariane (breadcrumbs)
     */
    public function getBreadcrumbs(string $path): array
    {
        $breadcrumbs = [];
        $parts = explode('/', trim($path, '/'));

        $current = '';
        foreach ($parts as $part) {
            $current .= ($current ? '/' : '') . $part;
            $breadcrumbs[] = [
                'name' => $part,
                'path' => urlencode(base64_encode($current)),
            ];
        }

        return $breadcrumbs;
    }

    /**
     * Supprime les fichiers plus vieux que X heures
     */
    public function deleteOldFiles(string $path, int $hours = 1): int
    {
        if (!$this->pathExists($path)) {
            return 0;
        }

        $fullPath = storage_path("{$this->baseStoragePath}/{$path}");
        $deleted = 0;
        $cutoffTime = time() - ($hours * 3600);

        $files = scandir($fullPath);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = "{$fullPath}/{$file}";

            if (is_file($filePath) && filemtime($filePath) < $cutoffTime) {
                if (unlink($filePath)) {
                    $deleted++;
                }
            }
        }

        return $deleted;
    }
}

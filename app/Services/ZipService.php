<?php

namespace App\Services;

use ZipArchive;

class ZipService
{
    /**
     * Crée une archive ZIP à partir d'un dossier
     */
    public function createFromFolder(string $sourceFolder, string $zipName): string
    {
        $zipPath = storage_path("app/temp/{$zipName}.zip");

        // Assurer que le répertoire temp existe
        $tempDir = dirname($zipPath);
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \Exception("Impossible de créer l'archive ZIP");
        }

        $this->addFolderToZip($sourceFolder, $zip, basename($sourceFolder));

        if (!$zip->close()) {
            throw new \Exception("Erreur lors de la fermeture du ZIP");
        }

        return $zipPath;
    }

    /**
     * Ajoute un dossier et son contenu à une archive ZIP
     */
    protected function addFolderToZip(string $folder, ZipArchive $zip, string $zipPath): void
    {
        $files = scandir($folder);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = "{$folder}/{$file}";
            $fullZipPath = "{$zipPath}/{$file}";

            if (is_dir($filePath)) {
                $zip->addEmptyDir($fullZipPath);
                $this->addFolderToZip($filePath, $zip, $fullZipPath);
            } else {
                $zip->addFile($filePath, $fullZipPath);
            }
        }
    }

    /**
     * Nettoie les anciens fichiers ZIP
     */
    public function cleanupOldZips(int $hours = 1): int
    {
        $tempDir = storage_path('app/temp');

        if (!is_dir($tempDir)) {
            return 0;
        }

        $deleted = 0;
        $cutoffTime = time() - ($hours * 3600);
        $files = scandir($tempDir);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = "{$tempDir}/{$file}";

            if (is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'zip') {
                if (filemtime($filePath) < $cutoffTime && unlink($filePath)) {
                    $deleted++;
                }
            }
        }

        return $deleted;
    }
}

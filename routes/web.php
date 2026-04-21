<?php

use App\Http\Controllers\SemesterController;
use App\Http\Controllers\FileExplorerController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\FileDownloadController;
use Illuminate\Support\Facades\Route;

/**
 * Pages principales
 */
Route::get('/', [SemesterController::class, 'index'])->name('semesters.index');
Route::get('/semesters/{semester}', [SemesterController::class, 'show'])->name('semesters.show');

/**
 * Explorateur de fichiers
 */
Route::get('/explorer/{path?}', [FileExplorerController::class, 'show'])
    ->name('explorer.show')
    ->where('path', '.*');

/**
 * Upload de fichiers
 */
Route::get('/upload', [FileUploadController::class, 'showForm'])->name('upload.form');
Route::post('/upload', [FileUploadController::class, 'store'])->name('upload.store');
Route::get('/upload-history', [FileUploadController::class, 'history'])->name('upload.history');

/**
 * Téléchargement de fichiers
 */
Route::get('/download/file/{path}', [FileDownloadController::class, 'downloadFile'])
    ->name('download.file')
    ->where('path', '.*');

Route::get('/download/folder/{path}', [FileDownloadController::class, 'downloadFolder'])
    ->name('download.folder')
    ->where('path', '.*');

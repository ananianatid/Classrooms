# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Laravel 13 application for managing classroom files organized by semesters. Provides file exploration, upload (up to 100MB), and download (including folder-to-ZIP) functionality.

## Commands

```bash
# Development (server + queue + logs + Vite)
composer run dev

# Run tests
composer run test
php artisan test                    # Run all tests
php artisan test --filter=name      # Run specific test

# Code style
php artisan pint                    # Format code
php artisan pint --test             # Check formatting

# Database
php artisan migrate                 # Run migrations
php artisan migrate:fresh --seed    # Fresh DB with seeds
```

## Architecture

### Services (Business Logic)
- `FileSystemService` - File/directory operations (scan, metadata, breadcrumbs, size formatting)
- `ZipService` - Create ZIP archives from folders, cleanup old archives

### Controllers
- `SemesterController` - List semesters and show semester contents
- `FileExplorerController` - Browse directories with navigation
- `FileUploadController` - Upload files and view history
- `FileDownloadController` - Download files or folders (as ZIP)

### Storage Structure
Files stored in `storage/app/`:
- `Semesters/` - Organized by semester (S1, S2, etc.)
- `Upload/` - Uploaded files

Uses SQLite for database (`database/database.sqlite`), database-backed sessions/cache/queue.

### Testing
Pest PHP framework. Tests in `tests/Feature/` and `tests/Unit/`. RefreshDatabase trait available for database tests.

<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

/**
 * Trait pour gérer les fichiers de manière sûre
 */
trait HasMedia
{
    /**
     * Supprimer un fichier de manière sûre
     */
    public function deleteFile(string $path): bool
    {
        if (Storage::exists($path)) {
            return Storage::delete($path);
        }
        return true;
    }

    /**
     * Obtenir l'URL complète du fichier
     */
    public function getFileUrl(string $path): string
    {
        return asset('storage/' . $path);
    }

    /**
     * Obtenir la taille formatée du fichier
     */
    public function sizeFormatted(): string
    {
        $bytes = $this->size ?? 0;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}

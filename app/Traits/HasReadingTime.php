<?php

namespace App\Traits;

/**
 * Trait pour calculer le temps de lecture estimé
 */
trait HasReadingTime
{
    /**
     * Calculer le temps de lecture en minutes
     * Basé sur 200 mots par minute en moyenne
     */
    public function calculateReadingTime(string $text): int
    {
        $wordCount = str_word_count(strip_tags($text));
        $minutesPerWord = 200;

        return max(1, (int) ceil($wordCount / $minutesPerWord));
    }

    /**
     * Formater le temps de lecture pour l'affichage
     */
    public function getReadingTimeFormatted(): string
    {
        if (!$this->reading_time) {
            return '< 1 min';
        }

        return $this->reading_time === 1
            ? '1 min'
            : "{$this->reading_time} mins";
    }
}

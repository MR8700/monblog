<?php

namespace App\Enums;

enum PostStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case SCHEDULED = 'scheduled';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Brouillon',
            self::PUBLISHED => 'Publié',
            self::SCHEDULED => 'Programmé',
            self::ARCHIVED => 'Archivé',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'gray',
            self::PUBLISHED => 'green',
            self::SCHEDULED => 'blue',
            self::ARCHIVED => 'red',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::DRAFT => 'fa-file-pen',
            self::PUBLISHED => 'fa-circle-check',
            self::SCHEDULED => 'fa-calendar',
            self::ARCHIVED => 'fa-box-archive',
        };
    }

    public static function options(): array
    {
        return array_map(fn ($case) => $case->label(), self::cases());
    }
}

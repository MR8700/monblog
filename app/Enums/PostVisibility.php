<?php

namespace App\Enums;

enum PostVisibility: string
{
    case PUBLIC = 'public';
    case PRIVATE = 'private';
    case HIDDEN = 'hidden';

    public function label(): string
    {
        return match ($this) {
            self::PUBLIC => 'Public',
            self::PRIVATE => 'Privé',
            self::HIDDEN => 'Caché',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::PUBLIC => 'Visible pour tous les utilisateurs',
            self::PRIVATE => 'Visible uniquement pour les utilisateurs connectés',
            self::HIDDEN => 'Masqué du public, visible uniquement aux admins',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PUBLIC => 'green',
            self::PRIVATE => 'yellow',
            self::HIDDEN => 'red',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::PUBLIC => 'fa-globe',
            self::PRIVATE => 'fa-lock',
            self::HIDDEN => 'fa-eye-slash',
        };
    }

    public static function options(): array
    {
        return array_map(fn ($case) => $case->label(), self::cases());
    }
}

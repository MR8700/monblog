<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * Trait pour gérer les slugs automatiquement
 */
trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->{$model->getSlugSourceColumn()});

                // Assurer l'unicité du slug
                $count = 1;
                $originalSlug = $model->slug;
                while (static::where('slug', $model->slug)->exists()) {
                    $model->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty($model->getSlugSourceColumn())) {
                $model->slug = Str::slug($model->{$model->getSlugSourceColumn()});

                // Assurer l'unicité du slug
                $count = 1;
                $originalSlug = $model->slug;
                while (static::where('slug', $model->slug)->where('id', '!=', $model->id)->exists()) {
                    $model->slug = "{$originalSlug}-{$count}";
                    $count++;
                }
            }
        });
    }

    protected function getSlugSourceColumn(): string
    {
        return 'name' ?? 'title';
    }
}

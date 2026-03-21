<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Events\PostPublished;
use App\Events\PostUpdated;
use App\Traits\HasReadingTime;

class CalculateReadingTime
{
    use HasReadingTime;

    /**
     * Calculer le temps de lecture et mettre à jour le post
     */
    public function handlePostCreated(PostCreated $event): void
    {
        if ($event->post->reading_time === null) {
            $event->post->update([
                'reading_time' => $this->calculateReadingTime($event->post->body),
            ]);
        }
    }

    public function handlePostUpdated(PostUpdated $event): void
    {
        if ($event->post->isDirty('body')) {
            $event->post->update([
                'reading_time' => $this->calculateReadingTime($event->post->body),
            ]);
        }
    }

    /**
     * Subscribe to the appropriate events.
     */
    public function subscribe($events): array
    {
        return [
            PostCreated::class => 'handlePostCreated',
            PostUpdated::class => 'handlePostUpdated',
        ];
    }
}

<?php

namespace App\Providers;

use App\Events\PostCreated;
use App\Events\PostPublished;
use App\Events\PostUpdated;
use App\Listeners\CalculateReadingTime;
use App\Models\Order;
use App\Models\PortfolioItem;
use App\Models\Post;
use App\Models\Product;
use App\Policies\OrderPolicy;
use App\Policies\PortfolioItemPolicy;
use App\Policies\PostPolicy;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Policies
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(PortfolioItem::class, PortfolioItemPolicy::class);

        // Register Events & Listeners
        Event::listen(
            [PostCreated::class, PostUpdated::class],
            CalculateReadingTime::class,
        );

        Event::listen(PostPublished::class, function (PostPublished $event) {
            // Vous pouvez ajouter d'autres actions ici comme l'envoi de notifications
            // Mail::to($event->post->admin->email)->send(new PostPublishedMail($event->post));
            // Notification::send($event->post->admin, new PostPublishedNotification($event->post));
        });
    }
}

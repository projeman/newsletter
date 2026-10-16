<?php

namespace Sesuva\Newsletter;

use Illuminate\Support\ServiceProvider;
use Sesuva\Newsletter\Repositories\SubscriberRepository;

class NewsletterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SubscriberRepository::class, function () {
            return new SubscriberRepository();
        });
    }

    public function boot(): void
    {
        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'sesuva-newsletter-migrations');

        $this->publishesFiles([
            __DIR__.'/../config/newsletter.php' => config_path('sesuva-newsletter.php'),
        ], 'sesuva-newsletter-config');
    }
}

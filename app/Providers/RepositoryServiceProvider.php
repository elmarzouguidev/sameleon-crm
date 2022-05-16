<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    private array $repositories = [

        [
            'abstract' => "App\Repositories\Admin\AdminInterface",
            'concrete' => "App\Repositories\Admin\AdminRepository"
        ],

        [
            'abstract' => "App\Repositories\Category\CategoryInterface",
            'concrete' => "App\Repositories\Category\CategoryRepository"
        ],
        [
            'abstract' => "App\Repositories\Client\ClientInterface",
            'concrete' => "App\Repositories\Client\ClientRepository"
        ],

        [
            'abstract' => "App\Repositories\Provider\ProviderInterface",
            'concrete' => "App\Repositories\Provider\ProviderRepository"
        ],
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $repo) {

            $this->app->bind(
                $repo['abstract'],
                $repo['concrete'],
            );
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

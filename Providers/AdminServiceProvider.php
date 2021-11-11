<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use TCG\Voyager\Facades\Voyager;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Admin';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'admin';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (!file_exists(base_path('.env')) && !file_exists(base_path('database/database.sqlite'))) {
            \File::put('database/database.sqlite','');
        }
        Voyager::addAction(\Modules\Admin\Http\Actions\Modules\InstallAction::class);
        Voyager::addAction(\Modules\Admin\Http\Actions\Modules\ModuleUpdateAction::class);
        Voyager::addFormField(\Modules\Admin\FormFields\CurrencyFormField::class);
        Voyager::addFormField(\Modules\Admin\FormFields\JsonFieldsFormField::class);
        $this->registerConfig();
        $this->app->register(RouteServiceProvider::class);

        // Setup config for User
        \Config::set('auth.providers.users.model', \Modules\Admin\Entities\User::class);

        $this->commands([
            \Modules\Admin\Console\AdminInstall::class,
        ]);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            // module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
            module_path($this->moduleName, 'Config/voyager.php') => config_path('voyager.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $viewPathFrontend = resource_path('views/vendor/voyager-frontend');
        $sourcePathFrontend = module_path($this->moduleName, 'Resources/views/vendor/voyager-frontend');

        $targetAssetPathFrontend = public_path('/');
        $sourceAssetPathFrontend = module_path($this->moduleName, 'Resources/assets/frontend');

        $viewPathVoyager = resource_path('views/vendor/voyager');
        $sourcePathVoyager = module_path($this->moduleName, 'Resources/views/vendor/voyager');

        $this->publishes([
            $sourcePathFrontend => $viewPathFrontend,
            $sourceAssetPathFrontend => $targetAssetPathFrontend,
            $sourcePathVoyager => $viewPathVoyager,
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        //Storage assets
        $sourceImg = module_path($this->moduleName, 'Resources/storage/app/public');
        $targetImg = storage_path('app/public');
        \File::copyDirectory($sourceImg, $targetImg);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}

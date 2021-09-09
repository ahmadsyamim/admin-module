<?php

namespace Modules\Admin\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Artisan;
use Dotenv\Dotenv;
use InvalidArgumentException;

class AdminInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:install {--dumpautoload}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $force = false;
        $dumpautoload = $this->option('dumpautoload');
        if (!$dumpautoload) {
            $force = true;
            \File::copy('.env.example', '.env');
            // ask user to setup env
            $configs = array(
                'APP_NAME' => "Laravel Admin",
                'APP_URL' => url("/"),
                'DB_CONNECTION' => 'mysql',
                'DB_HOST' => "127.0.0.1",
                'DB_PORT' => "3306",
                'DB_DATABASE' => "laravel_admin",
                'DB_USERNAME' => "root",
                'DB_PASSWORD' => "",
            );

            if (app()->environmentFilePath() != base_path('.env')) {
                \File::copy('.env.example', '.env.example.default');
            }

            foreach ($configs as $key => $config) {
                $input = '"'.$this->ask("Enter the value of {$key}", $config).'"';
                $this->putEnvFile($key, $input);
                if (app()->environmentFilePath() != base_path('.env')) {
                    $this->putEnvFile($key, $input, app()->environmentFilePath());
                }
            }
        } else if (file_exists(base_path('.env')) && $dumpautoload) {
            return 0;
        } else {
            // ask for force re-install?
            $force = $this->ask('This action will refresh/re-install whole database. Do you want to continue?', false);
        }
        if (!$force) { return 0; }
        Artisan::call("config:cache");
        Artisan::call('vendor:publish', ['--force' => true, '--provider' => 'Modules\Admin\Providers\AdminServiceProvider']);
        echo(Artisan::output());
        Artisan::call('migrate:fresh --seed');
        echo(Artisan::output());
        Artisan::call('module:migrate');
        echo(Artisan::output());
        Artisan::call('module:seed');
        echo(Artisan::output());
        Artisan::call("config:clear");
        Artisan::call("cache:clear");

        if (app()->environmentFilePath() != base_path('.env') && file_exists(base_path('.env.example.default'))) {
            \File::move('.env.example.default', '.env.example');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            //['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

    public function putEnvFile($key, $value, $path=false)
    {
        if (!$path) {
            $path = base_path('.env');
            // $path = app()->environmentFilePath();
        }

        $escaped = preg_quote('='.env($key), '/');

        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
}

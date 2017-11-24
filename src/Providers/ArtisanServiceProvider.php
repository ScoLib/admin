<?php

namespace Sco\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Sco\Admin\Console\ComponentMakeCommand;
use Sco\Admin\Console\InstallCommand;
use Sco\Admin\Console\ObserverMakeCommand;

class ArtisanServiceProvider extends ServiceProvider
{
    protected $defer = true;

    protected $commands = [
        'Install' => 'command.install',
        'ComponentMake' => 'command.component.make',
        'ObserverMake' => 'command.observer.make',
    ];

    public function register()
    {
        $this->registerCommands($this->commands);
    }

    /**
     * Register the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            call_user_func_array([$this, "register{$command}Command"], []);
        }

        $this->commands(array_values($commands));
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerInstallCommand()
    {
        $this->app->singleton('command.install', function ($app) {
            return new InstallCommand;
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerComponentMakeCommand()
    {
        $this->app->singleton('command.observer.make', function ($app) {
            return new ObserverMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerObserverMakeCommand()
    {
        $this->app->singleton('command.component.make', function ($app) {
            return new ComponentMakeCommand($app['files']);
        });
    }

    public function provides()
    {
        return array_values($this->commands);
    }
}

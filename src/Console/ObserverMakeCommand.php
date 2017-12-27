<?php

namespace Sco\Admin\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class ObserverMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:observer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new permission observer class(ScoAdmin)';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Observer';

    protected function getStub()
    {
        return __DIR__ . '/stubs/observer.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . $this->getComponentNamespace() . '\Observers';
    }

    protected function getComponentNamespace()
    {
        return str_replace(
            '/',
            '\\',
            Str::after(
                config('admin.components'),
                app_path() . DIRECTORY_SEPARATOR)
        );
    }
}

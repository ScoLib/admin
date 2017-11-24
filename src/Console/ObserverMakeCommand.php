<?php

namespace Sco\Admin\Console;

use Illuminate\Console\GeneratorCommand;

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
        return $rootNamespace . '\Observers';
    }
}

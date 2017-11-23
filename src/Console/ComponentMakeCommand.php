<?php

namespace Sco\Admin\Console;

use Illuminate\Console\GeneratorCommand;

class ComponentMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:component';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new component class(ScoAdmin)';

    protected $type = 'Component';

    protected function getStub()
    {
        return __DIR__.'/stubs/component.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Components';
    }
}

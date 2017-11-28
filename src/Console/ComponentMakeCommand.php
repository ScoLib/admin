<?php

namespace Sco\Admin\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ComponentMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:component';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new component class(ScoAdmin)';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Component';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false && !$this->option('force')) {
            return;
        }

        if ($this->option('observer')) {
            $this->createObserver();
        }
    }

    /**
     * Create a new permission observer for the component
     */
    protected function createObserver()
    {
        $this->call('make:observer', [
            'name' => $this->argument('name') . 'Observer',
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/component.stub';
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $observerClass = $this->laravel->getNamespace()
            . 'Observers\\'
            . $this->argument('name') . 'Observer';

        $observer = $this->option('observer')
            ? $observerClass
            : \Sco\Admin\Component\Observer::class;

        return str_replace(
            'DummyObserver', $observer, parent::buildClass($name)
        );
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Components';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            [
                'observer', 'o', InputOption::VALUE_NONE,
                'Create a new permission observer for the component',
            ],
            [
                'force', null, InputOption::VALUE_NONE,
                'Create the class even if the component already exists.',
            ],
        ];
    }
}

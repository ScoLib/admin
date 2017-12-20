<?php

namespace Sco\Admin\Console;

use Doctrine\DBAL\Schema\Column;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Sco\Admin\Facades\AdminElement;
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
        $observerClass = $this->parseClass($this->option('observer'));

        //$this->info('observer:' . $observerClass);

        $this->call('make:observer', [
            'name' => $observerClass,
        ]);
    }

    /**
     * Get the fully-qualified class name.
     *
     * @param string $class
     *
     * @return string
     */
    protected function parseClass($class)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $class)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $class = trim(str_replace('/', '\\', $class), '\\');

        if (!Str::startsWith($class, $rootNamespace = $this->laravel->getNamespace())) {
            $class = $rootNamespace . $class;
        }

        return $class;
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
        $observer = $this->option('observer')
            ? $this->parseClass($this->option('observer'))
            : \Sco\Admin\Component\Observer::class;

        $model = $this->option('model')
            ? $this->parseClass($this->option('model'))
            : '';

        $columns = $this->getViewColumns($model);
        // $elements = $this->getFormElements($model);


        return str_replace(
            ['DummyObserver', 'DummyModel', 'DummyColumns'],
            [$observer, $model, $columns],
            parent::buildClass($name)
        );
    }

    protected function getViewColumns($model)
    {
        $columns = $this->getTableColumns($model);
        if (!$columns) {
            return ;
        }

        $list    = [];
        foreach ($columns as $column) {
            $list[] = $this->buildColumn($column);
        }
        return implode("\n", $list);
    }

    protected function buildColumn(Column $column)
    {
        $title = $column->getComment() ?? camel_case($column->getName());

        return sprintf(
            "            AdminColumn::%s('%s', '%s'),",
            'text',
            $column->getName(),
            $title
        );
    }

    protected function getFormElements($model)
    {
        $columns = $this->getTableColumns($model);


    }

    protected function getTableColumns($class)
    {
        if (empty($class)) {
            return;
        }

        if (!class_exists($class)) {
            return;
        }

        $model = new $class();
        if (!($model instanceof Model)) {
            return;
        }
        $schema = $model->getConnection()->getDoctrineSchemaManager();

        $table = $model->getConnection()->getTablePrefix() . $model->getTable();

        return $schema->listTableColumns($table);
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
                'observer', 'o', InputOption::VALUE_OPTIONAL,
                'Generate a new access observer for the component.',
            ],
            [
                'force', null, InputOption::VALUE_NONE,
                'Generate the class even if the component already exists.',
            ],
            [
                'model', 'm', InputOption::VALUE_OPTIONAL,
                'Generate a model for the component.',
            ],
        ];
    }
}

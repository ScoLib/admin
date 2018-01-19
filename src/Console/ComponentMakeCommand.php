<?php

namespace Sco\Admin\Console;

use Doctrine\DBAL\Schema\Column;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use InvalidArgumentException;
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
    protected $description = 'Create a new component class(Sco-Admin)';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Component';

    protected $displayTypes = ['table', 'image', 'tree'];

    protected $columnTypeMappings = [
        'smallint' => 'text',
        'integer'  => 'text',
        'bigint'   => 'text',
        'float'    => 'text',
        'string'   => 'text',
        'text'     => 'text',
        'boolean'  => 'mapping',
        'datetime' => 'datetime',
        'date'     => 'datetime',
    ];

    protected $elementTypeMappings = [
        'smallint' => 'number',
        'integer'  => 'number',
        'bigint'   => 'number',
        'float'    => 'number',
        'string'   => 'text',
        'text'     => 'textarea',
        'boolean'  => 'elswitch',
        'datetime' => 'datetime',
        'date'     => 'date',
        'time'     => 'time',
    ];

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
        $replace = array_merge(
            ['DummyDisplayType' => $this->getDisplayType()],
            $this->buildObserverReplacements(),
            $this->buildModelReplacements()
        );

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name)
        );
    }

    protected function getDisplayType()
    {
        $type = $this->option('display');
        if (empty($type) || ! in_array($type, $this->displayTypes)) {
            $type = $this->choice(
                'What is Display type?',
                $this->displayTypes,
                0
            );
        }

        return $type;
    }

    protected function buildObserverReplacements()
    {
        if (! ($observer = $this->option('observer'))) {
            $observer = $this->anticipate(
                'What is the observer class name?',
                [
                    $class = $this->parseObserver($this->getNameInput())
                ],
                $class
            );
        }
        $observerClass = $this->parseObserver($observer);

        if (! class_exists($observerClass)) {
            if ($this->confirm(
                "A {$observerClass} observer does not exist. Do you want to generate it?",
                true
            )) {
                $this->call('make:observer', [
                    'name' => $observerClass,
                ]);
            }
        }

        return [
            'DummyFullObserverClass' => $observerClass,
            'DummyObserverClass'     => class_basename($observerClass),
        ];
    }

    /**
     * Get the fully-qualified observer class name.
     *
     * @param  string $observer
     *
     * @return string
     */
    protected function parseObserver($observer)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $observer)) {
            throw new InvalidArgumentException('Observer name contains invalid characters.');
        }

        $observer = rtrim(str_replace('/', '\\', $observer), 'Observer');

        if (! Str::startsWith($observer, [
            $rootNamespace = $this->laravel->getNamespace(),
            '\\'
        ])) {
            $observer = $rootNamespace . $this->getComponentNamespace()
                . '\Observers\\'
                . $observer . 'Observer';
        }

        return $observer;
    }

    protected function buildModelReplacements()
    {
        if (! ($model = $this->option('model'))) {
            $model = $this->anticipate(
                'What is the model class name?',
                [
                    $class = $this->parseModel($this->getNameInput())
                ],
                $class
            );
        }

        $modelClass = $this->parseModel($model);

        if (! class_exists($modelClass)) {
            if ($this->confirm(
                "A {$modelClass} model does not exist. Do you want to generate it?",
                true
            )) {
                $this->call('make:model', ['name' => $modelClass]);
            }
        }

        $columns = $this->getViewColumns($modelClass);
        $elements = $this->getFormElements($modelClass);

        return [
            'DummyFullModelClass' => $modelClass,
            'DummyColumns'        => $columns ? implode("\n", $columns) : '',
            'DummyElements'       => $elements ? implode("\n", $elements) : '',
        ];
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string $model
     *
     * @return string
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = str_replace('/', '\\', $model);

        if (! Str::startsWith($model, [
            $rootNamespace = $this->laravel->getNamespace(),
            '\\'
        ])) {
            $model = $rootNamespace . $model;
        }

        return $model;
    }

    protected function getViewColumns($model)
    {
        $columns = $this->getTableColumns($model);
        if (! $columns) {
            return;
        }

        $list = [];
        foreach ($columns as $column) {
            $list[] = $this->buildViewColumn($column);
        }

        return $list;
    }

    protected function buildViewColumn(Column $column)
    {
        return sprintf(
            "            AdminColumn::%s('%s', '%s'),",
            $this->getViewColumnType($column->getType()->getName()),
            $column->getName(),
            $this->getColumnTitle($column)
        );
    }

    protected function getColumnTitle(Column $column)
    {
        return $column->getComment() ?? studly_case($column->getName());
    }

    protected function getViewColumnType($name)
    {
        return $this->columnTypeMappings[$name] ?? 'text';
    }

    protected function getFormElements($model)
    {
        $columns = $this->getTableColumns($model);

        if (! $columns) {
            return;
        }

        $list = [];
        foreach ($columns as $column) {
            if (! $column->getAutoincrement()) {
                $list[] = $this->buildFormElement($column);
            }
        }

        return $list;
    }

    protected function buildFormElement(Column $column)
    {
        return sprintf(
            "            AdminElement::%s('%s', '%s')->required(),",
            $this->getFormElementType($column->getType()->getName()),
            $column->getName(),
            $this->getColumnTitle($column)
        );
    }

    protected function getFormElementType($name)
    {
        return $this->elementTypeMappings[$name] ?? 'text';
    }

    protected function getTableColumns($class)
    {
        if (empty($class)) {
            return;
        }

        if (! class_exists($class)) {
            return;
        }

        $model = new $class();
        if (! ($model instanceof Model)) {
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
        return $rootNamespace . '\\' . $this->getComponentNamespace();
    }

    /**
     *
     * @return string
     */
    protected function getComponentNamespace()
    {
        return str_replace(
            '/',
            '\\',
            Str::after(
                config('admin.components'),
                app_path() . DIRECTORY_SEPARATOR
            )
        );
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
                'observer',
                'o',
                InputOption::VALUE_OPTIONAL,
                'The access observer that should be assigned, and generate it if not exists.',
            ],
            [
                'model',
                'm',
                InputOption::VALUE_OPTIONAL,
                'The model that should be assigned, and generate it if not exists.',
            ],
            [
                'display',
                'd',
                InputOption::VALUE_OPTIONAL,
                'Choose a type of data display.',
                $this->displayTypes[0]
            ]
        ];
    }
}

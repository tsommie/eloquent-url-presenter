<?php

namespace AcDevelopers\EloquentUrlPresenter\LaravelLumen\Console\Commands;

use Illuminate\Console\GeneratorCommand as LaravelGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MakeUrlPresenterCommand
 *
 * @package AcDevelopers\EloquentUrlPresenter\Console\Commands
 */
class MakeUrlPresenterCommand extends LaravelGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:urlPresenter {name} {--model=} {--resource}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a url presenter class.';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('resource')) {
            return __DIR__.'/../stubs/resource.presenter.stub';
        }

        return __DIR__.'/../stubs/url.presenter.stub';
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $model = $this->option('model');

        if (! $model) {
            $model = $this->ask('Please Specify a model for this presenter');
        }

        return $model ? $this->replaceModel($stub, $model) : $stub;
    }

    /**
     * Replace the model for the given stub.
     *
     * @param  string  $stub
     * @param  string  $model
     * @return string
     */
    protected function replaceModel($stub, $model)
    {
        $model = str_replace('/', '\\', $model);

        $namespaceModel = config('eloquent-url-presenter.namespaces.model').$model;

        if (Str::startsWith($model, '\\')) {
            $stub = str_replace('NamespacedDummyModel', trim($model, '\\'), $stub);
        } else {
            $stub = str_replace('NamespacedDummyModel', $namespaceModel, $stub);
        }

        $stub = str_replace(
            "use {$namespaceModel};\nuse {$namespaceModel};", "use {$namespaceModel};", $stub
        );

        $model = class_basename(trim($model, '\\'));

        $dummyUser = class_basename(config('auth.providers.users.model'));

        $stub = str_replace('DocDummyModel', Str::snake($model, ' '), $stub);

        $stub = str_replace('DummyModel', $model, $stub);

        $stub = str_replace('dummyModel', Str::camel($model), $stub);

        $stub = str_replace('DummyUser', $dummyUser, $stub);

        return str_replace('DocDummyPluralModel', Str::snake(Str::plural($model), ' '), $stub);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return config('eloquent-url-presenter.namespaces.presenter'); // use config variables.
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the repository applies to.'],

            ['resource', 'r', InputOption::VALUE_NONE, 'Generate a resource controller class.'],
        ];
    }
}

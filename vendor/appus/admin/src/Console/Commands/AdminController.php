<?php

namespace Appus\Admin\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Container\Container;

class AdminController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:controller {controller} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating of controller for resource';

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
        $controller = $this->argument('controller');
        $model = $this->option('model');

        if (null === $model) {
            $this->error('Parameter "model" does not exist');
            exit;
        }

        if (!class_exists($model)) {
            $this->error('Model ' . $model . ' does not exist');
            exit;
        }

        $controllerName = $this->getClassName($controller);
        $controllerNamespace = $this->getClassNamespace($controller);

        $modelName = $this->getClassName($model);
        $modelNamespace = $this->getClassNamespace($model) . substr("\/", 0, 1) . $modelName;

        if (empty($controllerNamespace)) {
            $controllerNamespace = $this->getDefaultNamespace();
        }

        $namespace = Container::getInstance()->getNamespace();

        $file = $this->getFile();

        $file = str_replace([
            '{controller_namespace}',
            '{model_namespace}',
            '{controller_name}',
            '{model_name}'
        ], [
            $controllerNamespace,
            $modelNamespace,
            $controllerName,
            $modelName
        ], $file);

        $filePath = str_replace($namespace, '', $controllerNamespace);

        $filePath = app_path($filePath . substr("\/", 0, 1) . $controllerName . '.php');
        $filePath = str_replace(substr("\/", 0, 1), '/', $filePath);

        file_put_contents($filePath, $file);

        $this->info('Controller ' . $controller . ' added successfully.');
        $this->info('Add columns and fields for resource and add routes');

    }

    /**
     * @return string
     */
    protected function getFile(): string
    {
        return file_get_contents(__DIR__ . '/../Controller.stub');
    }

    /**
     * @return string
     */
    protected function getDefaultNamespace(): string
    {
        return "App\\Http\\Controllers";
    }

    /**
     * @param string $string
     * @return string
     */
    protected function getClassName(string $string): string
    {
        $string = explode(substr("\/", 0, 1), $string);
        return array_pop($string);
    }

    /**
     * @param string $string
     * @return string
     */
    protected function getClassNamespace(string $string): string
    {
        $string = explode(substr("\/", 0, 1), $string);
        array_pop($string);
        return implode(substr("\/", 0, 1), $string);
    }

}

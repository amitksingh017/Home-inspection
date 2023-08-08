<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 17.04.2020
 */

namespace Appus\Admin\Console\Commands;

use Appus\Admin\Table\Filters\DateRangeFilterAbstract;
use Appus\Admin\Table\Filters\MultiSelectFilterAbstract;
use Appus\Admin\Table\Filters\SelectFilterAbstract;
use Illuminate\Console\Command;
use Illuminate\Container\Container;


class AdminFilter extends Command
{

    protected $filters = [
        'select' => SelectFilterAbstract::class,
        'daterange' => DateRangeFilterAbstract::class,
        'multiselect' => MultiSelectFilterAbstract::class,
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:filter {type} {--class=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating of filters.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->description .= ' Available: ' . implode(', ', array_keys($this->filters));
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = $this->argument('type');

        if (empty($this->filters[$type])) {
            $this->error('Such filter type does not exist');
            exit;
        }

        $file = $this->getFile($type);

        $filter = $this->option('class');

        $filterName = $this->getClassName($filter);
        $filterNamespace = $this->getClassNamespace($filter);

        $parentFilterName = $this->getClassName($this->filters[$type]);
        $parentFilterNamespace = $this->getClassNamespace($this->filters[$type]) . substr("\/", 0, 1) . $parentFilterName;

        if (empty($filterNamespace)) {
            $filterNamespace = $this->getDefaultNamespace();
        }

        $file = str_replace([
            '{filter_namespace}',
            '{parent_filter_namespace}',
            '{filter_name}',
            '{parent_filter_name}'
        ], [
            $filterNamespace,
            $parentFilterNamespace,
            $filterName,
            $parentFilterName
        ], $file);

        $namespace = Container::getInstance()->getNamespace();

        $filePath = str_replace($namespace, '', $filterNamespace);
        $filePath = app_path($filePath);
        $this->createDir($filePath);
        $filePath .= substr("\/", 0, 1) . $filterName . '.php';
        $filePath = str_replace(substr("\/", 0, 1), '/', $filePath);

        file_put_contents($filePath, $file);

        $this->info('Filter ' . $filter . '  has been created successfully');
        $this->info('Add query and configured parameters');
    }

    /**
     * @return string
     */
    protected function getFile(string $type): string
    {
        $type = ucfirst($type);
        return file_get_contents(__DIR__ . "/../Filters/$type.stub");
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

    /**
     * @return string
     */
    protected function getDefaultNamespace(): string
    {
        return "App\\Filters";
    }

    /**
     * @param string $path
     */
    protected function createDir(string $path)
    {
        mkdir($path, 0755, true);
    }

}

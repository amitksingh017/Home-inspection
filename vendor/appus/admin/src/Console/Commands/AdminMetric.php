<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 17.04.2020
 */

namespace Appus\Admin\Console\Commands;

use Appus\Admin\Metrics\BarMetric;
use Appus\Admin\Metrics\CountMetric;
use Appus\Admin\Metrics\DonutMetric;
use Appus\Admin\Metrics\LineMetric;
use Appus\Admin\Metrics\ListMetric;
use Appus\Admin\Metrics\PieMetric;
use Appus\Admin\Metrics\ProgressMetric;
use Illuminate\Console\Command;
use Illuminate\Container\Container;

class AdminMetric extends Command
{

    protected $metrics = [
        'count' => CountMetric::class,
        'bar' => BarMetric::class,
        'donut' => DonutMetric::class,
        'line' => LineMetric::class,
        'list' => ListMetric::class,
        'pie' => PieMetric::class,
        'progress' => ProgressMetric::class,
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:metric {type} {--class=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating of metrics.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->description .= ' Available: ' . implode(', ', array_keys($this->metrics));
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

        if (empty($this->metrics[$type])) {
            $this->error('Such metric type does not exist');
            exit;
        }

        $file = $this->getFile($type);

        $metric = $this->option('class');

        $metricName = $this->getClassName($metric);
        $metricNamespace = $this->getClassNamespace($metric);

        $parentMetricName = $this->getClassName($this->metrics[$type]);
        $parentMetricNamespace = $this->getClassNamespace($this->metrics[$type]) . substr("\/", 0, 1) . $parentMetricName;

        if (empty($metricNamespace)) {
            $metricNamespace = $this->getDefaultNamespace();
        }

        $file = str_replace([
            '{metric_namespace}',
            '{parent_metric_namespace}',
            '{metric_name}',
            '{parent_metric_name}'
        ], [
            $metricNamespace,
            $parentMetricNamespace,
            $metricName,
            $parentMetricName
        ], $file);

        $namespace = Container::getInstance()->getNamespace();

        $filePath = str_replace($namespace, '', $metricNamespace);
        $filePath = app_path($filePath);
        $this->createDir($filePath);
        $filePath .= substr("\/", 0, 1) . $metricName . '.php';
        $filePath = str_replace(substr("\/", 0, 1), '/', $filePath);

        file_put_contents($filePath, $file);

        $this->info('Metric ' . $metric . '  has been created successfully');
        $this->info('Add data and configured parameters');
    }

    /**
     * @return string
     */
    protected function getFile(string $type): string
    {
        $type = ucfirst($type);
        return file_get_contents(__DIR__ . "/../Metrics/$type.stub");
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
        return "App\\Metrics";
    }

    /**
     * @param string $path
     */
    protected function createDir(string $path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

}

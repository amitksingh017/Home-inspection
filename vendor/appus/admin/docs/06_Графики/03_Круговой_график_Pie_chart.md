Необходимо наследовать класс от Appus\Admin\Metrics\PieMetric.

```php
namespace App\CustomMetrics;

use Appus\Admin\Metrics\PieMetric;

class UsersCategoryMetric extends PieMetric
{

    protected $width = 19;

    protected $name = 'Users Category';

    /**
     * @param array $filter
     * @return array
     */
    public function getData(array $filter = []): array
    {
        return [
            'Category1' => 1,
            'Category2' => 5
        ];
    }
    
    /**
     * @return array
     */
    public function filters(): array
    {
        return [
            new SelectFilter('Status', 'status', ['enabled' => 'Enabled', 'disabled' => 'Disabled']),
        ];
    }

}
```

Свойство ```$width``` такое же как и для метрики количества.
Свойство ```$name``` такое же как и для метрики количества.
Метод ```getData()``` возвращает массив значений для отображения в метрике и принимает аргумент ```$filter```, в котором передается массив из выбранных значений фильтра для метрики.
Метод ```filters()``` такой же как и для метрики количества.

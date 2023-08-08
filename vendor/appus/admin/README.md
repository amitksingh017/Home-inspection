# Appus Admin

```
    Для просмотра структурированной документации выполните команду

    php artisan admin:docs
```

### Installation

Добавьте в Ваш composer.json репозиторий:
```
"repositories": [
    {
        "type": "git",
        "url": "https://gitlab.appus.software/web/metronic-admin"
    }
],
```
и добавьте в конфигурация доступ в приватный репозиторий:
```
"config": {
    "gitlab-token": {
        "gitlab.appus.software": "your_personal_api_token"
    },
    "gitlab-domains": [
        "gitlab.appus.software"
    ]
}
```
Персональный API token можно сгенерировать перейдя в свои настройки Settings -> Access Tokens и в секции Personal Access Tokens поставьте галочку read_repository и сгенерируйте токен, который необходимо подставить вместо 'your_personal_api_token'
и затем установите библиотеку:
```
composer require appus/admin
```
Далее в консоли выполните команду или пропустите этот шаг и автоматизируйте этот процесс добавлением обработчиков событий описанных ниже в секции scripts
```
php artisan admin:install
```
это добавит в папку public стили и js-скрипты, а в папке config добавиться файл конфигурации ```admin.php```.
Для дальнейшей автоматизации обновления стилей и скриптов при обновлении пакета, необходимо в composer.json в scripts и в событие post-dump-autoload добавить удаление и переустановку стилей и скриптов пакета:
```json
{
    "scripts": {
        "post-autoload-dump": [
            "rm -rf ./public/vendor/admin",
            "php artisan admin:install"
        ]
    }
}
```

### Usage

Для создания контроллера выполните команду
```console
php artisan admin:controller App\\Http\\Controllers\\Admins\\UserController --model=App\\Models\\User
```
Это добавит контроллер, который наследуется от AdminController, в котором реализованы все CRUD методы для Вашего ресурса.
Вы можете переопределить эти методы в своем контроллере.

```php
class UserController extends AdminController
{

}
```

#### Relations

Все отношения для таблицы, детальной страницы и формы формируются в названии полей с перечислением через точку.
```php
$table->string('category.name', 'User Category'); // название категории пользователя

$table->string('articles.title', 'Articles'); // Все статьи пользователя
```
Для таблицы и детальной страницы доступны HasMany, HasOne, BelongsTo и BelongsToMany. Для формы только HasOne.
Для формы отдельным полем вынесено ИуlongsToMany (более подробно в разделе "Отношения" в формах).

#### Переопределение шаблонов

Для переопределения шаблонов нужно создать папку в папке представлений vendor/admin и в ней добавить представление с таким же названием шаблона, какой Вы хотите переопределить.
Например, для переопределения шаблона ```admin/themes/default/layouts/menu.blade.php``` необходимо добавить файл ```resources/views/vendor/admin/layouts/menu.blade.php```.

#### Menu

Для добавления пунктов меню необходимо создать файл (например, App/Menu/menu.php), а потом в config/admin.php в массив menu добавить путь к этому файлую
```php
    'menu' => [
        
        app_path('Menu/menu.php'),
        
    ],
```

После создания файла для добавления пункта меню необходимо вызвать метод add() из фасада Appus\Admin\Services\Menu\Facades\Menu или через алиас Menu:
```php
use Appus\Admin\Services\Menu\Facades\Menu;

Menu::add('Users');
```
Методы для настройки меню:

- add(string $name, bool $topMenu) - добавляет пункт меню. Если $topMenu передать true, то добавится пункт меню в header

- order(int $order) - устанавливает очередность пункта меню

- icon(string $classes) - устанавливает иконку для пункта меню и принимает класс flaticon или классы через пробел для fontawesome

- route(string $routeName, array $params, bool $absoluteUrl) - устанавливает ссылку для пункта меню

- sub(Closure $callback) - добавляет к пункту меню подпункты

- actions(array $actions) - можно добавить для отображения активного пункта меню список маршрутов, которые входят в этот ресурс. Поддерживаются названия контроллеров, названия экшенов, название ресурса или конкретного маршрута

- minimizeText(bool $value) - можно добавить текст внизу каждого элемента навигации, когда навигация свернута

- if(Closure $callback) - добавляет условие отрисовки пункта меню

```php
\Menu::add('Users', true)
    ->order(1)
    ->icon('flaticon-users-1')
    ->route('users.index')
    ->if(function () {
        return Auth::user()->isAdmin();
    })
    ->sub(function ($menu) {

        $menu->add('User Companies')
            ->icon('fas fa-building')
            ->route('companies.index');

    })->actions([
        App\Http\Controllers\UserController::class,
        'users.create',
        'users',
        'App\Http\Controllers\UserController@index'
    ])->minimizeText(true);
```

#### Cards

Для того, чтобы добавить еще один ресурс такого же типа, 
например на детальной странице ресурса добавить еще одну карточку с детальной информацией,
необходимо вызвать метод card(\Closure $callback), который принимает замыкание, аргументом которого является новый экземпляр ресурса и эта анонимная функция должна возвращать сконфигурированный ресурс.
Ресурс настраивается точно так же, как и и ресурс вне этого метода.

```php
$details->card(function ($card) {

    $card->string('title', 'Article Title');

    $card->string('description', 'Article Description');

}, Article::find(1))->width(49);
```
Метод ```width(int)``` определяет ширину карточки.

Для таблиц и форм катрочки добавляются точно таким же способом.

##### Карточка детальной страницы

Вы можете к таблице и к форме добавить карточку с детальной информацией.
Для этого необходимо вызвать метод detailsCard(\Closure $callback):
```php
$table->detailsCard(function ($card) {

    $card->string('title', 'Article Title');

    $card->string('description', 'Article Description');

}, Article::find(1))->width(49);
```
Для форм карточка с детальной информацией добавляется так же.

##### Карточка с таблицей

Вы можете на странице с детальной информацией и к форме добавить карточку с таблицей.
Для этого необходимо вызвать метод tableCard(\Closure $callback):
```php
$form->tableCard(function ($card) {

    $card->string('title', 'Article Title');

    $card->string('description', 'Article Description');

}, Article::find(1))->width(49);
```
Для страницы с детальной информацией карточка с таблицей добавляется так же.

#### Messages

Для уведомлений применяется фасад Appus\Admin\Messages\Facades\Message или алиас Message:
```php
use Appus\Admin\Messages\Facades\Message;

Message::success('This is success message');

Message::error('This is error message');

Message::warning('This is warning message');

Message::info('This is info message');

```

#### Кастомные стили и js-скрипты

Для того, чтобы глобально добавить свои стили и js-скрипты необходимо, например,
в сервис-провайдере добавить пути к файлам:

```php
use Appus\Admin\Services\Admin\Facades\Admin;

public function boot()
{
    Admin::css([
        '/css/main.css',
    ]);
    
    Admin::js([
        '/js/main.js',
    ]);
}
```

Для таблиц, детальных страниц и форм можно добавить свои стили и js-скрипты.
Для этого нужно в соответвующие метода добавить массив или анонимную функцию, которая возвращает массив:

```php
$table->css([
    '/css/style.css',
]);
$table->js(function () {
    return [
       '/js/main.js',
   ];
});
```


#### Table of items

Для построение таблицы с данными необходимо реализовать в Вашем контроллере метод grid(), который возвращает экземпляр класса Table.
Конструктор класса Table принимает экземпляр модели:

```php
public function grid(): Table
{
    $table = new Table(new UserModel());
    
    // конфигурация таблицы
    
    return $table;
}
```

или коллекцию элементов:

```php
public function grid(): Table
{
    $table = new Table(collect([
        [
            'name' => 'Name1',
            'email' => 'email1@mail.com'
        ],
        [
            'name' => 'Name2',
            'email' => 'email2@mail.com'
        ],
    ]));
    
    // конфигурация таблицы
    
    return $table;
}
```

##### Methods

- setTitle(string)
    
    Устанавливает значение верхнего заголовка

    ```php
    $table->setTitle('Users');
    ```

- setSubtitle(string)
    
    Устанавливает значение подзаголовка
    
    ```php
    $table->setSubtitle('List');
    ```
- ajax(bool)

    Устанавливает способ загрузки данных (в фоновом или не в фоновом режиме)
    
    ```php
    $table->ajax(true);
    ```

- with(array or string)

    Добавляет к основному запросу получение определенных связей

- itemPerPage(int)
    
    Устанавливает количество отображаемых строк на странице по умолчанию
    ```php
    $table->itemPerPage(10); // по умолчанию 10
    ```

- itemPerPageOptions(array)
    
    Устанавливает значения для выбора количества строк на странице в пагинации
    
    ```php
    $table->itemPerPageOptions([1, 2, 3, 4, 5]); // по умолчанию [10, 20, 50, 100, 500]
    ```
- viewAppend(string)
    
    Позволяет добавить кастомный шаблон перед основным контентом
    ```php
    $table->viewAppend('emails.list');
    ```
    
- viewPrepend(string)
    
    Позволяет добавить кастомный шаблон после основного контента
    ```php
    $table->viewPrepend('phones.list');
    ```
  
- defaultSort(string $field, string $direction = 'asc')
    
    Позволяет добавить сортировку по умолчанию
    ```php
    $table->defaultSort('created_at', 'desc');
    ```
    
- body(bool)
    
    Позволяет показать/скрыть основную таблицу с элементами
    ```php
    $table->body(false); // по умолчанию true
    ```
- query(Closure)

    Расширяет запрос выборки данных из базы данных
    
    ```php
    $table->query(function ($query) {
        $query->where('id', '>', 2);
    });
    ```
- card(Closure)
    
    Позволяет добавить еще одну таблицу с ресурсом,
    Более подоробно описано в разделе "Карточки".
    
- hideFilterToMenu(bool)
    
    Позволяет скрыть все фильтры в меню
    ```php
    $table->hideFilterToMenu(false); // по умолчанию true
    ```
  
- hideRowActionsToMenu(bool)
    
    Позволяет скрыть все строчные кнопки действия в меню
    ```php
    $table->hideRowActionsToMenu(true); // по умолчанию false
    ```

- hideTableActionsToMenu(bool)
    
    Позволяет скрыть все глобальные кнопки действия в меню
    ```php
    $table->hideTableActionsToMenu(true); // по умолчанию false
    ```
  
- hideMultiActionsToMenu(bool)
    
    Позволяет скрыть все кнопки мульти-действия в меню
    ```php
    $table->hideMultiActionsToMenu(true); // по умолчанию false
    ```
  
- hideMultiActionsWhenUnselected(bool)
    
    Позволяет скрыть все кнопки мульти-действия когда не выбраны галочки
    ```php
    $table->hideMultiActionsWhenUnselected(true); // по умолчанию false
    ```

##### Additional row and modal

Для добавления дополнительной строки необходимо добавить к любой колонке добавить метод addRow(\Closure $callback) анонимная функция которго возвращает экземпляр Table или Details.

```php
// Добавление категории для каждого пользователя
$table->column('field', 'Field')->displayAs(function () {
    return 'User info';
})->addRow(function ($model) {
    $categoriesModel = new UserCategory();
    $tableRow = new Table($categoriesModel);
    $tableRow->query(function ($query) use ($model) {
        $query->whereHas('users', function ($q1) use ($model) {
            $q1->where('user_id', $model->id);
        });
    });
    $tableRow->string('name');
    return $tableRow;
});
```

Для добавления модального окна необходимо добавить к любой колонке добавить метод AddModal(\Closure $callback) анонимная функция которго возвращает экземпляр Table или Details.

```php
// Добавление детальной страницы
$table->column('field', 'Field')->displayAs(function () {
    return 'User info';
})->addModal(function ($model) {
    $details = new Details($model);

    $details->field('name');
    $details->avatar('avatar');

    return $details;
});
```

##### Actions

Для автоматического определения маршрутов для CRUD для ресурса, ресурс должен быть во множественном числе.

- createAction(string|null)

    Позволяет кастомизировать кнопку для перехода на страницу добавления ресурса
    ```php
    $table->createAction('My Custom Add Button')
        ->name('My Custom Add Button')
        ->asView('users.create-button')
        ->route('users.create')
        ->field('id')
        ->params(['name' => 'Name']);
    ```
    
- viewAction(string|null)

    Позволяет кастомизировать кнопку для перехода на страницу просмотра ресурса
    ```php
    $table->viewAction('My Custom View Button');
    ```

- editAction(string|null)

    Позволяет кастомизировать кнопку для перехода на страницу редактирования ресурса
    ```php
    $table->editAction('My Custom Edit Button');
    ```
    
- deleteAction(string|null)

    Позволяет кастомизировать кнопку для перехода на страницу удаления ресурса
    ```php
    $table->deleteAction('My Custom Delete Button');
    ```

- customRowAction(string|null)
    
    Позволяет добавить строчную кнопку действия
    ```php
    $table->customRowAction('My Export Button');
    ```

- customTableAction(string|null)
    
    Позволяет добавить глобальную кнопку действия
    ```php
    $table->customTableAction('My Export Button');
    ```

Для кнопок действия доступны следующие методы:

- asHtml(string) - для отображения кнопки из текста

- asView(string) - для отображения кнопки из view-файла

- route(string) - для указанию ссылки на страницу, куда ведет кнопка действия

- field(string) - для указания поля для параметра ссылки

- params(array) - массив дополнительных параметров

- disabled(bool) - для отключения кнопки действия (по умолчанию false)

- cssClasses(string or array) - для добавления дополнительных css-классов

```php
$table->customRowAction()
      ->name('Export')
      ->asView('csv.export')
      ->route('csv.export')
      ->field('id')
      ->params(['name' => 'Name'])
      ->cssClasses(['custom-class']);
```

При использовании коллекций все action для CRUD необходимо определить.
Если в модели есть идентификатор id, то к каждому строчному действию добавится параметр data-id, который равен id.

##### Columns

- column(string, string)
    
    Добавляет колонку типа текст
    ```php
    $table->column('field_name', 'Display Name');
    ```
    
    Доступны общие методы для всех типов колонок:
    
    - valueAs(Closure) - переопределить значение колонки получаемое из базы данных
    - displayAs(Closure) - переопределить отображение значения колонки
    - searchable(bool) - добавить колонку в список критериев поиска (по умолчанию false)
    - sortable(bool) - добавить для колонки сортировку
    
    ```php
    $table->column('field_name', 'Display Name')->valueAs(function ($row) {
        return $row->first_name . ' ' . $row->last_name;
    })->searchable(true);
  
    $table->column('field_name', 'Display Name')->displayAs(function ($row) {
        return '<span>' . $row->name . '</span>';
    })->sortable(true);
    ```

- string(string, string)
    
    Добавляет колонку типа текст
    ```php
    $table->string('field_name', 'Display Name');
    ```
    
    Общие методы такие же, как и у column()

- image(string, string)
    
    Добавляет колонку для изображения
    ```php
    $table->image('field_name', 'Display Name');
    ```
    
    Общие методы такие же, как и у column().
    Дополнительные методы:
    
    - storage(string) - указывается хранилище (по умолчанию берется из настроек filesystems по умолчанию)
    - width(int) - указывается ширина для изображения (по умолчанию 100px)
    - height(int) - указывается высота для изображения
    - styles(array) - указывается массив для css аттрибутов
    
    ```php
    $table->image('image', 'Image')->styles([
        'border' => 'solid 1px #ccc'
    ])->width(36)
        ->height(36)
        ->storage('public');
    ```

- avatar(string, string)
    
    Добавляет колонку для аватарки
    ```php
    $table->avatar('avatar', 'Avatar');
    ```
    
    Общие методы такие же, как и у column().
    Дополнительные методы такие же, как и у image()

- status(string, string)
    
    Добавляет колонку для статуса
    ```php
    $table->status('status', 'Status');
    ```
    
    Общие методы такие же, как и у column().
    Дополнительные методы:
    
    - options(array) - добавляет опции для отображения цветов значений
    
    ```php
    $table->status('status', 'Status')->options([
        'new' => '#5867dd',
        'pending' => '#eee'
    ]);
    ```
    
- tag(string, string)
    
    Добавляет колонку для тегов
    ```php
    $table->tag('tags', 'Tags');
    ```
    
    Общие методы такие же, как и у column().
    Дополнительные методы:
    
    - delimiter(string) - указывается разделитель для тегов
    - color(string) - указывается цвет для заполнения тегов
    
    ```php
    $table->tag('tag', 'Tags')
      ->delimiter(',')
      ->color('#ccc');
    ```
  
- color(string, string)
    
    Добавляет колонку для отображения цветов
    ```php
    $table->color('color', 'Color');
    ```
    
    Общие методы такие же, как и у column().
    Дополнительные методы:
    
    - withText(bool) - добавляет отображение текста с hex-кодом цвета (по умолчанию false)
    
    ```php
    $table->color('color', 'Color')
      ->withText(true);
    ```

- dateTime(string, string)
    
    Добавляет колонку для отображения даты и времени
    ```php
    $table->dateTime('created_at', 'Registration Date');
    ```
    
    Общие методы такие же, как и у column().
    Дополнительные методы:
    
    - format(string) - изменяет формат даты (по умолчанию 'Y-m-d H:i:s'')
    
    ```php
    $table->dateTime('created_at', 'Registration Date')
      ->format('d.m.Y H:i:s');
    ```

##### Расширения

Для добавления своих кастомных колонок необходимо добавить класс-реализацию интерфейса Appus\Admin\Table\Columns\ColumnInterface или унаследовать от Appus\Admin\Table\Columns\ColumnAbstract:

```php
namespace App\Extensions\TableColumns;

use Appus\Admin\Table\Columns\ColumnAbstract;

class CustomNameColumn extends ColumnAbstract
{

    /**
     * @inheritDoc
     */
    public function getCellViewForString(string $value = null): ?string
    {
        return view('extensions.table-columns.custom-name-column')->with([
            'value' => $value,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getCellViewForArray(array $value = null): ?string
    {
        return implode("<br />", $value);
    }

}
```

и подключить с помощью фасада Appus\Admin\Extensions\Facades\TableColumnExtension в сервис провайдере с помощью метода extend:
```php
namespace App\Providers;

use Appus\Admin\Extensions\Facades\TableColumnExtension;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TableColumnExtension::extend('customNameColumn', \App\Extensions\TableColumns\CustomNameColumn::class);
    }
}
```

Первый аргумент метода - название метода колонки, второй - реализация кастомной колонки.
И в методе grid() Вашего контроллера можно добавить Вашу кастомную колонку:

```php
public function grid()
{
    $user = new User();
    $table = new Table($user);
    
    $table->customNameColumn('name', 'Name');
    
    return $table;
}
```

##### Filters

Для добавления фильтров применяется метод filters(Closure), который возвращает массив экземпляров фильтров

```php
$table->filters(function () {
    return [
        new \App\CustomFilters\EmailDomainFilter(),
    ];
});
```

Для создания фильтра выполните команду
```console
php artisan admin:filter type --class=App\\Filters\\MyFilter
```
где type, в зависимости от типа необходимого фильтра, принимает значения select, daterange

- выпадающий список для выбора одного значения

Необходимо наследовать от ```Appus\Admin\Table\Filters\SelectFilterAbstract```.

```php
namespace App\CustomFilters;

use Appus\Admin\Table\Filters\SelectFilterAbstract;

class EmailDomainFilter extends SelectFilterAbstract
{

    protected $name = 'Email Domain';

    protected $key = 'email';

    /**
     * @param $query
     * @param string $value
     * @return mixed
     */
    public function query($query, string $value)
    {
        return $query->where('email', 'like', "%@$value");
    }

    /**
     * @return array
     */
    public function options(): array
    {
        return [
            'gmail.com' => 'Gmail',
            'mail.com' => 'Mail',
        ];
    }
}
```

Свойство ```$name``` применяется для отображения названия фильтра.

Свойство ```$key``` применяется как уникальный ключ и является необязательным.

Метод query() добавляет запрос, когда фильтр выбран и принимает 2 аргумента: основной запрос ```$query``` и значение выбранного фильтра ```$value```.

Метод options() возвращает массив для значений фильтра.


- фильтр для временного периода

Необходимо наследовать от ```Appus\Admin\Table\Filters\DateRangeFilterAbstract```.

```php
namespace App\CustomFilters;

use Appus\Admin\Table\Filters\DateRangeFilterAbstract;

class RegistrationFilter extends DateRangeFilterAbstract
{

    protected $name = 'Registration';

    protected $key = 'registration';

    protected $format = 'YYYY-MM-DD';

    /**
     * @param $query
     * @param string $from
     * @param string $to
     * @return mixed
     */
    public function query($query, string $from, string $to)
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }

}
```

Свойство ```$name``` такое же, как и у фильтра выпадающего списка.

Свойство ```$key``` такое же, как и у фильтра выпадающего списка.

Свойство ```$format``` применяется для задания формата времени (по умолчанию, MM/DD/YYYY).

Метод query() добавляет запрос, когда фильтр выбран и принимает 3 аргумента: основной запрос ```$query``` и значения выбранного фильтра ```$from``` и ```$to```.

- выпадающий список для выбора нескольких значений

Необходимо наследовать от ```Appus\Admin\Table\Filters\SelectFilterAbstract```.

```php
namespace App\CustomFilters;

use Appus\Admin\Table\Filters\MultiSelectFilterAbstract;

class EmailDomainsFilter extends MultiSelectFilterAbstract
{

    protected $name = 'Email Domains';

    protected $key = 'emails';

    /**
     * @param $query
     * @param array $value
     * @return mixed
     */
    public function query($query, array $values)
    {
        $query->where(function ($q1) use ($values) {
            foreach ($values as $value) {
                $q1->orWhere('email', 'like', "%@$value");
            }
        });
        return $query;
    }

    /**
     * @return array
     */
    public function options(): array
    {
        return [
            'gmail.com' => 'Gmail',
            'mail.com' => 'Mail',
        ];
    }
}
```

Свойство ```$name``` такое же, как и у фильтра выпадающего списка.

Свойство ```$key``` такое же, как и у фильтра выпадающего списка.

Метод query() такой же, как и у фильтра выпадающего списка.

Метод options() такой же, как и у фильтра выпадающего списка.

##### Multi Actions

Для добавления мульти действий применяется метод multiActions(Closure), который возвращает массив экземпляров действий

```php
$table->multiActions(function () {
    return [
        new \App\CustomMultiActions\ExportMultiAction(),
    ];
});
```

Есть два типа мультидействий:

- кнопка

    Класс для мульти действий этого типа должен наследовать класс MultiActionAbstract:
    
```php
    namespace App\CustomMultiActions;
    
    use Appus\Admin\Table\MultiActions\MultiActionAbstract;
    use Illuminate\Support\Collection;
    
    class ExportMultiAction extends MultiActionAbstract
    {
    
        protected $name = 'Export';
        protected $icon = 'fas fa-export';
        protected $reloadPageAfterAction = true;
        protected $redirectUrl = '/admin';
        protected $jsFunctionNameCallback = 'exportData';
        protected $hideInfo = false;
        protected $hideIcon = false;
        protected $hideName = false;
        protected $confirmation = 'Are you sure?';
        protected $style = 'color: #0f0; background: #f00;';
        
        /**
        * @param Collection $collection
        * @return array|null
        */
        public function run(Collection $collection): ?array
        {
            $filePath = Pdf::createFile($collection->toArray());
            return ['filePath' => $filePath];
        }
    
    }
```

- выпадающий список

    Класс для мульти действий этого типа должен наследовать класс SelectMultiActionAbstract:
    
```php
    namespace App\CustomMultiActions;
    
    use Appus\Admin\Table\MultiActions\SelectMultiActionAbstract;
    use Illuminate\Support\Collection;
    
    class MultiCopyMultiAction extends SelectMultiActionAbstract
    {
    
        protected $name = 'Copy';
        protected $icon = 'fas fa-plus';
        protected $jsFunctionNameCallback = 'addRows';
    
        /**
         * @param Collection $collection
         * @param string|null $selected
         * @return array|null
         */
        public function run(Collection $collection, string $selected = null): ?array
        {
            $ids = $collection->pluck('id')->toArray();
    
            // some logic
    
            return ['ids' => $ids];
        }
    
        /**
         * @inheritDoc
         */
        public function options(): array
        {
            return [
                'one' => 'One',
                'many' => 'Many',
            ];
        }
    }
```

Свойство ```$name``` применяется для отображения названия мульти действия.

Свойство ```$hideInfo``` применяется для того, чтобы не показывать информацию (Selected или On This Page).

Свойство ```$hideIcon``` применяется для того, чтобы не показывать иконку для мульти-действия (Selected или On This Page).

Свойство ```$hideName``` применяется для того, чтобы не показывать имя мульти-действия (Selected или On This Page).

Свойство ```$confirmation``` применяется для окна подтверждения действия.

Свойство ```$style``` применяется для добавления кастомных стилей кнопки. Может быть строкой или массивом

Свойство ```$icon``` применяется для иконки для мульти действия.

Свойство ```$reloadPageAfterAction``` применяется, если после действия необходимо перезагрузить страницу.

Свойство ```$redirectUrl``` применяется, если после действия необходимо перейти на страницу.

Свойство ```$jsFunctionNameCallback``` применяется, если после действия необходимо выполнить js-функцию, которая должна принимать возращаемые методом run() данные.

Метод run() описывает логику действия и принимает 1 аргумент: $collection - коллекцию с отфильтрованными данными.

Во втором случае аргумент ```$selected``` соответствует ключу выбранного элемента.

Для того, чтобы не показывать multi actions нужно в метод multiActions() передать false.


```php
$table->multiActions(false);
```

Для того чтобы не показывать мульти-удаление, нужно вызвать метод disableMultiDelete():

```php
$table->disableMultiDelete();
```

##### Metrics

Все метрики одинаково работают для таблиц, детальных страниц и форм.
Для добавления метрик применяется метод metrics(Closure), который возвращает массив экземпляров метрик.
Для переопределения ширины в динамическом режиме для разных контроллеров можно вызвать метод width(int $value). 

```php
$table->metrics(function () {
    return [
        (new \App\CustomMetrics\UserCountMetric())->width(50),
    ];
});
```

- метрика количества

Необходимо наследовать класс от Appus\Admin\Metrics\CountMetric.

```php
namespace App\CustomMetrics;

use Appus\Admin\Metrics\CountMetric;
use Appus\Admin\Metrics\Filters\SelectFilter;
use App\User;

class UserCountMetric extends CountMetric
{

    protected $width = 15;

    protected $name = 'Users Count';

    /**
     * @param array $filter
     * @return int
     */
    public function getCount(array $filter = []): int
    {
        $userModel = app(User::class);
        $query = $userModel->newQuery();
        if (!empty($filter['status'])) {
            $query->where('status', $filter['status']);
        }
        return $query->count();
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

Свойство ```$width``` определяет ширину метрики и является необязательным (по умолчанию 20).
Свойство ```$name``` применяется для отображения названия метрики и так же является необязательным (по умолчанию формируется из названия класса).
Метод ```getCount()``` возвращает значение количества для отображения в метрике и принимает аргумент ```$filter```, в котором передается массив из выбранных значений фильтра для метрики.
Метод ```filters()``` необходим если в метрике нужны фильтры и возвращает массив экземпляров фильтров.

- круговая метрика 'pie chart'

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

- круговая метрика 'donut chart'

Необходимо наследовать класс от Appus\Admin\Metrics\DonutMetric.
Конфигурация такая же как и у pie chart

- линейная метрика 'line chart'

Необходимо наследовать класс от Appus\Admin\Metrics\LineMetric.
Конфигурация такая же как и у pie chart

- линейная метрика 'bar chart'

Необходимо наследовать класс от Appus\Admin\Metrics\BarMetric.
Конфигурация такая же как и у pie chart

- метрика прогресса

Необходимо наследовать класс от Appus\Admin\Metrics\ProgressMetric.

Для отображения нескольких прогресс-баров необходимо в методе getData() вернуть массив значений,
в свойствах $color и $label тоже вернуть массив соответствующих значений.

Для того, чтобы не отображать label необходимо вернуть null.

```php
namespace App\CustomMetrics;

use Appus\Admin\Metrics\ProgressMetric;

class MonthlyProgressMetric extends ProgressMetric
{

    protected $width = 30;

    protected $name = 'Monthly Progress';

    protected $color = [
        '#0f0',
        '#00f',
    ];

    protected $label = [
        'Users registered',
        'Users updated',
    ];

    /**
     * @param array $filter
     * @return mixed
     */
    public function getData(array $filter = [])
    {
        return [55, 25];
    }

}
```

Свойство ```$width``` такое же как и для метрики количества.
Свойство ```$name``` такое же как и для метрики количества.
Свойство ```$color``` задает цвет для прогресс-бара.
Свойство ```$label``` задает label для прогресс-бара.
Метод ```getData()``` возвращает массив значений для отображения в метрике и принимает аргумент ```$filter```, в котором передается массив из выбранных значений фильтра для метрики.
Метод ```filters()``` такой же как и для метрики количества.

- метрика-список

Необходимо наследовать класс от Appus\Admin\Metrics\ListMetric.

Для отображения шапки необходимо добавить в свойство ```$header``` строку или массив с названиями.


```php
namespace App\CustomMetrics;

use Appus\Admin\Metrics\ListMetric;

class NewUsersMetric extends ListMetric
{

    protected $width = 30;

    protected $name = 'New Users';

    protected $header = ['Name', 'Email'];

    /**
     * @param array $filter
     * @return mixed
     */
    public function getData(array $filter = []): array
    {
        return [
            ['John', 'john@mail.com'],
            ['James', 'james@mail.com'],
        ];
    }

}
```

Свойство ```$width``` такое же как и для метрики количества.
Свойство ```$name``` такое же как и для метрики количества.
Свойство ```$header``` задает названия столбцов в списке.
Метод ```getData()``` возвращает массив значений для отображения в метрике и принимает аргумент ```$filter```, в котором передается массив из выбранных значений фильтра для метрики.
Метод ```filters()``` такой же как и для метрики количества.

##### Фильтры для метрик

- выпадающий список

```php
new SelectFilter(string $filterName, string $filterKey, array $options)
```

Конструктор принимает три аргумента: название фильтра, ключ фильтра и массив опций фильтра.

#### Details page

Для построения детальной страницы ресурса необходимо реализовать в Вашем контроллере метод details(), который возвращает экземпляр класса Details.

```php
public function details(): Details
{
    $details = new Details(new User());
    
    // конфигурация детальной страницы

    return $details;
}
```

##### Methods

- setTitle(string)

    Устанавливает заголовок для страницы
    
- model()

    Возвращает текущую модель с данными

- body(bool)
    
    Позволяет показать/скрыть основной контент с элементами
    ```php
    $details->body(false); // по умолчанию true
    ```

- viewAppend(string)
    
    Позволяет добавить кастомный шаблон перед основным контентом
    ```php
    $details->viewAppend('emails.list');
    ```
 
- viewPrepend(string)
    
    Позволяет добавить кастомный шаблон после основного контента
    ```php
    $details->viewPrepend('phones.list');
    ```

- column(Closure)

    Позволяет сгруппировать поля по колонкам для отображения

    ```php
    $details->column(function ($column) {
        $column->field('name', 'Name');
        $column->string('email', 'Email');
    })->width(50);
    ```
    Метод width(int) определяет ширину колонки.

- card(Closure)

    Позволяет добавить еще одну карточку с детальной информацией
    Более подоробно описано в разделе "Карточки".

##### Fields

- field(string, string)

    Добавляет поле типа текст
    
    ```php
    $details->field('field_name', 'Display Name');
    ```
    
    Доступны общие методы для всех типов колонок:
    
    - valueAs(Closure) - переопределить значение колонки получаемое из базы данных
    - displayAs(Closure) - переопределить отображение значения колонки
    
    ```php
    $details->field('field_name', 'Display Name')->valueAs(function ($row) {
        return $row->first_name . ' ' . $row->last_name;
    });
    
    $details->field('field_name', 'Display Name')->displayAs(function ($row) {
        return '<span>' . $row->name . '</span>';
    });
    ```
- string(string, string)
    
    Добавляет колонку типа текст
    ```php
    $details->string('field_name', 'Display Name');
    ```
    
    Общие методы такие же, как и у field()
    
- file(string, string)
    
    Добавляет поле файл
    ```php
    $details->file('field_name', 'Display Name');
    ```
    Общие методы такие же, как и у column(). Дополнительные методы:
    - absoluteUrl(bool) - формирует ссылку на файл как абсолютный путь (по умолчанию false)
    - displayWithUrl(bool) - отображает ссылку на файл (по умолчанию false)
    - download(true) - отображает кнопку для скачивания файла (по умолчанию true)
    ```php
    $details->file('doc', 'Document')
      ->absoluteUrl(true)
      ->displayWithUrl(true)
      ->download(false);
    ```

- image(string, string)

    Добавляет поле с картинкой
    
    ```php
    $details->image('field_name', 'Display Name');
    ```
  
    Общие методы такие же, как и у column(). Дополнительные методы такие же, как и у file(). Есть еще настройки стилей картинки:
    
    - styles(array) - указывается массив для css аттрибутов
    
    - hideLabel(bool) - позволяет не показывать label (по умолчанию false)
    
    ```php
    $details->image('image', 'Image')
      ->styles([
          'border' => 'solid 1px #ccc'
      ]);
    ```
  
- avatar(string, string)

    Добавляет поле с аватаркой
    ```php
    $details->avatar('field_name', 'Display Name');
    ```
    Общие методы такие же, как и у column(). Дополнительные методы такие же, как и у file() и image().
    ```php
    $details->avatar('image', 'Image')
      ->styles([
          'border' => 'solid 1px #ccc'
      ]);
    ```
  
- url(string, string)

    Добавляет поле со ссылкой
    ```php
    $details->url('web_site', 'Web Site');
    ```
    Общие методы такие же, как и у column().

- color(string, string)
    
    Добавляет поле для отображения цветов
    ```php
    $details->color('color', 'Color');
    ```
    
    Общие методы такие же, как и у field().
    Дополнительные методы:
    
    - withText(bool) - добавляет отображение текста с hex-кодом цвета (по умолчанию false)
    
    ```php
    $details->color('color', 'Color')
      ->withText(true);
    ```

- dateTime(string, string)
    
    Добавляет поле для отображения даты и времени
    ```php
    $details->dateTime('created_at', 'Registration Date');
    ```
    
    Общие методы такие же, как и у field().
    Дополнительные методы:
    
    - format(string) - изменяет формат даты (по умолчанию 'Y-m-d H:i:s'')
    
    ```php
    $details->dateTime('created_at', 'Registration Date')
      ->format('d.m.Y H:i:s');
    ```

##### Расширения

Для добавления своих кастомных полей необходимо добавить класс-реализацию интерфейса Appus\Admin\Fields\FieldInterface или унаследовать от Appus\Admin\Fields\FieldAbstract:

```php
namespace App\Extensions\DetailsFields;

use Appus\Admin\Fields\FieldAbstract;

class CustomNameField extends FieldAbstract
{

    /**
     * @inheritDoc
     */
    public function getRowViewForString(string $value = null): ?string
    {
        return view('extensions.details-fields.custom-name-field')->with([
            'value' => $value,
            'name' => $this->name,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getRowViewForArray(array $value = null): ?string
    {
        return null;
    }

}
```

и подключить с помощью фасада Appus\Admin\Extensions\Facades\DetailsFieldExtension в сервис провайдере с помощью метода extend:
```php
namespace App\Providers;

use Appus\Admin\Extensions\Facades\DetailsFieldExtension;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DetailsFieldExtension::extend('customNameField', \App\Extensions\DetailsFields\CustomNameField::class);
    }
}
```

Первый аргумент метода - название метода поля, второй - реализация кастомного поля.
И в методе details() Вашего контроллера можно добавить Ваше кастомное поле:

```php
public function details()
{
    $details = new Details(new User());
    
    $details->customNameField('name', 'Name');
    
    return $details;
}
```

##### Metrics

Метрика такая же, как и для Table.

#### Forms

Для построения формы необходимо реализовать в Вашем контроллере метод form(), который возвращает экземпляр класса Form.

```php
public function form(): Form
{
    $form = new Form(new User());
    
    // конфигурация формы

    return $form;
}
```

##### Methods

- setTitle(string)

    Устанавливает заголовок для страницы

- model()

    Возвращает текущую модель с данными

- ajax(bool)
    
    Устанавливает способ загрузки данных (в фоновом или не в фоновом режиме)

- body(bool)
    
    Позволяет показать/скрыть основной контент с элементами
    ```php
    $form->body(false); // по умолчанию true
    ```

- viewAppend(string)
    
    Позволяет добавить кастомный шаблон перед основным контентом
    ```php
    $form->viewAppend('emails.list');
    ```
 
- viewPrepend(string)
    
    Позволяет добавить кастомный шаблон после основного контента
    ```php
    $form->viewPrepend('phones.list');
    ```
  
- column(Closure)

    Позволяет сгруппировать поля по колонкам для отображения

    ```php
    $form->column(function ($column) {
        $column->field('name', 'Name');
        $column->string('email', 'Email');
    })->width(50);
    ```
    Метод width(int) определяет ширину колонки.
    
- storeRoute(string, array)

    Определяет route для store, по умолчания определяется, как для resource

    ```php
    $form->storeRoute('users.store', ['category_id' => 1])
        ->asAbsoluteUrl(false)
        ->method('post');
    ```
    Метод asAbsoluteUrl(bool) определяет является Ваш параметр маршрутом или абсолютным путем (по умолчанию false).
    Метод method(string) определяет метод Вашего маршрута.

- updateRoute(string, array)

    Определяет route для update, по умолчания определяется, как для resource

    ```php
    $form->updateRoute('users.update', ['user_id' => request()->get('user_id')])
        ->asAbsoluteUrl(false)
        ->method('put');
    ```
    Метод asAbsoluteUrl(bool) определяет является Ваш параметр маршрутом или абсолютным путем (по умолчанию false).
    Метод method(string) определяет метод Вашего маршрута.

- redirectWhenCreated(string, array)

    Определяет путь для редиректа после удачного сохранения данных

    ```php
    $form->redirectWhenCreated('users.update', ['tag' => 'saved'])
        ->asAbsoluteUrl(false)
        ->params(['category_id' => 5]);
    ```
    Метод asAbsoluteUrl(bool) определяет является Ваш параметр маршрутом или абсолютным путем (по умолчанию false).
    Метод params(array) добавляет дополнительные параметры для Вашего пути.

- redirectWhenUpdated(string, array)

    Определяет путь для редиректа после удачного сохранения данных

    ```php
    $form->redirectWhenUpdated('users.update', ['tag' => 'saved'])
        ->asAbsoluteUrl(false)
        ->params(['category_id' => 5]);
    ```
    Метод asAbsoluteUrl(bool) определяет является Ваш параметр маршрутом или абсолютным путем (по умолчанию false).
    Метод params(array) добавляет дополнительные параметры для Вашего пути.

- redirectWhenDeleted(string, array)

    Определяет путь для редиректа после удачного удаления данных

    ```php
    $form->redirectWhenDeleted('users.update', ['tag' => 'saved'])
        ->asAbsoluteUrl(false)
        ->params(['category_id' => 5]);
    ```
    Метод asAbsoluteUrl(bool) определяет является Ваш параметр маршрутом или абсолютным путем (по умолчанию false).
    Метод params(array) добавляет дополнительные параметры для Вашего пути.

##### Fields

- field(string, string)

    Добавляет поле ввода типа текст
    
    ```php
    $form->field('field_name', 'Display Name');
    ```
    
    Доступны общие методы для всех типов колонок:
    
    - valueAs(Closure) - позволяет переопределить значение колонки получаемое из базы данных
    
    - displayAs(Closure) - позволяет переопределить отображение значения колонки
    
    - saveAs(Closure) - позволяет переопределить значение колонки, которое сохраняется в базу данных
    
    - rules(string or array) - позволяет добавить к полю валидацию для create и update
    
    - creationRules(string or array) - позволяет добавить к полю валидацию для create
    
    - updatingRules(string or array) - позволяет добавить к полю валидацию для update
    
    - help(string) - Позволяет добавить краткий вспомогательные текст-описание
 
    ```php
    $form->field('name', 'Name')->valueAs(function ($row) {
        return $row->first_name . ' ' . $row->last_name;
    })->saveAs(function ($row) {
        return $row->first_name . ' ' . $row->last_name;
    })->displayAs(function ($row) {
        return '<span>' . $row->name . '</span>';
    })->rules('required|max:255');
    ```

- string(string, string)

    Добавляет поле ввода типа текст
    
    ```php
    $form->string('field_name', 'Display Name');
    ```
    Общие методы такие же, как и у field(). Дополнительные методы:
    
    - rightPrefix(string) - добавляет префикс справа от поля для отображения информации
    - leftPrefix(string) - добавляет префикс слева от поля для отображения информации
    
    ```php
    $form->string('email', 'Email')->rightPrefix('@mail.com');
    ```

- select(string, string)

    Добавляет поле ввода типа выпадающий список
    
    ```php
    $form->select('field_name', 'Display Name');
    ```
    Общие методы такие же, как и у field(). Дополнительные методы:
    
    - options(array) - возвращает массив со значениями для выпадающего списка
    
    ```php
    $form->select('category_id', 'Category')->options([
      'key1' => 'value1',
      'key2' => 'value2',
    ]);
    ```
  
- boolean(string, string)

    Добавляет поле ввода типа checkbox
    
    ```php
    $form->boolean('field_name', 'Display Name');
    ```
    Общие методы такие же, как и у field().

- file(string, string)

    Добавляет поле для файла
    
    ```php
    $form->file('doc', 'Document');
    ```
    Общие методы такие же, как и у field(). Дополнительные методы:
    
    - disk(string) - указывает диск для хранения файлов (по умолчанию берется значение по умолчанию из настроек filesystems)
    
    - folder(string) - указывает папку для хранения файлов
    
    - name(string or Closure) - переопределяет название файла (по умолчанию генерируется хэш с расширением файла)
    
    - originalName(bool) - если передано значение true, то название файла берется из оригинального файла (по умолчанию false)
    
    - download(bool) - отображает кнопку для скачивания файла (по умолчанию false)
    
    ```php
    $form->file('doc', 'Doc')
      ->folder('docs')
      ->disk('public')
      ->name('my_doc');
    ```

- image(string, string)
    
    Добавляет поля для изображений
    ```php
    $form->image('avatar', 'Avatar');
    ```
    
    Общие методы такие же, как и у field() и file(). Дополнительные методы:
    
    - cropper(bool) - добавляет функционал обрезки (по умолчанию false)
    
    - cropperRatio(float) - можно добавить соотношений сторон для обрезки
    
    ```php
    $form->image('avatar', 'Avatar')
      ->folder('avatars')
      ->disk('public')
      ->name('my_avatar')
      ->cropper(true)
      ->cropperRatio(16/9);
    ```

- hidden(string, string)
    
    Добавляет скрытое поля
    ```php
    $form->hidden('user_id');
    ```
    
    Общие методы такие же, как и у field(). Дополнительные методы:
    
    - defaultValue(string) - устанавливает значение по умолчанию
    
    ```php
    $form->hidden('user_id')
      ->defaultValue(\Auth::user()->id);
    ```

- color(string, string)
    
    Добавляет поле для выбора цвета
    ```php
    $form->color('color', 'Product Color');
    ```
    
    Общие методы такие же, как и у field(). Дополнительные методы:
    
    - defaultColor(string) - устанавливает значение по умолчанию и должно содержать 7 символов
    
    ```php
    $form->hidden('color', 'Product Color')
      ->defaultColor('#cccccc');
    ```

- dateTime(string, string)
    
    Добавляет поле для добавления даты и времени
    ```php
    $form->dateTime('subscription_expire_ar', 'Subscription Expiration Date');
    ```
    
    Общие методы такие же, как и у field().
    Дополнительные методы:
    
    - savingFormat(string) - изменяет формат даты для добавления в базу данных (по умолчанию 'Y-m-d H:i:s')
    
    - onlyDate(bool $value) - применяет только поле для даты
    
    - onlyTime(bool $value) - применяет только поле для времени
    
    ```php
    $form->dateTime('subscription_expire_ar', 'Subscription Expiration Date')
      ->savingFormat('d.m.Y H:i:s');
    ```

- text(string, string)
    
    Добавляет поле textarea
    ```php
    $form->text('description', 'Description');
    ```
    
    Общие методы такие же, как и у field().
    Дополнительные методы:
        
        - symbolsCounter(int, int) - добавляет счетчик символов, первый аргумент минимальное значение (по умолчанию null), второй аргумент максимальное значение (по умолчанию null)
    
    ```php
    $form->text('description', 'Description')
        ->symbolsCounter(null, 50);
    ```

- markdownEditor(string, string)
    
    Добавляет поле с редактором markdown
    ```php
    $form->markdownEditor('description', 'Description');
    ```
    
    Общие методы такие же, как и у field().
    
    ```php
    $form->markdownEditor('description', 'Description');
    ```

- range(string, string)
    
    Добавляет поле для шкалы
    ```php
    $form->range('percent', 'Discount Percent');
    ```
    
    Общие методы такие же, как и у field().
    Дополнительные методы:
    
    - min(float $value) - изменяет минимальную величину шкалы (по умолчанию 0)
    
    - max(float $value) - изменяет максимальную величину шкалы (по умолчанию 100)
    
    - step(float $value) - изменяет шаг шкалы (по умолчанию 1)
    
    ```php
    $form->range('percent', 'Discount Percent')
      ->step(0.1);
  
- dateTime(string, string)
    
    Добавляет поле для шкалы
    ```php
    $form->dateTime('period', 'Period');
    ```
    
    Общие методы такие же, как и у field().
    Дополнительные методы:
    
    - showTime(bool $value) - добавляет время (gо умолчанию false)

    ```php
    $form->dateTime('period', 'Period')
      ->showTime(true);

##### Расширения

Для добавления своих кастомных полей необходимо добавить класс-реализацию интерфейсов Appus\Admin\Fields\FieldInterface и Appus\Admin\Form\Fields\FieldRuleInterface или унаследовать от Appus\Admin\Form\Fields\FieldAbstract:

```php
namespace App\Extensions\DetailsFields;

use Appus\Admin\Form\Fields\FieldAbstract;

class CustomNameField extends FieldAbstract
{

    /**
     * @inheritDoc
     */
    public function getRowViewForString(string $value = null): ?string
    {
        return view('extensions.form-fields.modified')->with([
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value,
            'validationName' => $this->getFieldForSave(), // применяется для валидации
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getRowViewForArray(array $value = null): ?string
    {
        return null;
    }

}
```

и подключить с помощью фасада Appus\Admin\Extensions\Facades\FormFieldExtension в сервис провайдере с помощью метода extend:
```php
namespace App\Providers;

use Appus\Admin\Extensions\Facades\FormFieldExtension;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        FormFieldExtension::extend('customNameField', \App\Extensions\FormFields\CustomNameField::class);
    }
}
```

Первый аргумент метода - название метода поля, второй - реализация кастомного поля.
И в методе form() Вашего контроллера можно добавить Ваше кастомное поле:

```php
public function form()
{
    $form = new Form(new User());
    
    $form->customNameField('name', 'Name');
    
    return $form;
}
```

##### Metrics

Метрика такая же, как и для Table.

##### Messages

Доступны следующие методы для уведомлений действий:

- creationMessage(string $message) - устанавливает уведомление после успешного добавления ресурса

- editingMessage(string $message) - устанавливает уведомление после успешного обновления ресурса

- deletingMessage(string $message) - устанавливает уведомление после успешного удаления ресурса

##### Relations

Для форм доступны следующие отношения:

- belongsToManyCheckbox(string, string)
    
    Добавляет поле отношения многие-ко-многим в виде чекбоксов.
    В певом аргументе название отношения (название метода в главной модели) и отображаемого возле чекбокса названия разделяется точкой
    
    ```php
    $form->belongsToManyCheckbox('categories.name', 'Categories');
    ```
    
    Общие методы такие же, как и у field(). Дополнительные методы:
                                               
       - options(array) - устанавливает список опций. Массив ключ-значение (ключ - идентификатор связи относящейся таблицы, значение - отображаемое название)
       
   ```php
   $form->belongsToManyCheckbox('categories.name', 'Categories')
     ->options([
           1 => 'Fun',
           2 => 'Sport',
       ]);
   ```

- belongsToManySelect(string, string)
    
    Добавляет поле отношения многие-ко-многим в виде мульти-выпадающего списка.
    В певом аргументе название отношения (название метода в главной модели) и отображаемого возле чекбокса названия разделяется точкой
    
    ```php
    $form->belongsToManySelect('categories.name', 'Categories');
    ```
    
    Общие методы такие же, как и у field(). Дополнительные методы такие же, как и у belongsToManyCheckbox().
       
   ```php
   $form->belongsToManySelect('categories.name', 'Categories')
     ->options([
           1 => 'Fun',
           2 => 'Sport',
       ]);
   ```
  
- belongsTo(string, string)
    
    Добавляет поле отношения многие-ко-одному в виде выпадающего списка.
    В певом аргументе название отношения (название метода в главной модели) и отображаемого возле чекбокса названия разделяется точкой
    
    ```php
    $form->belongsTo('category.name', 'Category');
    ```
    
    Общие методы такие же, как и у field(). Дополнительные методы:
    
        - options(array) - устанавливает список опций. Массив ключ-значение (ключ - идентификатор связи относящейся таблицы, значение - отображаемое название)
       
   ```php
   $form->belongsTo('category.name', 'Category')
     ->options([
           1 => 'Fun',
           2 => 'Sport',
       ]);
   ```

- hasMany(string, string)
    
    Добавляет поле отношения один-ко-многим в виде текстовый полей с возможностью добавить новый.
    В певом аргументе название отношения (название метода в главной модели) и отображаемого названия поля разделяется точкой
    
    ```php
    $form->hasMany('phones.values', 'Phones')
       ->rules('.*=required|.*=numeric');
    ```
    
    Для того чтобы применить правило к каждому полю, необходимо перед каждым правилом добавить ".*=".

#### Консольные команды

###### Установка админ панели

```php artisan admin:install```


###### Установка документации

```php artisan admin:docs```

Устанавливает в Ваш проект документацию по appus admin в структурированном виде с разделами.
После успешного добавления документации в консоли будет показан адрес, по которому доступна документация.


###### Добавление нового контроллера

```php artisan admin:controller controller_namespace --model=model_namespace```

```controller_namespace``` - устанавливает расположение Вашего нового контроллера и его название (например, ```App\\Http\\Controllers\\Admins\\UserController```).
 Если указать только название контроллера, то он будет помещен в namespace laravel для контроллеров по умолчанию.


```model_namespace``` - устанавливает модель для вашего CRUD (например, ```App\\Models\\User```)


###### Добавление нового фильтра

```php artisan admin:filter type --class=filter_namespace```

```type``` - устанавливает тип фильтра (select, daterange, multiselect)

```filter_namespace``` - устанавливает расположение Вашего нового фильтра и его название (например, ```App\\MyFilters\\MyFilter```).
Если указать только название фильтра, то он будет помещен в ```App\\Filters```.

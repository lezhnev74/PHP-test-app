# A demo app
This repo contains an app which implements this demo task: 
- create a multilanguage app where user can signup/login
- build an app in a maintainable way with no framework.

While framework usage is prohibited I did use a bunch of packages for different parts of the app (the list of pacakges is shown below).

## Architecture
The app is built with a hexagonal architecture in mind. It has few decoupled layers - http(IO), domain and infrastructure layer.

### Domain
An app has a few models, one command and one query. All are located under `/src` folder:
- `CreateProfile` - create a new profile of a user
- `FindByCredentials` - find a profile based on given credentials
- `Profile` - a model to store user's profile

### HTTP/IO
The IO layer is located in `public/index.php` file and contains all related to HTTP layer logic, including routes:
- `GET /signup` - показать форму регистрации
- `POST /signup` - отправить данные для регистрации
- `GET /login` - показать форму для логина
- `POST /login` - отправить данные для логина
- `GET /profile` - показать профиль для вошедшего пользователя
- `GET /logout` - выйыти из системы
- `GET /lang/[en|ru]` - установить другой язык

## Security measures
- Domain is decoupled from the I/O channel and both has own independent validation logic. 
- Form input is validated in-browser (which of cource can be easily disabled by a user).
- Attack of type CrossSiteRequestForgery is mitigated by using a one-time token.

## Multilanguage support
Since the app must support multi languages there is a language file which contains strings. The code only references such strings from `config/translates.php` file.

## Packages and dependencies
Any app needs a foundation so I reused a part of my work from [here](https://github.com/lezhnev74/php-foundation) and pulled in some new dependencies:
- `vlucas/phpdotenv` - this package will automatically import all ENV variables from `.env` file and make them available within the app. 
- `samrap/gestalt` - a pacakge to load configuration values from PHP files (in case you need other formats it supports a bunch)
- `illuminate/support` - this package needs explanation. It comes from Laravel Framework and I pulled it in because I am so used to syntactic sugar it offers - functions like `env(...)` or `array_get(...)` are so useful taht I just had to pull this one in the app. It does have some classes and interfaces that I don't use, not a big issue at all.
- `php-di/php-di` - The dependency injection container. There are many more, this one feels okay to me.
- `doctrine/cache` - This package is required in order to optimize previous pacakge, so it will cache internal data. The cache is in general very useful for other stuff as well.
- `doctrine/dbal` - abstraction over database connection
- `filp/whoops` - The error handler and formatter library. Outputs pretty responses in JSON, HTML and console modes.
- `monolog/monolog` - This one is to log things to files.
- `beberlei/assert` - Popular validation library
- `prooph/service-bus` - Message bus to connect IO and domain layers
- `klein/klein` - HTTP router
- `league/plates` - Simple PHP templates
- `phpunit/phpunit` - testing library

**Thus an app is a bunch of packages glued together**

## Installation
### In case you have PHP 7.1+ running locally:
- copy `.env.example` to `.env` and adjust its contents to match your environment
- pull in dependencies by running `composer install`
- run built-in php server: `php -S localhost:8081 -t public` 
- open this URL in browser `http://localhost:8081/login`
### In case you have a docker:


## Running tests
From root folder run: `vendor/bin/phpunit`

## TODO
Current codebase can be improved in many ways, but for the sake of the test task I did a few iterations and then stopped.

## Author
Lezhnev Dmitriy, lezhnev.work@gmail.com
https://lessthan12ms.com



----------------------- RUSSIAN ----------------- >>>>>>>>>>>>>>>>>>>>
# Результат тестового задания
Этот репозиторий содержит приложение, созданное по тестовому заданию.
Тестовое задание было намерено упрощено и я мог бы решить его "как можно проще", но в реальной жизни чаще необходимо создание именно приложения, а не одной формы, да и условия тестового задания включали рекомендацию "наличие элементарной архитектуры, ООП приветствуется".

Поэтому приложение использует DI контейнер, а также шину обмена сообщениями для разделения логики ввода-вывода (http) и бизнес-логики (domain logic).

Также, как и в реальной жизни, весь ключевой код покрыт тестами. 

База данных используется sqlite, с враппером dcotrine/dbal. Файл с базой автоматически создается в корне проекта.

## Архитектура
### Бизнес логика
Приложение имеет одну команду и один запрос:
- `CreateProfile` - создает профиль для нового пользователя
- `FindByCredentials` - поиск профиля по введенному паролю
### Вввод\вывод
Приложение имеет один адаптер ввода-вывода - HTTP, который поддерживает маршруты:
- `GET /signup` - показать форму регистрации
- `POST /signup` - отправить данные для регистрации
- `GET /login` - показать форму для логина
- `POST /login` - отправить данные для логина
- `GET /profile` - показать профиль для вошедшего пользователя
- `GET /logout` - выйыти из системы
- `GET /lang/[en|ru]` - установить другой язык

Из задания не ясно требуется ли напрямую работать с глобальными переменными типа $_FILES или можно использовать пакет для работы с HTTP.
Т.к. вручную это делать выглядит менее безопасно, я использовал пакет klein/klein для этой цели.
Маршруты определяются в файле `public/index.php`.
## Защита
- Первый уровень защиты заключается в разделении канал В\В от бизнес логики, т.о. в бизнес логике находятся свои независимые валидаторы. Т.о. независимо от того обойдена(зломана) ли логика на клиенте, на сервере всегда выполняется независимая проверка.
- Второй уровень - валидация формы на клиенте (средствами javascript). Тут уместно использование удобной библиотеке parsley.js, но по условиям задания это не допускается. Поэтому проверка выполняется "вручную".
- Также для защиты от атак типа CrossSiteRequestForgery, каждая форма снабжена соответсвующем полем, защищающим приложение от подобного вида атак. 

## Поддержка нескольких языков
Т.к. приложение должно поддерживать несколько языков, то языковые строки вынесены в отдельный файл `config/translates.php` и в коде используются ссылки на соответсвующие строки. Т.о. подготовлена площадка для перевода приложения на любое кол-во языков без необходимо трогать код.

## Используемые пакеты
В задании явно указано, что нельзя использовать никакой PHP framework. Но там не сказано ничего относительно других менее грандиозных зависимостей. Например, в этом проекте используется следующие (описание скопировано из моего [репозитория](https://github.com/lezhnev74/php-foundation)):
Список зависимостей:
- `vlucas/phpdotenv` - Автоматический импорт переменных окружения из `.env` файла. 
- `samrap/gestalt` - загрузчик конфигурационных файлов.
- `illuminate/support` - содержит множество вспомогательных функций, удобных в работе - `array_get(...)`, `env(...)` и т.п.
- `php-di/php-di` - Контейнер зависимостей
- `doctrine/cache` - Пакет для работы с кешем (для кеширования зависимостей и других вещей)
- `doctrine/dbal` - Абстракция вокруг соединения к БД
- `filp/whoops` - обработчик неперехваченных исключлений.
- `monolog/monolog` - пакет дял журналирования.
- `beberlei/assert` - Пакет состоит из множества валидаторов, проверяющих формат данных
- `prooph/service-bus` - Шина обмена сообщениями
- `klein/klein` - HTTP ввод-вывод
- `league/plates` - шаблонизатор для HTML страниц
- `phpunit/phpunit` - для запуска автоматических тестов

**Т.о. основа проекта создана из нескольких популярных и проверенных временем пакетов, связанных вместе.**

## База данных (sqlite)
Используется одна таблица:
```
CREATE TABLE profiles (
    id INTEGER NOT NULL, 
    first_name VARCHAR(64) NOT NULL, 
    last_name VARCHAR(64) NOT NULL, 
    passport VARCHAR(64) NOT NULL, 
    email VARCHAR(256) NOT NULL, 
    password VARCHAR(256) NOT NULL, 
    photoRelativePath VARCHAR(256) NOT NULL, 
    PRIMARY KEY(id)
)
```

## Установка
Для того, чтобы запустить приложение и увидеть форму входа в браузере нужно:
- copy `.env.example` to `.env` and adjust its contents to match your environment
- pull in dependencies by running `composer install`
- run built-in php server: `php -S localhost:8081 -t public` 
- open this URL in browser `http://localhost:8081/login`

## Запуск автоматических тестов
Запустите из папки проекта `vendor/bin/phpunit`

## TODO
Текущая кодовая база может быть улучшена во многих направлениях, но я остановился после нескольких итераций, т.к. условия задачи выглядит удовлетворенными.

## Автор
Lezhnev Dmitriy, lezhnev.work@gmail.com
https://lessthan12ms.com
# Результат тестового задания
Этот репозиторий содержит приложение, созданное по тестовому заданию.
Тестовое задание было намерено упрощено и я мог бы решить его "как можно проще", но в реальной жизни чаще необходимо создание именно приложения, а не одной формы, да и условия тестового задания включали рекомендацию "наличие элементарной архитектуры, ООП приветствуется".

Поэтому приложение использует DI контейнер, а также шину обмена сообщениями для разделения логики ввода-вывода (http) и бизнес-логики (domain logic).

Также, как и в реальной жизни, весь ключевой код покрыт тестами.

## Архитектура
### Бизнес логика
Приложение имеет одну команду и один запрос:
- `CreateProfile` - создает профиль для нового пользователя
- `FindByCredentials` - поиск профиля по введенному паролю
### Вввод\вывод
Приложение имеет один адаптер ввода-вывода - HTTP, который поддерживает 3 маршрута:
- `GET /signup` - показать форму регистрации
- `POST /signup` - отправить данные для регистрации
- `GET /login` - показать форму для логина
- `POST /login` - отправить данные для логина
- `GET /profile` - показать профиль для вошедшего пользователя

## Используемые пакеты
В задании явно указано, что нельзя использовать никакой PHP framework. Но там не сказано ничего относительно других менее грандиозных зависимостей. Например, в этом проекте используется следующие (описание скопировано из моего [репозитория](https://github.com/lezhnev74/php-foundation)):
This app uses a couple of packages I'd like to explain:
- `vlucas/phpdotenv` - this package will automatically import all ENV variables from `.env` file and make them available within the app. 
- `samrap/gestalt` - a pacakge to load configuration values from PHP files (in case you need other formats it supports a bunch)
- `illuminate/support` - this package needs explanation. It comes from Laravel Framework and I pulled it in because I am so used to syntactic sugar it offers - functions like `env(...)` or `array_get(...)` are so useful taht I just had to pull this one in the app. It does have some classes and interfaces that I don't use, not a big issue at all.
- `php-di/php-di` - The dependency injection container. There are many more, this one feels okay to me.
- `doctrine/cache` - This package is required in order to optimize previous pacakge, so it will cache internal data. The cache is in general very useful for other stuff as well.
- `filp/whoops` - The error handler and formatter library. Outputs pretty responses in JSON, HTML and console modes.
- `monolog/monolog` - This one is to log things to files.
- `beberlei/assert` - Пакет состоит из множества валидаторов, проверяющих формат данных
- `prooph/service-bus` - Шина обмена сообщениями
- `phpunit/phpunit` - для запуска автоматических тестов

**Т.о. основа проекта создана из нескольких популярных и проверенных временем пакетов, связанных вместе.**

## Установка
Для того, чтобы запустить приложение и увидеть форму входа в браузере нужно:
- copy `.env.example` to `.env` and adjust its contents to match your environment
- pull in dependencies by running `composer install`
- Запустить встроенный отладочный PHP сервер: `php -S localhost:8081 -t public`
- Открыть в браузере адрес `http://localhost:8081`

## Запуск автоматических тестов
Запустите из папки проекта `vendor/bin/phpunit`

## TODO
Текущая кодовая база может быть улучшена во многих направлениях, но я остановился после нескольких итераций, т.к. условия задачи выглядит удовлетворенными.

## Автор
Lezhnev Dmitriy, lezhnev.work@gmail.com
https://lessthan12ms.com
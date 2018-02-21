<?php

// A list of dependencies and factories to resolve them
return [
    \Psr\Log\LoggerInterface::class => function () {
        $log       = new \Monolog\Logger(app_deploy());
        $handler   = new \Monolog\Handler\RotatingFileHandler(storage_path('logs/app.log'), 10, \Monolog\Logger::DEBUG);
        $formatter = new \Monolog\Formatter\LineFormatter(null, null, true, true);
        $handler->setFormatter($formatter);

        $log->pushHandler($handler);
        return $log;
    },

    \League\Plates\Engine::class => function () {
        $engine = new League\Plates\Engine(base_path('/views'));
        $engine->addData([
            'error_messages' => config('translation.' . language() . ".http.form"),
        ]);
        return $engine;
    },

    \Doctrine\Common\Cache\Cache::class => function () {
        return new \Doctrine\Common\Cache\FilesystemCache(storage_path("cache/"));
    },

    \SignupForm\Filesystem\FilesystemInterface::class => function () {
        return new SignupForm\Filesystem\Filesystem(config('app.public_path'));
    },

    \Doctrine\DBAL\Driver\Connection::class => function () {

        // Init file automatically
        $db_file = config('db.database');
        if (!file_exists($db_file)) {
            touch($db_file);
        }

        $config           = new \Doctrine\DBAL\Configuration();
        $connectionParams = ['url' => 'sqlite:///' . $db_file];

        return \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
    },

    \SignupForm\Account\Repository\ProfileRepository::class => function ($container) {
        return $container->get(\SignupForm\Database\DoctrineProfileRepo::class);
    },

    \Prooph\ServiceBus\CommandBus::class => function ($container) {
        $bus = new \Prooph\ServiceBus\CommandBus();

        // set router
        $router = new \Prooph\ServiceBus\Plugin\Router\CommandRouter();
        $router->route(\SignupForm\Account\Command\CreateProfile\CreateProfile::class)
            ->to($container->get(\SignupForm\Account\Command\CreateProfile\CreateProfileHandler::class));

        $router->attachToMessageBus($bus);

        return $bus;
    },

    \Prooph\ServiceBus\QueryBus::class => function ($container) {
        $bus = new \Prooph\ServiceBus\QueryBus();

        // set router
        $router = new \Prooph\ServiceBus\Plugin\Router\QueryRouter();
        $router->route(\SignupForm\Account\Query\FindByCredentials\FindByCredentials::class)
            ->to($container->get(\SignupForm\Account\Query\FindByCredentials\FindByCredentialsHandler::class));

        $router->attachToMessageBus($bus);

        return $bus;
    },
];
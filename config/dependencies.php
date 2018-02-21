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
            'error_messages' => config('translation.' . config('app.language') . ".http.form"),
        ]);
        return $engine;
    },

    \Doctrine\Common\Cache\Cache::class => function () {
        return new \Doctrine\Common\Cache\FilesystemCache(storage_path("cache/"));
    },

    \SignupForm\Filesystem\FilesystemInterface::class => function () {
        return new SignupForm\Filesystem\Filesystem(config('app.public_path'));
    },
];
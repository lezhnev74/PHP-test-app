<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */

require __DIR__ . "/../bootstrap/start.php";


$klein = new \Klein\Klein();


// Маршруты я прописываю прямо здесь, без дополнительных конфигурационных файлов
$klein->respond('GET', '/signup', function () {
    $csrf      = container()->get(Slim\Csrf\Guard::class);
    $templates = container()->get(\League\Plates\Engine::class);

    return $templates->render('signup', [
        'csrf' => [
            'name' => $csrf->getTokenNameKey(),
            'value' => $csrf->getTokenValueKey(),
        ],
    ]);
});


//add(new \Slim\Csrf\Guard);

// Поехали
$klein->dispatch();
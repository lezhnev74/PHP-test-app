<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */

require __DIR__ . "/../bootstrap/start.php";


$router = new \Klein\Klein();
$router->service()->startSession();

// Маршруты я прописываю прямо здесь, без дополнительных конфигурационных файлов
$router->respond('GET', '/signup',
    function (\Klein\Request $request, \Klein\AbstractResponse $response, \Klein\ServiceProvider $service) {
        $templates        = container()->get(\League\Plates\Engine::class);
        $_SESSION['csrf'] = md5(random_bytes(32));

        return $templates
            ->addData(['flash' => $service->flashes()])
            ->render('signup', ['csrf' => $_SESSION['csrf']]);
    });
$router->respond('POST', '/signup',
    function (\Klein\Request $request, \Klein\AbstractResponse $response, \Klein\ServiceProvider $service) {

        // Protect from CSRF
        if (!isset($_SESSION['csrf']) || strlen($_SESSION['csrf']) != 32 || $_SESSION['csrf'] != $request->param('csrf_token')) {
            $service->flash(translate('http.csrf'));
            return $response->redirect("/signup");
        } else {
            //unset($_SESSION['csrf']); // one-time code
        }

        // Now let's validate input
        $email      = $request->param('email');
        $password   = $request->param('password');
        $password2  = $request->param('password2');
        $first_name = $request->param('first_name');
        $last_name  = $request->param('last_name');
        $passport   = $request->param('passport');
        $photoFile  = $request->files()->get('photo');

        // 1. email
        try {
            \Assert\Assert::that($email)->email();
        } catch (\Assert\InvalidArgumentException $e) {
            $service->flash(translate('http.form.email'));
        }

        // 1.1 password
        try {
            \Assert\Assert::that($password)->minLength(6);
        } catch (\Assert\InvalidArgumentException $e) {
            $service->flash(translate('http.form.password'));
        }
        try {
            \Assert\Assert::that($password2)->eq($password);
        } catch (\Assert\InvalidArgumentException $e) {
            $service->flash(translate('http.form.passwordConfirmation'));
        }

        // 2. names and passport
        try {
            \Assert\Assert::that($first_name)->minLength(1);
        } catch (\Assert\InvalidArgumentException $e) {
            $service->flash(translate('http.form.first_name'));
        }
        try {
            \Assert\Assert::that($last_name)->minLength(1);
        } catch (\Assert\InvalidArgumentException $e) {
            $service->flash(translate('http.form.last_name'));
        }
        try {
            \Assert\Assert::that($passport)->minLength(1);
        } catch (\Assert\InvalidArgumentException $e) {
            $service->flash(translate('http.form.passport'));
        }

        // 3. photo file
        $mimetype = mime_content_type(array_get($photoFile, 'tmp_name', ''));
        $allowed  = ['image/gif', 'image/png', 'image/jpeg'];
        if (!in_array($mimetype, $allowed)) {
            $service->flash(translate('http.form.photo'));
        }

        if (count($service->flashes('error'))) {
            $service->flash(translate('http.csrf'));
        } else {
            // All looks good, now pass data to the domain layer
        }

    });


//add(new \Slim\Csrf\Guard);

// Поехали
$router->dispatch();
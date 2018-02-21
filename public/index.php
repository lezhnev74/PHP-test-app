<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */

require __DIR__ . "/../bootstrap/start.php";

$router = new \Klein\Klein();
$router->service()->startSession();

// Маршруты я прописываю прямо здесь, без дополнительных конфигурационных файлов
$router->respond('GET', '/lang/[ru|en:lang]', function (
    \Klein\Request $request,
    \Klein\AbstractResponse $response,
    \Klein\ServiceProvider $service
) {
    $lang      = $request->param('lang');
    $supported = config('translation.supported');
    if (in_array($lang, array_keys($supported))) {
        $_SESSION['language'] = $lang;
        $service->flash(translate('http.labels.language') . ": " . $supported[$lang]);
    }
    return $response->redirect("/login");
});

$router->respond('GET', '/logout', function (
    \Klein\Request $request,
    \Klein\AbstractResponse $response,
    \Klein\ServiceProvider $service
) {
    unset($_SESSION['logged_in_profile_login']);
    return $response->redirect("/login");
});
$router->respond('GET', '/profile', function (
    \Klein\Request $request,
    \Klein\AbstractResponse $response,
    \Klein\ServiceProvider $service
) {
    // Protect from unauthorized access
    if (!isset($_SESSION['logged_in_profile_login'])) {
        return $response->redirect("/login");
    }

    $templates = container()->get(\League\Plates\Engine::class);

    // Get result from the query
    $credentials = \SignupForm\Account\Model\VO\Credentials::fromPlainPassword($_SESSION['logged_in_profile_login'],
        "does not matter");
    $query       = \SignupForm\Account\Query\FindByCredentials\FindByCredentials::fromCredentials($credentials);
    $profile     = null;

    container()
        ->get(\Prooph\ServiceBus\QueryBus::class)
        ->dispatch($query)
        ->done(function ($result) use (&$profile) {
            $profile = $result;
        }, function (\Prooph\ServiceBus\Exception\MessageDispatchException $e) {
            throw $e;
        });

    return $templates
        ->addData(['flash' => $service->flashes()])
        ->render('profile', ['profile' => $profile]);
});

$router->respond('GET', '/signup', function (
    \Klein\Request $request,
    \Klein\AbstractResponse $response,
    \Klein\ServiceProvider $service
) {
    $templates        = container()->get(\League\Plates\Engine::class);
    $_SESSION['csrf'] = md5(random_bytes(32));

    return $templates
        ->addData(['flash' => $service->flashes()])
        ->render('signup', ['csrf' => $_SESSION['csrf']]);
});

$router->respond('GET', '/login', function (
    \Klein\Request $request,
    \Klein\AbstractResponse $response,
    \Klein\ServiceProvider $service
) {
    $templates        = container()->get(\League\Plates\Engine::class);
    $_SESSION['csrf'] = md5(random_bytes(32));

    return $templates
        ->addData(['flash' => $service->flashes()])
        ->render('login', ['csrf' => $_SESSION['csrf']]);
});

$router->respond('POST', '/login',
    function (\Klein\Request $request, \Klein\AbstractResponse $response, \Klein\ServiceProvider $service) {

        // Protect from CSRF
        if (!isset($_SESSION['csrf']) || strlen($_SESSION['csrf']) != 32 || $_SESSION['csrf'] != $request->param('csrf_token')) {
            $service->flash(translate('http.csrf'));
            return $response->redirect("/login");
        } else {
            unset($_SESSION['csrf']); // one-time code
        }

        // Now let's validate input
        $email    = $request->param('email');
        $password = $request->param('password');

        // 1. email
        try {
            \Assert\Assert::that($email)->email();
        } catch (\Assert\InvalidArgumentException $e) {
            $service->flash(translate('http.form.email', 'error'));
        }

        // 1.1 password
        try {
            \Assert\Assert::that($password)->minLength(6);
        } catch (\Assert\InvalidArgumentException $e) {
            $service->flash(translate('http.form.password', 'error'));
        }

        if (count($service->flashes('error'))) {
            $service->flash(translate('http.csrf'));
            return $response->redirect('/signup');
        } else {
            // All looks good, now pass data to the domain layer
            $credentials = \SignupForm\Account\Model\VO\Credentials::fromPlainPassword($email, $password);

            try {
                $query = \SignupForm\Account\Query\FindByCredentials\FindByCredentials::fromCredentials($credentials);
            } catch (Throwable $e) {
                $service->flash($e->getMessage());
                return $response->redirect('/login');
            }

            // Get result from the query
            $profile = null;

            container()
                ->get(\Prooph\ServiceBus\QueryBus::class)
                ->dispatch($query)
                ->done(function ($result) use (&$profile) {
                    $profile = $result;
                }, function (\Prooph\ServiceBus\Exception\MessageDispatchException $e) {
                    throw $e;
                });

            if (!$profile || !$profile->getCredentials()->isPassword($credentials->getPassword())) {
                $service->flash(translate('http.login_failed'));
                return $response->redirect('/login');
            }

            $_SESSION['logged_in_profile_login'] = $credentials->getLogin();
            return $response->redirect('/profile');
        }

    });

$router->respond('POST', '/signup',
    function (\Klein\Request $request, \Klein\AbstractResponse $response, \Klein\ServiceProvider $service) {

        // Protect from CSRF
        if (!isset($_SESSION['csrf']) || strlen($_SESSION['csrf']) != 32 || $_SESSION['csrf'] != $request->param('csrf_token')) {
            $service->flash(translate('http.csrf'));
            return $response->redirect("/signup");
        } else {
            unset($_SESSION['csrf']); // one-time code
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
            $service->flash(translate('http.form.email'), 'error');
        }

        // 1.1 password
        try {
            \Assert\Assert::that($password)->minLength(6);
        } catch (\Assert\InvalidArgumentException $e) {
            $service->flash(translate('http.form.password'), 'error');
        }
        try {
            \Assert\Assert::that($password2)->eq($password);
        } catch (\Assert\InvalidArgumentException $e) {
            $service->flash(translate('http.form.passwordConfirmation'), 'error');
        }

        // 2. names and passport
        try {
            \Assert\Assert::that($first_name)->minLength(1);
        } catch (\Assert\InvalidArgumentException $e) {
            $service->flash(translate('http.form.first_name'), 'error');
        }
        try {
            \Assert\Assert::that($last_name)->minLength(1);
        } catch (\Assert\InvalidArgumentException $e) {
            $service->flash(translate('http.form.last_name'), 'error');
        }
        try {
            \Assert\Assert::that($passport)->minLength(1);
        } catch (\Assert\InvalidArgumentException $e) {
            $service->flash(translate('http.form.passport'), 'error');
        }

        // 3. photo file
        $mimetype = mime_content_type(array_get($photoFile, 'tmp_name', ''));
        $allowed  = ['image/gif', 'image/png', 'image/jpeg'];
        if (!in_array($mimetype, $allowed)) {
            $service->flash(translate('http.form.photo'), 'error');
        }

        if (count($service->flashes('error'))) {
            $service->flash(translate('http.csrf'));
            return $response->redirect('/signup');
        } else {
            // All looks good, now pass data to the domain layer
            $credentials = \SignupForm\Account\Model\VO\Credentials::fromPlainPassword($email, $password);
            $passport    = new \SignupForm\Account\Model\VO\Passport($first_name, $last_name, $passport);

            try {
                $command = \SignupForm\Account\Command\CreateProfile\CreateProfile::fromPassportAndCredentialsAndPhoto($passport,
                    $credentials, $photoFile['tmp_name']);
            } catch (Throwable $e) {
                $service->flash($e->getMessage());
                return $response->redirect('/login');
            }

            container()->get(\Prooph\ServiceBus\CommandBus::class)->dispatch($command);

            $service->flash(translate('http.signedup'));
            return $response->redirect('/login');
        }

    });

// Поехали
$router->dispatch();
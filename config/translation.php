<?php
return [
    'supported' => [
        'ru' => 'Russia/Русский',
        'en' => 'English/Английский',
    ],
    'ru' => [
        'http' => [
            'csrf' => 'Пожалуйста, обновите страницу и отправьте форму заного',
            'form' => [
                "email" => "Формат электронной почты некорректен",
                "password" => "Пароль должен иметь минимум 6 символов (без пробелов)",
                "passwordConfirmation" => "Подтверждение пароля не совпадает",
                "first_name" => "Пожалуйста, укажите Ваше Имя",
                "last_name" => "Пожалуйста, укажите Вашу Фамилию",
                "passport" => "Пожалуйста, укажите Номер Вашего Паспорта",
                "photo" => "Пожалуйста, выберите фотографию. Разрешенные форматы: gif, png, jpg.",
            ],
            'labels' => [
                'login' => 'Вход на сайт',
                'logout' => 'Выйти',
                'signup' => 'Регистрация на сайте',
                'email' => 'Ваша электронная почта',
                'password' => 'Ваш пароль',
                'passwordConfirm' => 'Подтверждение пароля',
                'first_name' => 'Ваше Имя',
                'last_name' => 'Ваша Фамилия',
                'passport' => 'Номер Вашего Паспорта',
                'photo' => 'Ваша Фотография',
                'profile' => 'Ваш Профиль',
                'language' => 'Язык',
            ],
            'signedup' => 'Вы успешно зарегистрировались, теперь вы можете войти, используя ваш логин(емаил) и пароль',
            'login_failed' => 'Указанная пара емаил+пароль не найдена в нашей базе данных',
        ],
    ],
    'en' => [
        'http' => [
            'csrf' => 'Please refresh the page and re-submit the form',
            'form' => [
                "email" => "E-mail has wrong format",
                "password" => "Password must be at least 6 chars long",
                "passwordConfirmation" => "Password confirmation does not match",
                "first_name" => "Please fill your first name in the field",
                "last_name" => "Please fill your last name in the field",
                "passport" => "Please fill your national ID number in the field",
                "photo" => "Please choose your photo. Supported file formats: gif, png, jpg.",
            ],
            'labels' => [
                'login' => 'Sign in',
                'logout' => 'Sign out',
                'signup' => 'Sign up',
                'email' => 'E-mail',
                'password' => 'Password',
                'passwordConfirm' => 'Passowrd confirmation',
                'first_name' => 'First name',
                'last_name' => 'Last name',
                'passport' => 'National ID number',
                'photo' => 'Your photo',
                'profile' => 'Your profile',
                'language' => 'Language',
            ],
            'signedup' => 'You have successfully signed up. Please use your credentials to sign in here',
            'login_failed' => 'Unable to log you in',
        ],
    ],
];
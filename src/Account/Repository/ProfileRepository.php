<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */
declare(strict_types=1);


namespace SignupForm\Account\Repository;


use SignupForm\Account\Model\Profile;
use SignupForm\Account\Model\VO\Credentials;

interface ProfileRepository
{
    function save(Profile $profile);

    function findByCredentials(Credentials $credentials): Profile;
}
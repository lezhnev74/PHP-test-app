<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */
declare(strict_types=1);

namespace SignupForm\Account\Query\FindByCredentials;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use React\Promise\Deferred;
use SignupForm\Account\Model\VO\Credentials;
use SignupForm\Account\Repository\ProfileRepository;

class FindByCredentialsHandlerTest extends TestCase
{
    function test_it_can_find_profile()
    {
        $credentials = Credentials::fromPlainPassword("login", "password");
        $query       = FindByCredentials::fromCredentials($credentials);

        $repoMock = $this->prophesize(ProfileRepository::class);
        $repoMock->findByCredentials(
            Argument::that(function (Credentials $queryCredentials) use ($credentials) {
                return $queryCredentials->isEqual($credentials);
            })
        )->shouldBeCalled();

        $finder = new FindByCredentialsHandler($repoMock->reveal());
        $finder($query, new Deferred());
    }
    
}

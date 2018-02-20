<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */
declare(strict_types=1);

namespace SignupForm\Account\Command\CreateProfile;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use SignupForm\Account\Model\Profile;
use SignupForm\Account\Model\VO\Credentials;
use SignupForm\Account\Model\VO\Passport;
use SignupForm\Account\Repository\ProfileRepository;

class CreateProfileHandlerTest extends TestCase
{
    function test_it_persists_profile()
    {
        $credentials = Credentials::fromPlainPassword("login", "password");
        $passport    = new Passport("Dmitriy", "Lezhnev", "123456");

        $command = CreateProfile::fromPassportAndCredentials($passport, $credentials);

        $loggerMock = $this->prophesize(LoggerInterface::class);
        $loggerMock->info(Argument::type('string'), Argument::type('array'))->shouldBeCalled();

        $repoMock = $this->prophesize(ProfileRepository::class);
        $repoMock->save(
            Argument::that(function (Profile $profile) use ($credentials, $passport) {
                return $profile->getPassport()->isEqual($passport) &&
                    $profile->getCredentials()->isEqual($credentials);
            })
        )->shouldBeCalled();

        $handler = new CreateProfileHandler($loggerMock->reveal(), $repoMock->reveal());
        $handler($command);
    }
}

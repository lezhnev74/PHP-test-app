<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */
declare(strict_types=1);

namespace SignupForm\Account\Command\CreateProfile;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use SignupForm\Account\Model\Profile;
use SignupForm\Account\Model\VO\Credentials;
use SignupForm\Account\Model\VO\Passport;
use SignupForm\Account\Repository\ProfileRepository;
use SignupForm\Filesystem\FilesystemInterface;

class CreateProfileHandlerTest extends TestCase
{
    private $tmp_folder;

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->tmp_folder = base_path('tests/tmp');
    }


    protected function tearDown()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::tearDown();

        `rm -rf $this->tmp_folder/*`;
    }

    function test_it_validates_file()
    {
        $this->expectException(InvalidArgumentException::class);

        $credentials = Credentials::fromPlainPassword("login", "password");
        $passport    = new Passport("Dmitriy", "Lezhnev", "123456");

        CreateProfile::fromPassportAndCredentialsAndPhoto($passport, $credentials, tempnam($this->tmp_folder, 'temp_'));
    }

    function test_it_persists_profile()
    {
        $credentials = Credentials::fromPlainPassword("login", "password");
        $passport    = new Passport("Dmitriy", "Lezhnev", "123456");

        $tmp_file = $this->tmp_folder . "/photo.jpg";
        copy(base_path('tests/Fixture/photo-valid.jpg'), $tmp_file);

        $command = CreateProfile::fromPassportAndCredentialsAndPhoto($passport, $credentials, $tmp_file);

        $loggerMock = $this->prophesize(LoggerInterface::class);
        $loggerMock->info(Argument::type('string'), Argument::type('array'))->shouldBeCalled();

        $repoMock = $this->prophesize(ProfileRepository::class);
        $repoMock->save(
            Argument::that(function (Profile $profile) use ($credentials, $passport) {
                return $profile->getPassport()->isEqual($passport) &&
                    $profile->getCredentials()->isEqual($credentials);
            })
        )->shouldBeCalled();

        $filesystemMock = $this->prophesize(FilesystemInterface::class);
        $filesystemMock->moveToPublic(Argument::type('string'), Argument::exact($tmp_file))->shouldBeCalled();

        $handler = new CreateProfileHandler($loggerMock->reveal(), $repoMock->reveal(), $filesystemMock->reveal());
        $handler($command);
    }
}

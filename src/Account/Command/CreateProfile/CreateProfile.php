<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */
declare(strict_types=1);


namespace SignupForm\Account\Command\CreateProfile;


use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use SignupForm\Account\Model\VO\Credentials;
use SignupForm\Account\Model\VO\Passport;

class CreateProfile extends Command implements PayloadConstructable
{
    use PayloadTrait;

    function getPassport(): Passport
    {
        return Passport::fromArray($this->payload['passport']);
    }

    function getCredentials(): Credentials
    {
        return Credentials::fromArray($this->payload['credentials']);
    }

    static function fromPassportAndCredentials(Passport $passport, Credentials $credentials): self
    {
        return new self([
            'credentials' => $credentials->asArray(),
            'passport' => $passport->asArray(),
        ]);
    }

}
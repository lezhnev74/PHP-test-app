<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */
declare(strict_types=1);


namespace SignupForm\Account\Query\FindByCredentials;


use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\Common\Messaging\Query;
use SignupForm\Account\Model\VO\Credentials;

class FindByCredentials extends Query implements PayloadConstructable
{
    use PayloadTrait;

    function getCredentials(): Credentials
    {
        return Credentials::fromArray($this->payload);
    }

    static function fromCredentials(Credentials $credentials): self
    {
        return new self($credentials->asArray());
    }
}
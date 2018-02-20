<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */
declare(strict_types=1);

namespace SignupForm\Account\Model\VO;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CredentialsTest extends TestCase
{
    function test_it_accepts_valid_data()
    {
        $login       = "dlezhnev";
        $password    = "secret";
        $credentials = Credentials::fromPlainPassword($login, $password);

        $this->assertEquals($login, $credentials->getLogin());
        $this->assertTrue($credentials->isPassword($password));
    }

    function test_it_can_export_import_array_structure()
    {

        $login        = "dlezhnev";
        $password     = "secret";
        $credentialsA = Credentials::fromPlainPassword($login, $password);

        // export
        $array = $credentialsA->asArray();

        // import
        $credentialsB = Credentials::fromArray($array);

        $this->assertEquals($login, $credentialsB->getLogin());
        $this->assertTrue($credentialsB->isPassword($password));

    }

    function invalidData()
    {
        return [
            ["", ""],
            ["login", ""],
            ["", "123456"],
            ["log", "123"],
        ];
    }

    /**
     * @dataProvider invalidData
     */
    function test_it_validates_input_data($login, $password)
    {
        $this->expectException(InvalidArgumentException::class);
        Credentials::fromPlainPassword($login, $password);
    }
}

<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */
declare(strict_types=1);

namespace SignupForm\Account\Model\VO;


use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PassportTest extends TestCase
{
    function test_passport_accepts_valid_data()
    {
        $first_name = "Dmitriy";
        $last_name  = "Lezhnev";
        $number     = "123";
        $passport   = new Passport($first_name, $last_name, $number);

        $this->assertEquals($first_name, $passport->getFirstName());
        $this->assertEquals($last_name, $passport->getLastName());
        $this->assertEquals($number, $passport->getNumber());
    }

    function test_it_can_export_import_array_structure()
    {

        $first_name = "Dmitriy";
        $last_name  = "Lezhnev";
        $number     = "123";
        $passportA  = new Passport($first_name, $last_name, $number);

        // export
        $array = $passportA->asArray();

        // import
        $passportB = Passport::fromArray($array);

        $this->assertEquals($first_name, $passportB->getFirstName());
        $this->assertEquals($last_name, $passportB->getLastName());
        $this->assertEquals($number, $passportB->getNumber());

    }

    function invalidData()
    {
        return [
            ["", "", ""],
            ["Dmitriy", "", ""],
            ["Dmitriy", "Lezhnev", ""],
            ["", "Lezhnev", ""],
            ["Dmitriy", "", "123"],
            ["", "Lezhnev", "123"],
            ["", "", "123"],
        ];
    }

    /**
     * @dataProvider invalidData
     */
    function test_it_validates_input_data($first_name, $last_name, $number)
    {
        $this->expectException(InvalidArgumentException::class);
        new Passport($first_name, $last_name, $number);
    }
}

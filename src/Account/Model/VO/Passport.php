<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */
declare(strict_types=1);


namespace SignupForm\Account\Model\VO;


use Assert\Assert;

final class Passport
{
    /** @var string */
    private $first_name;
    /** @var string */
    private $last_name;
    /** @var string representing unique national number */
    private $number;

    /**
     * Passport constructor.
     * @param string $first_name
     * @param string $last_name
     * @param string $number
     */
    public function __construct(string $first_name, string $last_name, string $number)
    {
        // I am not sure if here we need more tight validation
        Assert::that($first_name)->minLength(1);
        Assert::that($last_name)->minLength(1);
        Assert::that($number)->minLength(1);

        $this->first_name = $first_name;
        $this->last_name  = $last_name;
        $this->number     = $number;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }


    public function isEqual(self $passport): bool
    {
        return
            $passport->getFirstName() === $this->getFirstName() &&
            $passport->getLastName() === $this->getLastName() &&
            $passport->getNumber() === $this->getNumber();
    }

    public function asArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'number' => $this->number,
        ];
    }

    static function fromArray(array $array): self
    {
        return new self(
            $array['first_name'] ?? "",
            $array['last_name'] ?? "",
            $array['number'] ?? ""
        );
    }
}
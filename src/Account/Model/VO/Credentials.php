<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */
declare(strict_types=1);


namespace SignupForm\Account\Model\VO;


use Assert\Assert;

class Credentials
{
    /** @var string */
    private $login;
    /** @var string */
    private $passwordHash;

    /**
     * Credentials constructor.
     * @param string $login
     * @param string $password
     * @param bool $needHash
     */
    private function __construct(string $login, string $password, bool $needHash = true)
    {
        Assert::that($login)->minLength(1);
        Assert::that($password)->minLength(6);

        $this->login        = $login;
        $this->passwordHash = $needHash ? $this->hashPassword($password) : $password;
    }


    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    public function isPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->getPasswordHash());
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }


    public function isEqual(self $credentials): bool
    {
        return
            $credentials->getPasswordHash() === $this->getPasswordHash() &&
            $credentials->getLogin() === $this->getLogin();
    }

    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }


    public function asArray(): array
    {
        return [
            'login' => $this->login,
            'passwordHash' => $this->passwordHash,
        ];
    }

    static function fromArray(array $array): self
    {
        return new self(
            $array['login'] ?? "",
            $array['passwordHash'] ?? "",
            false
        );
    }

    static function fromPlainPassword(string $login, string $password): self
    {
        return new self($login, $password, true);
    }

    static function fromHashedPassword(string $login, string $password): self
    {
        return new self($login, $password, false);
    }
}
<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */
declare(strict_types=1);


namespace SignupForm\Account\Model;


use SignupForm\Account\Model\VO\Credentials;
use SignupForm\Account\Model\VO\Passport;

class Profile
{
    /** @var Credentials */
    private $credentials;
    /** @var Passport */
    private $passport;
    /** @var string */
    private $photoRelativePath;

    /**
     * Profile constructor.
     * @param Credentials $credentials
     * @param Passport $passport
     * @param string $photoRelativePath
     */
    public function __construct(Credentials $credentials, Passport $passport, string $photoRelativePath)
    {
        $this->credentials       = $credentials;
        $this->passport          = $passport;
        $this->photoRelativePath = $photoRelativePath;
    }

    /**
     * @return string
     */
    public function getPhotoRelativePath(): string
    {
        return $this->photoRelativePath;
    }


    /**
     * @return Credentials
     */
    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    /**
     * @return Passport
     */
    public function getPassport(): Passport
    {
        return $this->passport;
    }

}
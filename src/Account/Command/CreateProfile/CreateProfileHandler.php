<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */
declare(strict_types=1);


namespace SignupForm\Account\Command\CreateProfile;


use Psr\Log\LoggerInterface;
use SignupForm\Account\Model\Profile;
use SignupForm\Account\Repository\ProfileRepository;

class CreateProfileHandler
{
    /** @var LoggerInterface */
    private $logger;
    /** @var ProfileRepository */
    private $repo;

    /**
     * CreateProfileHandler constructor.
     * @param LoggerInterface $logger
     * @param ProfileRepository $repo
     */
    public function __construct(LoggerInterface $logger, ProfileRepository $repo)
    {
        $this->logger = $logger;
        $this->repo   = $repo;
    }


    function __invoke(CreateProfile $command)
    {
        $profile = new Profile($command->getCredentials(), $command->getPassport());
        $this->repo->save($profile);

        $this->logger->info("Profile created", [
            // password hash is not included in logs
            'login' => $profile->getCredentials()->getLogin(),
            'passport' => $profile->getPassport()->asArray(),
        ]);
    }
}
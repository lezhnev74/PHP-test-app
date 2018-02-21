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
use SignupForm\Filesystem\FilesystemInterface;

class CreateProfileHandler
{
    /** @var LoggerInterface */
    private $logger;
    /** @var ProfileRepository */
    private $repo;
    /** @var FilesystemInterface */
    private $filesystem;

    /**
     * CreateProfileHandler constructor.
     * @param LoggerInterface $logger
     * @param ProfileRepository $repo
     * @param FilesystemInterface $filesystem
     */
    public function __construct(LoggerInterface $logger, ProfileRepository $repo, FilesystemInterface $filesystem)
    {
        $this->logger     = $logger;
        $this->repo       = $repo;
        $this->filesystem = $filesystem;
    }


    function __invoke(CreateProfile $command)
    {
        $relativePath = "photo/" . md5(random_bytes(32));
        $this->filesystem->moveToPublic($relativePath, $command->getPhotoFile());

        $profile = new Profile($command->getCredentials(), $command->getPassport(), $relativePath);
        $this->repo->save($profile);

        $this->logger->info("Profile created", [
            // password hash is not included in logs
            'login' => $profile->getCredentials()->getLogin(),
            'passport' => $profile->getPassport()->asArray(),
        ]);
    }
}
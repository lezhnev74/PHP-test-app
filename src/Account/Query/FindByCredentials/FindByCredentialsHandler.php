<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/02/2018
 */
declare(strict_types=1);


namespace SignupForm\Account\Query\FindByCredentials;


use React\Promise\Deferred;
use SignupForm\Account\Repository\ProfileRepository;

class FindByCredentialsHandler
{
    /** @var ProfileRepository */
    private $repo;

    /**
     * FindByCredentialsHandler constructor.
     * @param ProfileRepository $repo
     */
    public function __construct(ProfileRepository $repo)
    {
        $this->repo = $repo;
    }


    function __invoke(FindByCredentials $query, Deferred $deferred = null)
    {
        $profile = $this->repo->findByCredentials($query->getCredentials());

        $deferred->resolve($profile);
    }
}
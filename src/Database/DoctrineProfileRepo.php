<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 21/02/2018
 */
declare(strict_types=1);


namespace SignupForm\Database;


use Doctrine\DBAL\Driver\Connection;
use SignupForm\Account\Model\Profile;
use SignupForm\Account\Model\VO\Credentials;
use SignupForm\Account\Model\VO\Passport;
use SignupForm\Account\Repository\ProfileRepository;

class DoctrineProfileRepo implements ProfileRepository
{
    /** @var Connection */
    private $connection;

    /**
     * ProfileRepo constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;

        $this->migrate();
    }

    /** If database has no schema - create it. This is not for production purposes, just for the demo purpose. */
    private function migrate()
    {
        $sm = $this->connection->getSchemaManager();
        if (!$sm->tablesExist(['profiles'])) {

            $schema        = new \Doctrine\DBAL\Schema\Schema();
            $profilesTable = $schema->createTable("profiles");

            $profilesTable->addColumn("id", "integer", ['autoincrement' => true]);
            $profilesTable->addColumn("first_name", "string", ["length" => 64]);
            $profilesTable->addColumn("last_name", "string", ["length" => 64]);
            $profilesTable->addColumn("passport", "string", ["length" => 64]);
            $profilesTable->addColumn("email", "string", ["length" => 256]);
            $profilesTable->addColumn("password", "string", ["length" => 256]);
            $profilesTable->addColumn("photoRelativePath", "string", ["length" => 256]);
            $profilesTable->addUniqueIndex(["email"]);

            $profilesTable->setPrimaryKey(["id"]);

            $sm->createTable($profilesTable);
        }
    }


    function save(Profile $profile)
    {
        // Protect from duplication
        $existingRow = $this->connection->fetchArray('SELECT * FROM profiles WHERE email = ?',
            [$profile->getCredentials()->getLogin()]);
        if (!$existingRow) {
            $this->connection->insert('profiles', [
                'first_name' => $profile->getPassport()->getFirstName(),
                'last_name' => $profile->getPassport()->getLastName(),
                'passport' => $profile->getPassport()->getNumber(),
                'email' => $profile->getCredentials()->getLogin(),
                'password' => $profile->getCredentials()->getPasswordHash(),
                'photoRelativePath' => $profile->getPhotoRelativePath(),
            ]);
        }
    }

    function findByCredentials(Credentials $credentials): ?Profile
    {
        $row = $this->connection->fetchAssoc("select * from profiles where email=?", [
            $credentials->getLogin(),
        ]);

        if (!$row) {
            return null;
        } else {
            return $this->mapRowToModels($row);
        }
    }

    private function mapRowToModels(array $row): Profile
    {
        return new Profile(
            Credentials::fromHashedPassword($row['email'], $row['password']),
            new Passport(
                $row['first_name'],
                $row['last_name'],
                $row['passport']
            ),
            $row['photoRelativePath']
        );
    }

}
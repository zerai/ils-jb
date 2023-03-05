<?php declare(strict_types=1);

namespace App\Tests\Integration\Repository;

use App\Entity\User;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $passwordHasher;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        //        $container = static::getContainer();
        //
        //        $this->passwordHasher = $container
        //            ->get('security.user_password_hasher');
    }

    public function testCanPersistAUser()
    {
        $repository = $this->entityManager
            ->getRepository(User::class);
        $randomEmail = Uuid::uuid4() . '@example.com';
        $aUser = new User();
        $aUser->setEmail($randomEmail);
        $aUser->setRoles(['ROLE_ADMIN']);
        $aUser->setPassword(
            //$this->passwordHasher->hashPassword($aUser, 'admin')
            'irrelevant'
        );

        $repository->add($aUser, true);

        $userFromDB = $repository->findOneBy([
            'email' => $randomEmail,
        ]);
        $this->assertSame($randomEmail, $userFromDB->getEmail());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}

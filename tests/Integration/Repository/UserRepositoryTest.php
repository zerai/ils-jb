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

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testCanPersistAUser()
    {
        $repository = $this->entityManager
            ->getRepository(User::class);
        $aUser = $this->createRandomAdminUser();
        $expectedEmail = $aUser->getEmail();

        $repository->add($aUser, true);

        $userFromDB = $repository->findOneBy([
            'email' => $expectedEmail,
        ]);
        $this->assertSame($expectedEmail, $userFromDB->getEmail());
    }

    public function testCanRemoveAUser()
    {
        $randomEmail = Uuid::uuid4() . '@example.com';
        $this->persistAnAdminUserWithMail($randomEmail);
        $repository = $this->entityManager
            ->getRepository(User::class);
        $userFromDB = $repository->findOneBy([
            'email' => $randomEmail,
        ]);

        $repository->remove($userFromDB, true);

        $this->assertCount(0, $repository->findBy([
            'email' => $randomEmail,
        ]));
    }

    private function createRandomAdminUser(): User
    {
        $randomUser = new User();
        $randomUser->setEmail(Uuid::uuid4() . '@example.com');
        $randomUser->setRoles(['ROLE_ADMIN']);
        $randomUser->setPassword('irrelevant');

        return $randomUser;
    }

    private function persistAnAdminUserWithMail(string $email): User
    {
        $randomUser = new User();
        $randomUser->setEmail($email);
        $randomUser->setRoles(['ROLE_ADMIN']);
        $randomUser->setPassword('irrelevant');

        $repository = $this->entityManager
            ->getRepository(User::class);
        $repository->add($randomUser, true);

        return $randomUser;
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}

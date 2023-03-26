<?php declare(strict_types=1);

namespace JobPosting\Tests\Integration\Adapter\Persistence\Doctrine;

use JobPosting\Application\Model\JobPost\JobPost;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MySqlJobPostRepositoryTest extends KernelTestCase
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

    public function testCanPersistAJobPost()
    {
        $repository = $this->entityManager
            ->getRepository(JobPost::class);
        $aJobPost = $this->createRandomJobPost();
        $expectedId = $aJobPost->getId();

        $repository->add($aJobPost, true);

        $userFromDB = $repository->findOneBy([
            'id' => $expectedId,
        ]);
        $this->assertSame($expectedId, $userFromDB->getId());
    }

    public function testCanRemoveAJobPost()
    {
        $aJobPost = $this->createRandomJobPost();
        $this->persistAJobPost($aJobPost);

        $repository = $this->entityManager
            ->getRepository(JobPost::class);
        $jobPostFromDB = $repository->findOneBy([
            'id' => $aJobPost->getId(),
        ]);

        $repository->remove($jobPostFromDB, true);

        $this->assertCount(0, $repository->findBy([
            'id' => $aJobPost->getId(),
        ]));
    }

    private function createRandomJobPost(): JobPost
    {
        $randomJobPost = new JobPost(Uuid::uuid4(), 'foobar');
        $randomJobPost->setDescription('foobar');

        return $randomJobPost;
    }

    private function persistAJobPost(JobPost $jobPost): void
    {
        $repository = $this->entityManager
            ->getRepository(JobPost::class);
        $repository->add($jobPost, true);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}

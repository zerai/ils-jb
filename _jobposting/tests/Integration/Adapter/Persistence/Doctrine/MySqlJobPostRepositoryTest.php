<?php declare(strict_types=1);

namespace JobPosting\Tests\Integration\Adapter\Persistence\Doctrine;

use JobPosting\Application\Model\JobPost\JobPost;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use function Zenstruck\Foundry\repository;

/**
 * @covers \JobPosting\Adapter\Persistence\Doctrine\MySqlJobPostRepository
 */
class MySqlJobPostRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface|null
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

    /*
     * READSIDE QUERYS
     */
    public function testFindPublishedJobPost(): void
    {
        $repositoryHelper = repository(JobPost::class);
        $repositoryHelper->truncate();

        $anActiveJobPost = $this->createRandomJobPost();
        $anActiveJobPost->setPublicationStart(new \DateTimeImmutable('now'));
        $anActiveJobPost->setPublicationEnd(new \DateTimeImmutable('now'));
        $this->persistAJobPost($anActiveJobPost);

        $anExpiredJobPost = $this->createRandomJobPost();
        $anExpiredJobPost->setPublicationStart(new \DateTimeImmutable('- 2 days'));
        $anExpiredJobPost->setPublicationEnd(new \DateTimeImmutable('- 2 days'));
        $this->persistAJobPost($anExpiredJobPost);

        $aScheduledJobPost = $this->createRandomJobPost();
        $aScheduledJobPost->setPublicationStart(new \DateTimeImmutable('+ 2 days'));
        $aScheduledJobPost->setPublicationEnd(new \DateTimeImmutable('+ 4 days'));
        $this->persistAJobPost($aScheduledJobPost);

        $repository = $this->entityManager
            ->getRepository(JobPost::class);

        $jobPostsFromDB = $repository->findPublishedJobPost();

        $this->assertCount(1, $jobPostsFromDB);
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

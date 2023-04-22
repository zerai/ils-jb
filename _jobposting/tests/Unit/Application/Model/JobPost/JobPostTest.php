<?php declare(strict_types=1);

namespace JobPosting\Tests\Unit\Application\Model\JobPost;

use JobPosting\Application\Model\JobPost\JobPost;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class JobPostTest extends TestCase
{
    public function testShouldExposeIdentity(): void
    {
        $expectedIdentity = Uuid::uuid4();
        $jobPost = new JobPost($expectedIdentity, 'a title');

        self::assertEquals($expectedIdentity, $jobPost->getId());
    }

    public function testShouldExposeTitle(): void
    {
        $expectedTitle = 'a title';
        $jobPost = new JobPost(Uuid::uuid4(), $expectedTitle);

        self::assertEquals($expectedTitle, $jobPost->getTitle());
    }

    public function testShouldChangeTitle(): void
    {
        $expectedTitle = 'a new title';
        $jobPost = new JobPost(Uuid::uuid4(), 'a title');

        $jobPost->setTitle($expectedTitle);

        self::assertEquals($expectedTitle, $jobPost->getTitle());
    }

    public function testShouldChangeDescription(): void
    {
        $expectedDescription = 'a new description';
        $jobPost = new JobPost(Uuid::uuid4(), 'a title');

        $jobPost->setDescription($expectedDescription);

        self::assertEquals($expectedDescription, $jobPost->getDescription());
    }

    public function testPublicationDateShouldBeNullAsDefault(): void
    {
        $jobPost = new JobPost(Uuid::uuid4(), 'a title');

        self::assertNull($jobPost->getPublicationStart());
    }

    public function testShouldChangePublicationDate(): void
    {
        $jobPost = new JobPost(Uuid::uuid4(), 'a title');

        $jobPost->setPublicationStart(new \DateTimeImmutable('now'));

        self::assertNotNull($jobPost->getPublicationStart());
    }

    public function testExpirationDateShouldBeNullAsDefault(): void
    {
        $jobPost = new JobPost(Uuid::uuid4(), 'a title');

        self::assertNull($jobPost->getPublicationEnd());
    }

    public function testShouldChangeExpirationDate(): void
    {
        $jobPost = new JobPost(Uuid::uuid4(), 'a title');

        $jobPost->setPublicationStart(new \DateTimeImmutable('now'));

        $jobPost->setPublicationEnd(new \DateTimeImmutable('tomorrow'));

        self::assertNotNull($jobPost->getPublicationEnd());
    }
}

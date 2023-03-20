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
}

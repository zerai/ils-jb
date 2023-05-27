<?php declare(strict_types=1);

namespace App\DataFixtures\Dev;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use JobPosting\Application\Model\JobPost\JobPost;
use Ramsey\Uuid\Uuid;

class JobPostFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 20; $i++) {
            $jobPost = $this->createRandomJobPost();

            $manager->persist($jobPost);

            $manager->flush();
        }
    }

    public static function getGroups(): array
    {
        return ['dev', 'devJobPost'];
    }

    private function createRandomJobPost(): JobPost
    {
        $randomJobPost = new JobPost(Uuid::uuid4(), 'foobar');
        $randomJobPost->setDescription('foobar');
        $randomJobPost->setPublicationStart(new \DateTimeImmutable('now'));
        $randomJobPost->setPublicationEnd(new \DateTimeImmutable('now'));

        return $randomJobPost;
    }
}

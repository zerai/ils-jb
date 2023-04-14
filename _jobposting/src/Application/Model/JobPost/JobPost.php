<?php declare(strict_types=1);

namespace JobPosting\Application\Model\JobPost;

use Ramsey\Uuid\UuidInterface;

class JobPost
{
    private UuidInterface $id;

    private string $title;

    private string $description;

    private ?\DateTimeImmutable $publicationStart = null;

    private ?\DateTimeImmutable $publicationEnd = null;

    public function __construct(UuidInterface $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPublicationStart(): ?\DateTimeImmutable
    {
        return $this->publicationStart;
    }

    public function setPublicationStart(\DateTimeImmutable $publicationStart): void
    {
        $this->publicationStart = $publicationStart;
    }

    public function getPublicationEnd(): ?\DateTimeImmutable
    {
        return $this->publicationEnd;
    }

    public function setPublicationEnd(\DateTimeImmutable $publicationEnd): void
    {
        $this->publicationEnd = $publicationEnd;
    }
}

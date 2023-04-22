<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230422145438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'JobPost Entity (step-2) - need squash';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jobpost ADD publication_start DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', ADD publication_end DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jobpost DROP publication_start, DROP publication_end');
    }
}

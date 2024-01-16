<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240114161653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE criteria ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE criteria ADD CONSTRAINT FK_B61F9B81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B61F9B81A76ED395 ON criteria (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE criteria DROP FOREIGN KEY FK_B61F9B81A76ED395');
        $this->addSql('DROP INDEX IDX_B61F9B81A76ED395 ON criteria');
        $this->addSql('ALTER TABLE criteria DROP user_id');
    }
}

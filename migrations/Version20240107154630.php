<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240107154630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE process ADD collaborateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D1896A848E3B1 FOREIGN KEY (collaborateur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_861D1896A848E3B1 ON process (collaborateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D1896A848E3B1');
        $this->addSql('DROP INDEX IDX_861D1896A848E3B1 ON process');
        $this->addSql('ALTER TABLE process DROP collaborateur_id');
    }
}

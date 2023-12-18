<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215160114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9CFE419E2');
        $this->addSql('DROP INDEX UNIQ_1483A5E9CFE419E2 ON users');
        $this->addSql('ALTER TABLE users CHANGE cv_id curriculum_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E95AEA4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E95AEA4428 ON users (curriculum_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E95AEA4428');
        $this->addSql('DROP INDEX UNIQ_1483A5E95AEA4428 ON users');
        $this->addSql('ALTER TABLE users CHANGE curriculum_id cv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9CFE419E2 FOREIGN KEY (cv_id) REFERENCES curriculum_vitae (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9CFE419E2 ON users (cv_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214203143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE process ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D189667B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_861D189667B3B43D ON process (users_id)');
        $this->addSql('ALTER TABLE users ADD contact_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9E7A1254A ON users (contact_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9E7A1254A');
        $this->addSql('DROP INDEX IDX_1483A5E9E7A1254A ON users');
        $this->addSql('ALTER TABLE users DROP contact_id');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D189667B3B43D');
        $this->addSql('DROP INDEX IDX_861D189667B3B43D ON process');
        $this->addSql('ALTER TABLE process DROP users_id');
    }
}

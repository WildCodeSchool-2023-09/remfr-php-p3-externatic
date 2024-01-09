<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240105152557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE additional_info ADD interests VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE company DROP details');
        $this->addSql('ALTER TABLE curriculum_vitae ADD curriculum VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD cv_file_path VARCHAR(255) DEFAULT NULL, DROP interests');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE additional_info DROP interests');
        $this->addSql('ALTER TABLE company ADD details LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE curriculum_vitae ADD interests VARCHAR(255) NOT NULL, DROP curriculum, DROP updated_at, DROP cv_file_path');
    }
}

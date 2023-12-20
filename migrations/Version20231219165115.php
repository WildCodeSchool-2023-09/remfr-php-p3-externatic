<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219165115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE curriculum_vitae_education (curriculum_vitae_id INT NOT NULL, education_id INT NOT NULL, INDEX IDX_84F508084AF29A35 (curriculum_vitae_id), INDEX IDX_84F508082CA1BD71 (education_id), PRIMARY KEY(curriculum_vitae_id, education_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE curriculum_vitae_education ADD CONSTRAINT FK_84F508084AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_education ADD CONSTRAINT FK_84F508082CA1BD71 FOREIGN KEY (education_id) REFERENCES education (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE education DROP FOREIGN KEY FK_DB0A5ED24AF29A35');
        $this->addSql('DROP INDEX IDX_DB0A5ED24AF29A35 ON education');
        $this->addSql('ALTER TABLE education DROP curriculum_vitae_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE curriculum_vitae_education DROP FOREIGN KEY FK_84F508084AF29A35');
        $this->addSql('ALTER TABLE curriculum_vitae_education DROP FOREIGN KEY FK_84F508082CA1BD71');
        $this->addSql('DROP TABLE curriculum_vitae_education');
        $this->addSql('ALTER TABLE education ADD curriculum_vitae_id INT NOT NULL');
        $this->addSql('ALTER TABLE education ADD CONSTRAINT FK_DB0A5ED24AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DB0A5ED24AF29A35 ON education (curriculum_vitae_id)');
    }
}

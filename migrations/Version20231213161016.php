<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231213161016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE curriculum_vitae ADD additional_infos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE curriculum_vitae ADD CONSTRAINT FK_1FC99844EE9BF01C FOREIGN KEY (additional_infos_id) REFERENCES additional_info (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1FC99844EE9BF01C ON curriculum_vitae (additional_infos_id)');
        $this->addSql('ALTER TABLE education ADD curriculum_vitae_id INT NOT NULL');
        $this->addSql('ALTER TABLE education ADD CONSTRAINT FK_DB0A5ED24AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('CREATE INDEX IDX_DB0A5ED24AF29A35 ON education (curriculum_vitae_id)');
        $this->addSql('ALTER TABLE experience ADD curriculum_vitae_id INT NOT NULL');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C1034AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('CREATE INDEX IDX_590C1034AF29A35 ON experience (curriculum_vitae_id)');
        $this->addSql('ALTER TABLE language ADD curriculum_vitae_id INT NOT NULL');
        $this->addSql('ALTER TABLE language ADD CONSTRAINT FK_D4DB71B54AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('CREATE INDEX IDX_D4DB71B54AF29A35 ON language (curriculum_vitae_id)');
        $this->addSql('ALTER TABLE links ADD curriculum_vitae_id INT NOT NULL');
        $this->addSql('ALTER TABLE links ADD CONSTRAINT FK_D182A1184AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('CREATE INDEX IDX_D182A1184AF29A35 ON links (curriculum_vitae_id)');
        $this->addSql('ALTER TABLE skill ADD curriculum_vitae_id INT NOT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE4774AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE4774AF29A35 ON skill (curriculum_vitae_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE links DROP FOREIGN KEY FK_D182A1184AF29A35');
        $this->addSql('DROP INDEX IDX_D182A1184AF29A35 ON links');
        $this->addSql('ALTER TABLE links DROP curriculum_vitae_id');
        $this->addSql('ALTER TABLE education DROP FOREIGN KEY FK_DB0A5ED24AF29A35');
        $this->addSql('DROP INDEX IDX_DB0A5ED24AF29A35 ON education');
        $this->addSql('ALTER TABLE education DROP curriculum_vitae_id');
        $this->addSql('ALTER TABLE language DROP FOREIGN KEY FK_D4DB71B54AF29A35');
        $this->addSql('DROP INDEX IDX_D4DB71B54AF29A35 ON language');
        $this->addSql('ALTER TABLE language DROP curriculum_vitae_id');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C1034AF29A35');
        $this->addSql('DROP INDEX IDX_590C1034AF29A35 ON experience');
        $this->addSql('ALTER TABLE experience DROP curriculum_vitae_id');
        $this->addSql('ALTER TABLE curriculum_vitae DROP FOREIGN KEY FK_1FC99844EE9BF01C');
        $this->addSql('DROP INDEX UNIQ_1FC99844EE9BF01C ON curriculum_vitae');
        $this->addSql('ALTER TABLE curriculum_vitae DROP additional_infos_id');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE4774AF29A35');
        $this->addSql('DROP INDEX IDX_5E3DE4774AF29A35 ON skill');
        $this->addSql('ALTER TABLE skill DROP curriculum_vitae_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219174236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE curriculum_vitae_language (curriculum_vitae_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_2E05A38C4AF29A35 (curriculum_vitae_id), INDEX IDX_2E05A38C82F1BAF4 (language_id), PRIMARY KEY(curriculum_vitae_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curriculum_vitae_skill (curriculum_vitae_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_BD8569814AF29A35 (curriculum_vitae_id), INDEX IDX_BD8569815585C142 (skill_id), PRIMARY KEY(curriculum_vitae_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curriculum_vitae_links (curriculum_vitae_id INT NOT NULL, links_id INT NOT NULL, INDEX IDX_323A2CEE4AF29A35 (curriculum_vitae_id), INDEX IDX_323A2CEEC0DE588D (links_id), PRIMARY KEY(curriculum_vitae_id, links_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curriculum_vitae_experience (curriculum_vitae_id INT NOT NULL, experience_id INT NOT NULL, INDEX IDX_63C9059F4AF29A35 (curriculum_vitae_id), INDEX IDX_63C9059F46E90E27 (experience_id), PRIMARY KEY(curriculum_vitae_id, experience_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE curriculum_vitae_language ADD CONSTRAINT FK_2E05A38C4AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_language ADD CONSTRAINT FK_2E05A38C82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_skill ADD CONSTRAINT FK_BD8569814AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_skill ADD CONSTRAINT FK_BD8569815585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_links ADD CONSTRAINT FK_323A2CEE4AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_links ADD CONSTRAINT FK_323A2CEEC0DE588D FOREIGN KEY (links_id) REFERENCES links (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_experience ADD CONSTRAINT FK_63C9059F4AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_experience ADD CONSTRAINT FK_63C9059F46E90E27 FOREIGN KEY (experience_id) REFERENCES experience (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae DROP FOREIGN KEY FK_1FC99844EE9BF01C');
        $this->addSql('DROP INDEX UNIQ_1FC99844EE9BF01C ON curriculum_vitae');
        $this->addSql('ALTER TABLE curriculum_vitae DROP additional_infos_id');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C1034AF29A35');
        $this->addSql('DROP INDEX IDX_590C1034AF29A35 ON experience');
        $this->addSql('ALTER TABLE experience DROP curriculum_vitae_id');
        $this->addSql('ALTER TABLE language DROP FOREIGN KEY FK_D4DB71B54AF29A35');
        $this->addSql('DROP INDEX IDX_D4DB71B54AF29A35 ON language');
        $this->addSql('ALTER TABLE language DROP curriculum_vitae_id');
        $this->addSql('ALTER TABLE links DROP FOREIGN KEY FK_D182A1184AF29A35');
        $this->addSql('DROP INDEX IDX_D182A1184AF29A35 ON links');
        $this->addSql('ALTER TABLE links DROP curriculum_vitae_id');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE4774AF29A35');
        $this->addSql('DROP INDEX IDX_5E3DE4774AF29A35 ON skill');
        $this->addSql('ALTER TABLE skill DROP curriculum_vitae_id');
        $this->addSql('ALTER TABLE user ADD additional_info_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495C01120C FOREIGN KEY (additional_info_id) REFERENCES additional_info (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495C01120C ON user (additional_info_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE curriculum_vitae_language DROP FOREIGN KEY FK_2E05A38C4AF29A35');
        $this->addSql('ALTER TABLE curriculum_vitae_language DROP FOREIGN KEY FK_2E05A38C82F1BAF4');
        $this->addSql('ALTER TABLE curriculum_vitae_skill DROP FOREIGN KEY FK_BD8569814AF29A35');
        $this->addSql('ALTER TABLE curriculum_vitae_skill DROP FOREIGN KEY FK_BD8569815585C142');
        $this->addSql('ALTER TABLE curriculum_vitae_links DROP FOREIGN KEY FK_323A2CEE4AF29A35');
        $this->addSql('ALTER TABLE curriculum_vitae_links DROP FOREIGN KEY FK_323A2CEEC0DE588D');
        $this->addSql('ALTER TABLE curriculum_vitae_experience DROP FOREIGN KEY FK_63C9059F4AF29A35');
        $this->addSql('ALTER TABLE curriculum_vitae_experience DROP FOREIGN KEY FK_63C9059F46E90E27');
        $this->addSql('DROP TABLE curriculum_vitae_language');
        $this->addSql('DROP TABLE curriculum_vitae_skill');
        $this->addSql('DROP TABLE curriculum_vitae_links');
        $this->addSql('DROP TABLE curriculum_vitae_experience');
        $this->addSql('ALTER TABLE curriculum_vitae ADD additional_infos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE curriculum_vitae ADD CONSTRAINT FK_1FC99844EE9BF01C FOREIGN KEY (additional_infos_id) REFERENCES additional_info (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1FC99844EE9BF01C ON curriculum_vitae (additional_infos_id)');
        $this->addSql('ALTER TABLE language ADD curriculum_vitae_id INT NOT NULL');
        $this->addSql('ALTER TABLE language ADD CONSTRAINT FK_D4DB71B54AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D4DB71B54AF29A35 ON language (curriculum_vitae_id)');
        $this->addSql('ALTER TABLE experience ADD curriculum_vitae_id INT NOT NULL');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C1034AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_590C1034AF29A35 ON experience (curriculum_vitae_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495C01120C');
        $this->addSql('DROP INDEX UNIQ_8D93D6495C01120C ON user');
        $this->addSql('ALTER TABLE user DROP additional_info_id');
        $this->addSql('ALTER TABLE skill ADD curriculum_vitae_id INT NOT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE4774AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5E3DE4774AF29A35 ON skill (curriculum_vitae_id)');
        $this->addSql('ALTER TABLE links ADD curriculum_vitae_id INT NOT NULL');
        $this->addSql('ALTER TABLE links ADD CONSTRAINT FK_D182A1184AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D182A1184AF29A35 ON links (curriculum_vitae_id)');
    }
}

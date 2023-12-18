<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214203747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offer_criteria (offer_id INT NOT NULL, criteria_id INT NOT NULL, INDEX IDX_CF622BE353C674EE (offer_id), INDEX IDX_CF622BE3990BEA15 (criteria_id), PRIMARY KEY(offer_id, criteria_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_criteria (user_id INT NOT NULL, criteria_id INT NOT NULL, INDEX IDX_CD5EB05B67B3B43D (_id), INDEX IDX_CD5EB05B990BEA15 (criteria_id), PRIMARY KEY(user_id, criteria_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offer_criteria ADD CONSTRAINT FK_CF622BE353C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer_criteria ADD CONSTRAINT FK_CF622BE3990BEA15 FOREIGN KEY (criteria_id) REFERENCES criteria (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_criteria ADD CONSTRAINT FK_CD5EB05B67B3B43D FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_criteria ADD CONSTRAINT FK_CD5EB05B990BEA15 FOREIGN KEY (criteria_id) REFERENCES criteria (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD cv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_1483A5E9CFE419E2 FOREIGN KEY (cv_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9CFE419E2 ON user (cv_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offer_criteria DROP FOREIGN KEY FK_CF622BE353C674EE');
        $this->addSql('ALTER TABLE offer_criteria DROP FOREIGN KEY FK_CF622BE3990BEA15');
        $this->addSql('ALTER TABLE user_criteria DROP FOREIGN KEY FK_CD5EB05B67B3B43D');
        $this->addSql('ALTER TABLE user_criteria DROP FOREIGN KEY FK_CD5EB05B990BEA15');
        $this->addSql('DROP TABLE offer_criteria');
        $this->addSql('DROP TABLE user_criteria');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_1483A5E9CFE419E2');
        $this->addSql('DROP INDEX UNIQ_1483A5E9CFE419E2 ON user');
        $this->addSql('ALTER TABLE user DROP cv_id');
    }
}

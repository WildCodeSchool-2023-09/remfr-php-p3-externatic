<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231221093432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, recipient_id INT NOT NULL, title VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_read TINYINT(1) NOT NULL, INDEX IDX_DB021E96F624B39D (sender_id), INDEX IDX_DB021E96E92F8F78 (recipient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_criteria (offer_id INT NOT NULL, criteria_id INT NOT NULL, INDEX IDX_CF622BE353C674EE (offer_id), INDEX IDX_CF622BE3990BEA15 (criteria_id), PRIMARY KEY(offer_id, criteria_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_offer (user_id INT NOT NULL, offer_id INT NOT NULL, INDEX IDX_CB147C66A76ED395 (user_id), INDEX IDX_CB147C6653C674EE (offer_id), PRIMARY KEY(user_id, offer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_criteria (user_id INT NOT NULL, criteria_id INT NOT NULL, INDEX IDX_56927F81A76ED395 (user_id), INDEX IDX_56927F81990BEA15 (criteria_id), PRIMARY KEY(user_id, criteria_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_contact (user_id INT NOT NULL, contact_id INT NOT NULL, INDEX IDX_146FF832A76ED395 (user_id), INDEX IDX_146FF832E7A1254A (contact_id), PRIMARY KEY(user_id, contact_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96F624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96E92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offer_criteria ADD CONSTRAINT FK_CF622BE353C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer_criteria ADD CONSTRAINT FK_CF622BE3990BEA15 FOREIGN KEY (criteria_id) REFERENCES criteria (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_offer ADD CONSTRAINT FK_CB147C66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_offer ADD CONSTRAINT FK_CB147C6653C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_criteria ADD CONSTRAINT FK_56927F81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_criteria ADD CONSTRAINT FK_56927F81990BEA15 FOREIGN KEY (criteria_id) REFERENCES criteria (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_contact ADD CONSTRAINT FK_146FF832A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_contact ADD CONSTRAINT FK_146FF832E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer ADD company_id INT NOT NULL');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_29D6873E979B1AD6 ON offer (company_id)');
        $this->addSql('ALTER TABLE process ADD offer_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D189653C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D1896A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_861D189653C674EE ON process (offer_id)');
        $this->addSql('CREATE INDEX IDX_861D1896A76ED395 ON process (user_id)');
        $this->addSql('ALTER TABLE user ADD curriculum_id INT DEFAULT NULL, ADD roles JSON NOT NULL, ADD is_verified TINYINT(1) NOT NULL, DROP rule, CHANGE email email VARCHAR(180) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE marital_status marital_status INT DEFAULT NULL, CHANGE adresse address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495AEA4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495AEA4428 ON user (curriculum_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96F624B39D');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96E92F8F78');
        $this->addSql('ALTER TABLE offer_criteria DROP FOREIGN KEY FK_CF622BE353C674EE');
        $this->addSql('ALTER TABLE offer_criteria DROP FOREIGN KEY FK_CF622BE3990BEA15');
        $this->addSql('ALTER TABLE user_offer DROP FOREIGN KEY FK_CB147C66A76ED395');
        $this->addSql('ALTER TABLE user_offer DROP FOREIGN KEY FK_CB147C6653C674EE');
        $this->addSql('ALTER TABLE user_criteria DROP FOREIGN KEY FK_56927F81A76ED395');
        $this->addSql('ALTER TABLE user_criteria DROP FOREIGN KEY FK_56927F81990BEA15');
        $this->addSql('ALTER TABLE user_contact DROP FOREIGN KEY FK_146FF832A76ED395');
        $this->addSql('ALTER TABLE user_contact DROP FOREIGN KEY FK_146FF832E7A1254A');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE offer_criteria');
        $this->addSql('DROP TABLE user_offer');
        $this->addSql('DROP TABLE user_criteria');
        $this->addSql('DROP TABLE user_contact');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495AEA4428');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D6495AEA4428 ON user');
        $this->addSql('ALTER TABLE user ADD rule VARCHAR(50) NOT NULL, DROP curriculum_id, DROP roles, DROP is_verified, CHANGE email email VARCHAR(50) NOT NULL, CHANGE marital_status marital_status VARCHAR(50) DEFAULT NULL, CHANGE password password VARCHAR(50) NOT NULL, CHANGE address adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D189653C674EE');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D1896A76ED395');
        $this->addSql('DROP INDEX IDX_861D189653C674EE ON process');
        $this->addSql('DROP INDEX IDX_861D1896A76ED395 ON process');
        $this->addSql('ALTER TABLE process DROP offer_id, DROP user_id');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E979B1AD6');
        $this->addSql('DROP INDEX IDX_29D6873E979B1AD6 ON offer');
        $this->addSql('ALTER TABLE offer DROP company_id');
    }
}

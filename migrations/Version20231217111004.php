<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231217111004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D189667B3B43D');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, contact_id INT DEFAULT NULL, curriculum_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, zipcode INT DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, contact_preference VARCHAR(50) NOT NULL, birthdate DATE DEFAULT NULL, nationality VARCHAR(100) DEFAULT NULL, marital_status INT DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649E7A1254A (contact_id), UNIQUE INDEX UNIQ_8D93D6495AEA4428 (curriculum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_offer (user_id INT NOT NULL, offer_id INT NOT NULL, INDEX IDX_CB147C66A76ED395 (user_id), INDEX IDX_CB147C6653C674EE (offer_id), PRIMARY KEY(user_id, offer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_criteria (user_id INT NOT NULL, criteria_id INT NOT NULL, INDEX IDX_56927F81A76ED395 (user_id), INDEX IDX_56927F81990BEA15 (criteria_id), PRIMARY KEY(user_id, criteria_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495AEA4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('ALTER TABLE user_offer ADD CONSTRAINT FK_CB147C66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_offer ADD CONSTRAINT FK_CB147C6653C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_criteria ADD CONSTRAINT FK_56927F81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_criteria ADD CONSTRAINT FK_56927F81990BEA15 FOREIGN KEY (criteria_id) REFERENCES criteria (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_offer DROP FOREIGN KEY FK_CEA1237753C674EE');
        $this->addSql('ALTER TABLE users_offer DROP FOREIGN KEY FK_CEA1237767B3B43D');
        $this->addSql('ALTER TABLE users_criteria DROP FOREIGN KEY FK_CD5EB05B67B3B43D');
        $this->addSql('ALTER TABLE users_criteria DROP FOREIGN KEY FK_CD5EB05B990BEA15');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E95AEA4428');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9E7A1254A');
        $this->addSql('DROP TABLE users_offer');
        $this->addSql('DROP TABLE users_criteria');
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D189667B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D189667B3B43D');
        $this->addSql('CREATE TABLE users_offer (users_id INT NOT NULL, offer_id INT NOT NULL, INDEX IDX_CEA1237753C674EE (offer_id), INDEX IDX_CEA1237767B3B43D (users_id), PRIMARY KEY(users_id, offer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users_criteria (users_id INT NOT NULL, criteria_id INT NOT NULL, INDEX IDX_CD5EB05B67B3B43D (users_id), INDEX IDX_CD5EB05B990BEA15 (criteria_id), PRIMARY KEY(users_id, criteria_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, contact_id INT DEFAULT NULL, curriculum_id INT DEFAULT NULL, firstname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lastname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, phone INT DEFAULT NULL, password VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, zipcode INT DEFAULT NULL, city VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, rule VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, contact_preference VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, birthdate DATE DEFAULT NULL, nationality VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, marital_status VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_1483A5E9E7A1254A (contact_id), UNIQUE INDEX UNIQ_1483A5E95AEA4428 (curriculum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE users_offer ADD CONSTRAINT FK_CEA1237753C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_offer ADD CONSTRAINT FK_CEA1237767B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_criteria ADD CONSTRAINT FK_CD5EB05B67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_criteria ADD CONSTRAINT FK_CD5EB05B990BEA15 FOREIGN KEY (criteria_id) REFERENCES criteria (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E95AEA4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum_vitae (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E7A1254A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495AEA4428');
        $this->addSql('ALTER TABLE user_offer DROP FOREIGN KEY FK_CB147C66A76ED395');
        $this->addSql('ALTER TABLE user_offer DROP FOREIGN KEY FK_CB147C6653C674EE');
        $this->addSql('ALTER TABLE user_criteria DROP FOREIGN KEY FK_56927F81A76ED395');
        $this->addSql('ALTER TABLE user_criteria DROP FOREIGN KEY FK_56927F81990BEA15');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_offer');
        $this->addSql('DROP TABLE user_criteria');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D189667B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}

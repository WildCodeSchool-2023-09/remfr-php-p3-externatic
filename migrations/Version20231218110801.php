<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218110801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE additional_info (id INT AUTO_INCREMENT NOT NULL, birthdate DATE NOT NULL, nationality VARCHAR(255) NOT NULL, gender INT NOT NULL, license VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, field VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE criteria (id INT AUTO_INCREMENT NOT NULL, salary VARCHAR(255) NOT NULL, profil VARCHAR(255) NOT NULL, contract INT NOT NULL, location VARCHAR(255) NOT NULL, remote INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curriculum_vitae (id INT AUTO_INCREMENT NOT NULL, additional_infos_id INT DEFAULT NULL, interests VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1FC99844EE9BF01C (additional_infos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, curriculum_vitae_id INT NOT NULL, name VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, begin_date DATE NOT NULL, end_date DATE DEFAULT NULL, INDEX IDX_590C1034AF29A35 (curriculum_vitae_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, phone INT DEFAULT NULL, password VARCHAR(50) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, zipcode INT DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, rule VARCHAR(50) NOT NULL, contact_preference VARCHAR(50) NOT NULL, birthdate DATE DEFAULT NULL, nationality VARCHAR(100) DEFAULT NULL, marital_status VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE curriculum_vitae ADD CONSTRAINT FK_1FC99844EE9BF01C FOREIGN KEY (additional_infos_id) REFERENCES additional_info (id)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C1034AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('DROP TABLE additionnalinfo');
        $this->addSql('DROP TABLE criteres');
        $this->addSql('DROP TABLE compagny');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE cv');
        $this->addSql('DROP TABLE offer');
        $this->addSql('ALTER TABLE contact MODIFY idcontact INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON contact');
        $this->addSql('ALTER TABLE contact CHANGE message message VARCHAR(500) NOT NULL, CHANGE date date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE idcontact id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE contact ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE education MODIFY idEducation INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON education');
        $this->addSql('ALTER TABLE education ADD curriculum_vitae_id INT NOT NULL, ADD begin_date DATETIME NOT NULL, ADD end_date DATETIME DEFAULT NULL, DROP beginDate, DROP endDate, CHANGE idEducation id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE education ADD CONSTRAINT FK_DB0A5ED24AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('CREATE INDEX IDX_DB0A5ED24AF29A35 ON education (curriculum_vitae_id)');
        $this->addSql('ALTER TABLE education ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE language MODIFY idLanguage INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON language');
        $this->addSql('ALTER TABLE language ADD curriculum_vitae_id INT NOT NULL, CHANGE idLanguage id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE language ADD CONSTRAINT FK_D4DB71B54AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('CREATE INDEX IDX_D4DB71B54AF29A35 ON language (curriculum_vitae_id)');
        $this->addSql('ALTER TABLE language ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE links MODIFY idLinks INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON links');
        $this->addSql('ALTER TABLE links ADD curriculum_vitae_id INT NOT NULL, CHANGE linkedin linkedin VARCHAR(255) NOT NULL, CHANGE idLinks id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE links ADD CONSTRAINT FK_D182A1184AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('CREATE INDEX IDX_D182A1184AF29A35 ON links (curriculum_vitae_id)');
        $this->addSql('ALTER TABLE links ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE process MODIFY idProcess INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON process');
        $this->addSql('ALTER TABLE process CHANGE idProcess id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE process ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE skill MODIFY idSkill INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON skill');
        $this->addSql('ALTER TABLE skill ADD curriculum_vitae_id INT NOT NULL, CHANGE idSkill id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE4774AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE4774AF29A35 ON skill (curriculum_vitae_id)');
        $this->addSql('ALTER TABLE skill ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE education DROP FOREIGN KEY FK_DB0A5ED24AF29A35');
        $this->addSql('ALTER TABLE language DROP FOREIGN KEY FK_D4DB71B54AF29A35');
        $this->addSql('ALTER TABLE links DROP FOREIGN KEY FK_D182A1184AF29A35');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE4774AF29A35');
        $this->addSql('CREATE TABLE additionnalinfo (idadditionnalInfo INT AUTO_INCREMENT NOT NULL, birthdate DATETIME NOT NULL, nationality VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, gender INT NOT NULL, license VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(idadditionnalInfo)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE criteres (idCriteres INT AUTO_INCREMENT NOT NULL, salary VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, profil VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, contract INT NOT NULL, location VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(idCriteres)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE compagny (idCompagny INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, field VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, address VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(idCompagny)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lastname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, phone INT DEFAULT NULL, password VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, zipcode INT DEFAULT NULL, city VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, rule VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, contact_preference VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE cv (idCV INT AUTO_INCREMENT NOT NULL, interest VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(idCV)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE offer (idOffer INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, assignment VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, collaborator VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(idOffer)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'					\' ');
        $this->addSql('ALTER TABLE curriculum_vitae DROP FOREIGN KEY FK_1FC99844EE9BF01C');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C1034AF29A35');
        $this->addSql('DROP TABLE additional_info');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE criteria');
        $this->addSql('DROP TABLE curriculum_vitae');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE education MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX IDX_DB0A5ED24AF29A35 ON education');
        $this->addSql('DROP INDEX `PRIMARY` ON education');
        $this->addSql('ALTER TABLE education ADD endDate DATETIME NOT NULL, DROP curriculum_vitae_id, DROP end_date, CHANGE id idEducation INT AUTO_INCREMENT NOT NULL, CHANGE begin_date beginDate DATETIME NOT NULL');
        $this->addSql('ALTER TABLE education ADD PRIMARY KEY (idEducation)');
        $this->addSql('ALTER TABLE language MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX IDX_D4DB71B54AF29A35 ON language');
        $this->addSql('DROP INDEX `PRIMARY` ON language');
        $this->addSql('ALTER TABLE language DROP curriculum_vitae_id, CHANGE id idLanguage INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE language ADD PRIMARY KEY (idLanguage)');
        $this->addSql('ALTER TABLE process MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON process');
        $this->addSql('ALTER TABLE process CHANGE id idProcess INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE process ADD PRIMARY KEY (idProcess)');
        $this->addSql('ALTER TABLE links MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX IDX_D182A1184AF29A35 ON links');
        $this->addSql('DROP INDEX `PRIMARY` ON links');
        $this->addSql('ALTER TABLE links DROP curriculum_vitae_id, CHANGE linkedin linkedin VARCHAR(255) DEFAULT NULL, CHANGE id idLinks INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE links ADD PRIMARY KEY (idLinks)');
        $this->addSql('ALTER TABLE contact MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON contact');
        $this->addSql('ALTER TABLE contact CHANGE message message VARCHAR(255) NOT NULL, CHANGE date date DATETIME NOT NULL, CHANGE id idcontact INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE contact ADD PRIMARY KEY (idcontact)');
        $this->addSql('ALTER TABLE skill MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX IDX_5E3DE4774AF29A35 ON skill');
        $this->addSql('DROP INDEX `PRIMARY` ON skill');
        $this->addSql('ALTER TABLE skill DROP curriculum_vitae_id, CHANGE id idSkill INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE skill ADD PRIMARY KEY (idSkill)');
    }
}

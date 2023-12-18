<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214195410 extends AbstractMigration
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
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, message VARCHAR(500) NOT NULL, subject VARCHAR(255) NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE criteria (id INT AUTO_INCREMENT NOT NULL, salary VARCHAR(255) NOT NULL, profil VARCHAR(255) NOT NULL, contract INT NOT NULL, location VARCHAR(255) NOT NULL, remote INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curriculum_vitae (id INT AUTO_INCREMENT NOT NULL, additional_infos_id INT DEFAULT NULL, interests VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1FC99844EE9BF01C (additional_infos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE education (id INT AUTO_INCREMENT NOT NULL, curriculum_vitae_id INT NOT NULL, name VARCHAR(255) NOT NULL, school VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, begin_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, INDEX IDX_DB0A5ED24AF29A35 (curriculum_vitae_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, curriculum_vitae_id INT NOT NULL, name VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, begin_date DATE NOT NULL, end_date DATE DEFAULT NULL, INDEX IDX_590C1034AF29A35 (curriculum_vitae_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, curriculum_vitae_id INT NOT NULL, language VARCHAR(255) NOT NULL, level INT NOT NULL, INDEX IDX_D4DB71B54AF29A35 (curriculum_vitae_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE links (id INT AUTO_INCREMENT NOT NULL, curriculum_vitae_id INT NOT NULL, linkedin VARCHAR(255) NOT NULL, website VARCHAR(255) DEFAULT NULL, INDEX IDX_D182A1184AF29A35 (curriculum_vitae_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, assignment VARCHAR(255) NOT NULL, collaborator VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE process (id INT AUTO_INCREMENT NOT NULL, process INT NOT NULL, statut INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, curriculum_vitae_id INT NOT NULL, name VARCHAR(255) NOT NULL, level INT NOT NULL, INDEX IDX_5E3DE4774AF29A35 (curriculum_vitae_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, phone INT DEFAULT NULL, password VARCHAR(50) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, zipcode INT DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, rule VARCHAR(50) NOT NULL, contact_preference VARCHAR(50) NOT NULL, birthdate DATE DEFAULT NULL, nationality VARCHAR(100) DEFAULT NULL, marital_status VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE curriculum_vitae ADD CONSTRAINT FK_1FC99844EE9BF01C FOREIGN KEY (additional_infos_id) REFERENCES additional_info (id)');
        $this->addSql('ALTER TABLE education ADD CONSTRAINT FK_DB0A5ED24AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C1034AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('ALTER TABLE language ADD CONSTRAINT FK_D4DB71B54AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('ALTER TABLE links ADD CONSTRAINT FK_D182A1184AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE4774AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE curriculum_vitae DROP FOREIGN KEY FK_1FC99844EE9BF01C');
        $this->addSql('ALTER TABLE education DROP FOREIGN KEY FK_DB0A5ED24AF29A35');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C1034AF29A35');
        $this->addSql('ALTER TABLE language DROP FOREIGN KEY FK_D4DB71B54AF29A35');
        $this->addSql('ALTER TABLE links DROP FOREIGN KEY FK_D182A1184AF29A35');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE4774AF29A35');
        $this->addSql('DROP TABLE additional_info');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE criteria');
        $this->addSql('DROP TABLE curriculum_vitae');
        $this->addSql('DROP TABLE education');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE links');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE process');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

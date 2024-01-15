<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112090804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE additional_info (id INT AUTO_INCREMENT NOT NULL, birthdate DATE NOT NULL, nationality VARCHAR(255) NOT NULL, gender INT NOT NULL, license VARCHAR(255) DEFAULT NULL, interests VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, field VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, details LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, message VARCHAR(500) NOT NULL, subject VARCHAR(255) NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE criteria (id INT AUTO_INCREMENT NOT NULL, salary INT DEFAULT NULL, profil VARCHAR(255) DEFAULT NULL, contract INT DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, remote INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curriculum_vitae (id INT AUTO_INCREMENT NOT NULL, curriculum VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, cv_file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curriculum_vitae_education (curriculum_vitae_id INT NOT NULL, education_id INT NOT NULL, INDEX IDX_84F508084AF29A35 (curriculum_vitae_id), INDEX IDX_84F508082CA1BD71 (education_id), PRIMARY KEY(curriculum_vitae_id, education_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curriculum_vitae_language (curriculum_vitae_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_2E05A38C4AF29A35 (curriculum_vitae_id), INDEX IDX_2E05A38C82F1BAF4 (language_id), PRIMARY KEY(curriculum_vitae_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curriculum_vitae_skill (curriculum_vitae_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_BD8569814AF29A35 (curriculum_vitae_id), INDEX IDX_BD8569815585C142 (skill_id), PRIMARY KEY(curriculum_vitae_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curriculum_vitae_links (curriculum_vitae_id INT NOT NULL, links_id INT NOT NULL, INDEX IDX_323A2CEE4AF29A35 (curriculum_vitae_id), INDEX IDX_323A2CEEC0DE588D (links_id), PRIMARY KEY(curriculum_vitae_id, links_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curriculum_vitae_experience (curriculum_vitae_id INT NOT NULL, experience_id INT NOT NULL, INDEX IDX_63C9059F4AF29A35 (curriculum_vitae_id), INDEX IDX_63C9059F46E90E27 (experience_id), PRIMARY KEY(curriculum_vitae_id, experience_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE education (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, school VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, begin_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, begin_date DATE NOT NULL, end_date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, language VARCHAR(255) NOT NULL, level INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE links (id INT AUTO_INCREMENT NOT NULL, linkedin VARCHAR(255) NOT NULL, website VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, assignment VARCHAR(255) NOT NULL, collaborator VARCHAR(255) NOT NULL, min_salary INT NOT NULL, max_salary INT NOT NULL, contract_type INT NOT NULL, remote INT NOT NULL, INDEX IDX_29D6873E979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer_criteria (offer_id INT NOT NULL, criteria_id INT NOT NULL, INDEX IDX_CF622BE353C674EE (offer_id), INDEX IDX_CF622BE3990BEA15 (criteria_id), PRIMARY KEY(offer_id, criteria_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE process (id INT AUTO_INCREMENT NOT NULL, offer_id INT DEFAULT NULL, user_id INT DEFAULT NULL, collaborateur_id INT NOT NULL, process INT NOT NULL, statut INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_861D189653C674EE (offer_id), INDEX IDX_861D1896A76ED395 (user_id), INDEX IDX_861D1896A848E3B1 (collaborateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, level INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, curriculum_id INT DEFAULT NULL, additional_info_id INT DEFAULT NULL, collaborateur_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, zipcode VARCHAR(255) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, contact_preference VARCHAR(50) NOT NULL, birthdate DATE DEFAULT NULL, nationality VARCHAR(100) DEFAULT NULL, marital_status INT DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6495AEA4428 (curriculum_id), UNIQUE INDEX UNIQ_8D93D6495C01120C (additional_info_id), INDEX IDX_8D93D649A848E3B1 (collaborateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_offer (user_id INT NOT NULL, offer_id INT NOT NULL, INDEX IDX_CB147C66A76ED395 (user_id), INDEX IDX_CB147C6653C674EE (offer_id), PRIMARY KEY(user_id, offer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_criteria (user_id INT NOT NULL, criteria_id INT NOT NULL, INDEX IDX_56927F81A76ED395 (user_id), INDEX IDX_56927F81990BEA15 (criteria_id), PRIMARY KEY(user_id, criteria_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_contact (user_id INT NOT NULL, contact_id INT NOT NULL, INDEX IDX_146FF832A76ED395 (user_id), INDEX IDX_146FF832E7A1254A (contact_id), PRIMARY KEY(user_id, contact_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_favorites (user_id INT NOT NULL, offer_id INT NOT NULL, INDEX IDX_E489ED11A76ED395 (user_id), INDEX IDX_E489ED1153C674EE (offer_id), PRIMARY KEY(user_id, offer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE curriculum_vitae_education ADD CONSTRAINT FK_84F508084AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_education ADD CONSTRAINT FK_84F508082CA1BD71 FOREIGN KEY (education_id) REFERENCES education (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_language ADD CONSTRAINT FK_2E05A38C4AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_language ADD CONSTRAINT FK_2E05A38C82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_skill ADD CONSTRAINT FK_BD8569814AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_skill ADD CONSTRAINT FK_BD8569815585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_links ADD CONSTRAINT FK_323A2CEE4AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_links ADD CONSTRAINT FK_323A2CEEC0DE588D FOREIGN KEY (links_id) REFERENCES links (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_experience ADD CONSTRAINT FK_63C9059F4AF29A35 FOREIGN KEY (curriculum_vitae_id) REFERENCES curriculum_vitae (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE curriculum_vitae_experience ADD CONSTRAINT FK_63C9059F46E90E27 FOREIGN KEY (experience_id) REFERENCES experience (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE offer_criteria ADD CONSTRAINT FK_CF622BE353C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer_criteria ADD CONSTRAINT FK_CF622BE3990BEA15 FOREIGN KEY (criteria_id) REFERENCES criteria (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D189653C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D1896A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D1896A848E3B1 FOREIGN KEY (collaborateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495AEA4428 FOREIGN KEY (curriculum_id) REFERENCES curriculum_vitae (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495C01120C FOREIGN KEY (additional_info_id) REFERENCES additional_info (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A848E3B1 FOREIGN KEY (collaborateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_offer ADD CONSTRAINT FK_CB147C66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_offer ADD CONSTRAINT FK_CB147C6653C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_criteria ADD CONSTRAINT FK_56927F81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_criteria ADD CONSTRAINT FK_56927F81990BEA15 FOREIGN KEY (criteria_id) REFERENCES criteria (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_contact ADD CONSTRAINT FK_146FF832A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_contact ADD CONSTRAINT FK_146FF832E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_favorites ADD CONSTRAINT FK_E489ED11A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_favorites ADD CONSTRAINT FK_E489ED1153C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE curriculum_vitae_education DROP FOREIGN KEY FK_84F508084AF29A35');
        $this->addSql('ALTER TABLE curriculum_vitae_education DROP FOREIGN KEY FK_84F508082CA1BD71');
        $this->addSql('ALTER TABLE curriculum_vitae_language DROP FOREIGN KEY FK_2E05A38C4AF29A35');
        $this->addSql('ALTER TABLE curriculum_vitae_language DROP FOREIGN KEY FK_2E05A38C82F1BAF4');
        $this->addSql('ALTER TABLE curriculum_vitae_skill DROP FOREIGN KEY FK_BD8569814AF29A35');
        $this->addSql('ALTER TABLE curriculum_vitae_skill DROP FOREIGN KEY FK_BD8569815585C142');
        $this->addSql('ALTER TABLE curriculum_vitae_links DROP FOREIGN KEY FK_323A2CEE4AF29A35');
        $this->addSql('ALTER TABLE curriculum_vitae_links DROP FOREIGN KEY FK_323A2CEEC0DE588D');
        $this->addSql('ALTER TABLE curriculum_vitae_experience DROP FOREIGN KEY FK_63C9059F4AF29A35');
        $this->addSql('ALTER TABLE curriculum_vitae_experience DROP FOREIGN KEY FK_63C9059F46E90E27');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E979B1AD6');
        $this->addSql('ALTER TABLE offer_criteria DROP FOREIGN KEY FK_CF622BE353C674EE');
        $this->addSql('ALTER TABLE offer_criteria DROP FOREIGN KEY FK_CF622BE3990BEA15');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D189653C674EE');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D1896A76ED395');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D1896A848E3B1');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495AEA4428');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495C01120C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A848E3B1');
        $this->addSql('ALTER TABLE user_offer DROP FOREIGN KEY FK_CB147C66A76ED395');
        $this->addSql('ALTER TABLE user_offer DROP FOREIGN KEY FK_CB147C6653C674EE');
        $this->addSql('ALTER TABLE user_criteria DROP FOREIGN KEY FK_56927F81A76ED395');
        $this->addSql('ALTER TABLE user_criteria DROP FOREIGN KEY FK_56927F81990BEA15');
        $this->addSql('ALTER TABLE user_contact DROP FOREIGN KEY FK_146FF832A76ED395');
        $this->addSql('ALTER TABLE user_contact DROP FOREIGN KEY FK_146FF832E7A1254A');
        $this->addSql('ALTER TABLE user_favorites DROP FOREIGN KEY FK_E489ED11A76ED395');
        $this->addSql('ALTER TABLE user_favorites DROP FOREIGN KEY FK_E489ED1153C674EE');
        $this->addSql('DROP TABLE additional_info');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE criteria');
        $this->addSql('DROP TABLE curriculum_vitae');
        $this->addSql('DROP TABLE curriculum_vitae_education');
        $this->addSql('DROP TABLE curriculum_vitae_language');
        $this->addSql('DROP TABLE curriculum_vitae_skill');
        $this->addSql('DROP TABLE curriculum_vitae_links');
        $this->addSql('DROP TABLE curriculum_vitae_experience');
        $this->addSql('DROP TABLE education');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE links');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE offer_criteria');
        $this->addSql('DROP TABLE process');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_offer');
        $this->addSql('DROP TABLE user_criteria');
        $this->addSql('DROP TABLE user_contact');
        $this->addSql('DROP TABLE user_favorites');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

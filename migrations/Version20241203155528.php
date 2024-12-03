<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241203155528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_C7440455A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE drug (id INT AUTO_INCREMENT NOT NULL, date_of_receipt DATE NOT NULL, document_name VARCHAR(255) NOT NULL, amount INT NOT NULL, manufacture_date DATE NOT NULL, expiration_date DATE NOT NULL, series VARCHAR(255) NOT NULL, where_obtained_from VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE drug_patient (drug_id INT NOT NULL, patient_id INT NOT NULL, INDEX IDX_D51D3164AABCA765 (drug_id), INDEX IDX_D51D31646B899279 (patient_id), PRIMARY KEY(drug_id, patient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE examination (id INT AUTO_INCREMENT NOT NULL, examination_id INT NOT NULL, shortcut VARCHAR(10) NOT NULL, examination_name VARCHAR(255) NOT NULL, norms VARCHAR(255) DEFAULT NULL, machine VARCHAR(255) DEFAULT NULL, INDEX IDX_CCDAABC5DAD0CFBF (examination_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, age VARCHAR(255) NOT NULL, marking_number VARCHAR(255) DEFAULT NULL, passport_number VARCHAR(255) DEFAULT NULL, appearance LONGTEXT NOT NULL, INDEX IDX_1ADAD7EB19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_examination (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, date DATE NOT NULL, result LONGTEXT NOT NULL, INDEX IDX_FCD9948A6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE drug_patient ADD CONSTRAINT FK_D51D3164AABCA765 FOREIGN KEY (drug_id) REFERENCES drug (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE drug_patient ADD CONSTRAINT FK_D51D31646B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE examination ADD CONSTRAINT FK_CCDAABC5DAD0CFBF FOREIGN KEY (examination_id) REFERENCES examination (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE patient_examination ADD CONSTRAINT FK_FCD9948A6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A76ED395');
        $this->addSql('ALTER TABLE drug_patient DROP FOREIGN KEY FK_D51D3164AABCA765');
        $this->addSql('ALTER TABLE drug_patient DROP FOREIGN KEY FK_D51D31646B899279');
        $this->addSql('ALTER TABLE examination DROP FOREIGN KEY FK_CCDAABC5DAD0CFBF');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB19EB6921');
        $this->addSql('ALTER TABLE patient_examination DROP FOREIGN KEY FK_FCD9948A6B899279');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE drug');
        $this->addSql('DROP TABLE drug_patient');
        $this->addSql('DROP TABLE examination');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE patient_examination');
    }
}

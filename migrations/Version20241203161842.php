<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241203161842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE examination DROP FOREIGN KEY FK_CCDAABC5DAD0CFBF');
        $this->addSql('DROP INDEX IDX_CCDAABC5DAD0CFBF ON examination');
        $this->addSql('ALTER TABLE examination DROP examination_id');
        $this->addSql('ALTER TABLE patient_examination ADD examination_id INT NOT NULL');
        $this->addSql('ALTER TABLE patient_examination ADD CONSTRAINT FK_FCD9948ADAD0CFBF FOREIGN KEY (examination_id) REFERENCES examination (id)');
        $this->addSql('CREATE INDEX IDX_FCD9948ADAD0CFBF ON patient_examination (examination_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE examination ADD examination_id INT NOT NULL');
        $this->addSql('ALTER TABLE examination ADD CONSTRAINT FK_CCDAABC5DAD0CFBF FOREIGN KEY (examination_id) REFERENCES examination (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CCDAABC5DAD0CFBF ON examination (examination_id)');
        $this->addSql('ALTER TABLE patient_examination DROP FOREIGN KEY FK_FCD9948ADAD0CFBF');
        $this->addSql('DROP INDEX IDX_FCD9948ADAD0CFBF ON patient_examination');
        $this->addSql('ALTER TABLE patient_examination DROP examination_id');
    }
}

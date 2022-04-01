<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329112510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16BD50F57CD FOREIGN KEY (department_code) REFERENCES departments (code)');
        $this->addSql('ALTER TABLE departments CHANGE id id INT NOT NULL, ADD PRIMARY KEY (code)');
        $this->addSql('ALTER TABLE departments ADD CONSTRAINT FK_16AEB8D4AEB327AF FOREIGN KEY (region_code) REFERENCES regions (code)');
        $this->addSql('DROP INDEX departments_region_code_foreign ON departments');
        $this->addSql('CREATE INDEX IDX_16AEB8D4AEB327AF ON departments (region_code)');
        $this->addSql('ALTER TABLE gite ADD city_id INT NOT NULL');
        $this->addSql('ALTER TABLE gite ADD CONSTRAINT FK_B638C92C8BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id)');
        $this->addSql('CREATE INDEX IDX_B638C92C8BAC62AF ON gite (city_id)');
        $this->addSql('ALTER TABLE regions MODIFY id INT UNSIGNED NOT NULL');
        $this->addSql('DROP INDEX regions_code_unique ON regions');
        $this->addSql('ALTER TABLE regions DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE regions CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE regions ADD PRIMARY KEY (code)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16BD50F57CD');
        $this->addSql('ALTER TABLE departments MODIFY code VARCHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE departments DROP FOREIGN KEY FK_16AEB8D4AEB327AF');
        $this->addSql('ALTER TABLE departments DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE departments DROP FOREIGN KEY FK_16AEB8D4AEB327AF');
        $this->addSql('ALTER TABLE departments CHANGE id id INT UNSIGNED NOT NULL');
        $this->addSql('DROP INDEX idx_16aeb8d4aeb327af ON departments');
        $this->addSql('CREATE INDEX departments_region_code_foreign ON departments (region_code)');
        $this->addSql('ALTER TABLE departments ADD CONSTRAINT FK_16AEB8D4AEB327AF FOREIGN KEY (region_code) REFERENCES regions (code)');
        $this->addSql('ALTER TABLE gite DROP FOREIGN KEY FK_B638C92C8BAC62AF');
        $this->addSql('DROP INDEX IDX_B638C92C8BAC62AF ON gite');
        $this->addSql('ALTER TABLE gite DROP city_id');
        $this->addSql('ALTER TABLE regions MODIFY code VARCHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE regions DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE regions CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX regions_code_unique ON regions (code)');
        $this->addSql('ALTER TABLE regions ADD PRIMARY KEY (id)');
    }
}

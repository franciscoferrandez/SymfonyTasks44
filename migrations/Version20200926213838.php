<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200926213838 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2D5B023498260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE venue (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, city_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_91911B0D98260155 (region_id), INDEX IDX_91911B0D8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B023498260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE venue ADD CONSTRAINT FK_91911B0D98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE venue ADD CONSTRAINT FK_91911B0D8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE venue DROP FOREIGN KEY FK_91911B0D8BAC62AF');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B023498260155');
        $this->addSql('ALTER TABLE venue DROP FOREIGN KEY FK_91911B0D98260155');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE venue');
    }
}

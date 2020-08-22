<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200822175047 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task CHANGE user_id user_id INT DEFAULT NULL, CHANGE priority priority VARCHAR(50) DEFAULT \'MEDIUM\', CHANGE hours hours INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE role role VARCHAR(50) DEFAULT \'\', CHANGE name name VARCHAR(100) DEFAULT \'\', CHANGE surname surname VARCHAR(250) DEFAULT \'\', CHANGE email email VARCHAR(250) DEFAULT \'\', CHANGE password password VARCHAR(250) DEFAULT \'\', CHANGE created_at created_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task CHANGE user_id user_id INT NOT NULL, CHANGE priority priority VARCHAR(50) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_general_ci`, CHANGE hours hours INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE role role VARCHAR(50) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_general_ci`, CHANGE name name VARCHAR(100) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_general_ci`, CHANGE surname surname VARCHAR(250) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_general_ci`, CHANGE email email VARCHAR(250) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_general_ci`, CHANGE password password VARCHAR(250) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_general_ci`, CHANGE created_at created_at DATETIME DEFAULT NULL');
    }
}

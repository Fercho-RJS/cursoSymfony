<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250905205833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE disertante CHANGE url url VARCHAR(255) DEFAULT NULL, CHANGE twitter twitter VARCHAR(60) DEFAULT NULL, CHANGE linkedin linkedin VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE evento ADD nombre VARCHAR(255) DEFAULT NULL, CHANGE disertante_id disertante_id INT DEFAULT NULL, CHANGE fecha fecha DATE DEFAULT NULL, CHANGE hora hora TIME DEFAULT NULL, CHANGE duracion duracion INT DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE disertante CHANGE url url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE twitter twitter VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE linkedin linkedin VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE evento DROP nombre, CHANGE disertante_id disertante_id INT DEFAULT NULL, CHANGE fecha fecha DATE DEFAULT \'NULL\', CHANGE hora hora TIME DEFAULT \'NULL\', CHANGE duracion duracion INT DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
    }
}

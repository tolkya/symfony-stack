<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250930092052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE marque (id SERIAL NOT NULL, nom VARCHAR(100) NOT NULL, pays VARCHAR(50) DEFAULT NULL, anne_creation INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE moto ADD marque_id INT NOT NULL');
        $this->addSql('ALTER TABLE moto DROP marque');
        $this->addSql('ALTER TABLE moto ADD CONSTRAINT FK_3DDDBCE44827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3DDDBCE44827B9B2 ON moto (marque_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE moto DROP CONSTRAINT FK_3DDDBCE44827B9B2');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP INDEX IDX_3DDDBCE44827B9B2');
        $this->addSql('ALTER TABLE moto ADD marque VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE moto DROP marque_id');
    }
}

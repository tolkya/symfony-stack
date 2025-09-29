<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250929231215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE moto ADD edition VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE moto ADD categorie VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE moto ADD annee INT NOT NULL');
        $this->addSql('ALTER TABLE moto ADD couleur VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE moto ADD cylindree INT NOT NULL');
        $this->addSql('ALTER TABLE moto ADD chevaux INT NOT NULL');
        $this->addSql('ALTER TABLE moto ADD description TEXT NOT NULL');
        $this->addSql('ALTER TABLE moto ADD utilite TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE moto ADD image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE moto DROP edition');
        $this->addSql('ALTER TABLE moto DROP categorie');
        $this->addSql('ALTER TABLE moto DROP annee');
        $this->addSql('ALTER TABLE moto DROP couleur');
        $this->addSql('ALTER TABLE moto DROP cylindree');
        $this->addSql('ALTER TABLE moto DROP chevaux');
        $this->addSql('ALTER TABLE moto DROP description');
        $this->addSql('ALTER TABLE moto DROP utilite');
        $this->addSql('ALTER TABLE moto DROP image');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250930072622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garage ADD proprietaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE garage ADD CONSTRAINT FK_9F26610B76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9F26610B76C50E4A ON garage (proprietaire_id)');
        $this->addSql('ALTER TABLE moto DROP CONSTRAINT fk_3dddbce45866d02b');
        $this->addSql('DROP INDEX idx_3dddbce45866d02b');
        $this->addSql('ALTER TABLE moto RENAME COLUMN stationner_id TO garage_id');
        $this->addSql('ALTER TABLE moto ADD CONSTRAINT FK_3DDDBCE4C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3DDDBCE4C4FFF555 ON moto (garage_id)');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT fk_8d93d649fef81e3c');
        $this->addSql('DROP INDEX uniq_8d93d649fef81e3c');
        $this->addSql('ALTER TABLE "user" DROP garage_moto_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE garage DROP CONSTRAINT FK_9F26610B76C50E4A');
        $this->addSql('DROP INDEX UNIQ_9F26610B76C50E4A');
        $this->addSql('ALTER TABLE garage DROP proprietaire_id');
        $this->addSql('ALTER TABLE "user" ADD garage_moto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d649fef81e3c FOREIGN KEY (garage_moto_id) REFERENCES garage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649fef81e3c ON "user" (garage_moto_id)');
        $this->addSql('ALTER TABLE moto DROP CONSTRAINT FK_3DDDBCE4C4FFF555');
        $this->addSql('DROP INDEX IDX_3DDDBCE4C4FFF555');
        $this->addSql('ALTER TABLE moto RENAME COLUMN garage_id TO stationner_id');
        $this->addSql('ALTER TABLE moto ADD CONSTRAINT fk_3dddbce45866d02b FOREIGN KEY (stationner_id) REFERENCES garage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_3dddbce45866d02b ON moto (stationner_id)');
    }
}

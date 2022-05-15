<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220510180942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artiste ADD CONSTRAINT FK_9C07354FC723B2C8 FOREIGN KEY (Type_De_Musique) REFERENCES type_de_musique (id)');
        $this->addSql('CREATE INDEX IDX_9C07354FC723B2C8 ON artiste (Type_De_Musique)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artiste DROP FOREIGN KEY FK_9C07354FC723B2C8');
        $this->addSql('DROP INDEX IDX_9C07354FC723B2C8 ON artiste');
    }
}

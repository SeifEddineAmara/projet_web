<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220510114610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_de_musique (id INT AUTO_INCREMENT NOT NULL, genre VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CF06B61A835033F8 (genre), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artiste CHANGE Type_De_Musique Type_De_Musique INT DEFAULT NULL');
        $this->addSql('ALTER TABLE artiste ADD CONSTRAINT FK_9C07354FC723B2C8 FOREIGN KEY (Type_De_Musique) REFERENCES type_de_musique (id)');
        $this->addSql('CREATE INDEX IDX_9C07354FC723B2C8 ON artiste (Type_De_Musique)');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(255) NOT NULL, DROP roles');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artiste DROP FOREIGN KEY FK_9C07354FC723B2C8');
        $this->addSql('DROP TABLE type_de_musique');
        $this->addSql('DROP INDEX IDX_9C07354FC723B2C8 ON artiste');
        $this->addSql('ALTER TABLE artiste CHANGE Type_De_Musique Type_De_Musique VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', DROP role');
    }
}

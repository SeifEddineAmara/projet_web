<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419114716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artiste (Id_Artiste INT AUTO_INCREMENT NOT NULL, Nom_Artiste VARCHAR(30) DEFAULT NULL, Type_De_Musique VARCHAR(20) DEFAULT NULL, PRIMARY KEY(Id_Artiste)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (Id_Evenement INT AUTO_INCREMENT NOT NULL, Nom_Evenement VARCHAR(20) NOT NULL, Date_Evenement DATE DEFAULT NULL, Id_Artiste INT DEFAULT NULL, Id_Restaurant INT DEFAULT NULL, INDEX idArtiste (Id_Artiste), INDEX Id_Restaurant (Id_Restaurant), PRIMARY KEY(Id_Evenement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_de_musique (id INT AUTO_INCREMENT NOT NULL, genre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EC27AA673 FOREIGN KEY (Id_Artiste) REFERENCES artiste (Id_Artiste)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EB23CDACD FOREIGN KEY (Id_Restaurant) REFERENCES restaurant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EC27AA673');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE type_de_musique');
    }
}

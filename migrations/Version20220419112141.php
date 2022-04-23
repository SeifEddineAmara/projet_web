<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419112141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_de_musique (id INT AUTO_INCREMENT NOT NULL, genre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EB23CDACD');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EC27AA673');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EB23CDACD FOREIGN KEY (Id_Restaurant) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EC27AA673 FOREIGN KEY (Id_Artiste) REFERENCES artiste (Id_Artiste)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE type_de_musique');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EC27AA673');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EB23CDACD');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EC27AA673 FOREIGN KEY (Id_Artiste) REFERENCES artiste (Id_Artiste) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EB23CDACD FOREIGN KEY (Id_Restaurant) REFERENCES restaurant (id) ON UPDATE CASCADE');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412164904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artiste (Id_Artiste INT AUTO_INCREMENT NOT NULL, Nom_Artiste VARCHAR(30) DEFAULT NULL, Type_De_Musique VARCHAR(20) DEFAULT NULL, PRIMARY KEY(Id_Artiste)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chefs (ID_Chef INT AUTO_INCREMENT NOT NULL, Nom_Chef VARCHAR(30) NOT NULL, Cours_Associe VARCHAR(100) NOT NULL, Adresse_Chef VARCHAR(100) NOT NULL, PRIMARY KEY(ID_Chef)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id_commentaire INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, id_publication INT DEFAULT NULL, libelle_commentaire VARCHAR(255) NOT NULL, INDEX fk1_user (id_user), INDEX fk2_publication (id_publication), PRIMARY KEY(id_commentaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (Id_Cour INT AUTO_INCREMENT NOT NULL, Nom_Cour VARCHAR(30) NOT NULL, Libelle_Cour TEXT NOT NULL, ID_Chef INT DEFAULT NULL, INDEX ID_Chef (ID_Chef), PRIMARY KEY(Id_Cour)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (Id_Evenement INT AUTO_INCREMENT NOT NULL, Nom_Evenement VARCHAR(20) NOT NULL, Date_Evenement DATE DEFAULT NULL, Id_Artiste INT DEFAULT NULL, Id_Restaurant INT DEFAULT NULL, INDEX idArtiste (Id_Artiste), INDEX Id_Restaurant (Id_Restaurant), PRIMARY KEY(Id_Evenement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT DEFAULT NULL, Id_Inscription INT AUTO_INCREMENT NOT NULL, Id_Cour INT DEFAULT NULL, INDEX Id_Cour (Id_Cour), INDEX fk2 (id), PRIMARY KEY(Id_Inscription)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, restaurant VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, element VARCHAR(255) NOT NULL, menu VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (Id_Publication INT AUTO_INCREMENT NOT NULL, Libelle_Publication VARCHAR(255) NOT NULL, Nb_Réaction INT NOT NULL, Id_User INT DEFAULT NULL, INDEX Id_User (Id_User), PRIMARY KEY(Id_Publication)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reaction (Id_Reaction INT AUTO_INCREMENT NOT NULL, Type_Reaction INT NOT NULL, Id_Publication INT DEFAULT NULL, Id_User INT DEFAULT NULL, INDEX Id_Publication (Id_Publication), INDEX Id_User (Id_User), PRIMARY KEY(Id_Reaction)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (Id_Reservation INT AUTO_INCREMENT NOT NULL, Heure INT NOT NULL, Date VARCHAR(225) NOT NULL, Id_Restaurant INT DEFAULT NULL, Id_Table INT DEFAULT NULL, Id_User INT DEFAULT NULL, INDEX Id_Table (Id_Table), INDEX Id_Resaturent (Id_Restaurant), INDEX Id_User (Id_User), PRIMARY KEY(Id_Reservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, domaine VARCHAR(255) NOT NULL, owner VARCHAR(225) NOT NULL, nb INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE table_restaurant (Id_Table INT AUTO_INCREMENT NOT NULL, Type_Table INT NOT NULL, Id_Restaurant INT DEFAULT NULL, INDEX Id_Restaurent (Id_Restaurant), PRIMARY KEY(Id_Table)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, phone INT NOT NULL, birthday DATE NOT NULL, acces VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCB72EAA8E FOREIGN KEY (id_publication) REFERENCES publication (Id_Publication)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C114BC970 FOREIGN KEY (ID_Chef) REFERENCES chefs (ID_Chef)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EC27AA673 FOREIGN KEY (Id_Artiste) REFERENCES artiste (Id_Artiste)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EB23CDACD FOREIGN KEY (Id_Restaurant) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6BF396750 FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D643B01CEF FOREIGN KEY (Id_Cour) REFERENCES cours (Id_Cour)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779693C5CE9 FOREIGN KEY (Id_User) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F7FCD65D81 FOREIGN KEY (Id_Publication) REFERENCES publication (Id_Publication)');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F7693C5CE9 FOREIGN KEY (Id_User) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B23CDACD FOREIGN KEY (Id_Restaurant) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955201B8324 FOREIGN KEY (Id_Table) REFERENCES table_restaurant (Id_Table)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955693C5CE9 FOREIGN KEY (Id_User) REFERENCES user (id)');
        $this->addSql('ALTER TABLE table_restaurant ADD CONSTRAINT FK_B67B4A52B23CDACD FOREIGN KEY (Id_Restaurant) REFERENCES restaurant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EC27AA673');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C114BC970');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D643B01CEF');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCB72EAA8E');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F7FCD65D81');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EB23CDACD');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B23CDACD');
        $this->addSql('ALTER TABLE table_restaurant DROP FOREIGN KEY FK_B67B4A52B23CDACD');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955201B8324');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC6B3CA4B');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6BF396750');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779693C5CE9');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F7693C5CE9');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955693C5CE9');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('DROP TABLE chefs');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE plat');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE reaction');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE table_restaurant');
        $this->addSql('DROP TABLE user');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220510230638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artiste CHANGE Id_Artiste Id_Artiste INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE artiste ADD CONSTRAINT FK_9C07354FC723B2C8 FOREIGN KEY (Type_De_Musique) REFERENCES type_de_musique (id)');
        $this->addSql('CREATE INDEX IDX_9C07354FC723B2C8 ON artiste (Type_De_Musique)');
        $this->addSql('ALTER TABLE chefs CHANGE ID_Chef ID_Chef INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE commentaire CHANGE id_commentaire id_commentaire INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCB72EAA8E FOREIGN KEY (id_publication) REFERENCES publication (Id_Publication)');
        $this->addSql('ALTER TABLE cours CHANGE Id_Cour Id_Cour INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C114BC970 FOREIGN KEY (ID_Chef) REFERENCES chefs (ID_Chef)');
        $this->addSql('ALTER TABLE evenement CHANGE Id_Evenement Id_Evenement INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EC27AA673 FOREIGN KEY (Id_Artiste) REFERENCES artiste (Id_Artiste)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EB23CDACD FOREIGN KEY (Id_Restaurant) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE inscription CHANGE Id_Inscription Id_Inscription INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6BF396750 FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D643B01CEF FOREIGN KEY (Id_Cour) REFERENCES cours (Id_Cour)');
        $this->addSql('ALTER TABLE menu CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE restaurant restaurant INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93EB95123F FOREIGN KEY (restaurant) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX fk_menu_rest ON menu (restaurant)');
        $this->addSql('ALTER TABLE plat CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE menu menu INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A2077D053A93 FOREIGN KEY (menu) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX fk1_plat_menu1 ON plat (menu)');
        $this->addSql('ALTER TABLE publication CHANGE Id_Publication Id_Publication INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779693C5CE9 FOREIGN KEY (Id_User) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reaction CHANGE Id_Reaction Id_Reaction INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F7FCD65D81 FOREIGN KEY (Id_Publication) REFERENCES publication (Id_Publication)');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F7693C5CE9 FOREIGN KEY (Id_User) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation CHANGE Id_Reservation Id_Reservation INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B23CDACD FOREIGN KEY (Id_Restaurant) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955201B8324 FOREIGN KEY (Id_Table) REFERENCES table_restaurant (Id_Table)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955693C5CE9 FOREIGN KEY (Id_User) REFERENCES user (id)');
        $this->addSql('ALTER TABLE restaurant CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE owner owner INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FCF60E67C FOREIGN KEY (owner) REFERENCES user (id)');
        $this->addSql('CREATE INDEX fk_rest_user ON restaurant (owner)');
        $this->addSql('ALTER TABLE table_restaurant CHANGE Id_Table Id_Table INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE table_restaurant ADD CONSTRAINT FK_B67B4A52B23CDACD FOREIGN KEY (Id_Restaurant) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE type_de_musique CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF06B61A835033F8 ON type_de_musique (genre)');
        $this->addSql('ALTER TABLE user CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artiste DROP FOREIGN KEY FK_9C07354FC723B2C8');
        $this->addSql('DROP INDEX IDX_9C07354FC723B2C8 ON artiste');
        $this->addSql('ALTER TABLE artiste CHANGE Id_Artiste Id_Artiste INT NOT NULL');
        $this->addSql('ALTER TABLE chefs CHANGE ID_Chef ID_Chef INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC6B3CA4B');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCB72EAA8E');
        $this->addSql('ALTER TABLE commentaire CHANGE id_commentaire id_commentaire INT NOT NULL');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C114BC970');
        $this->addSql('ALTER TABLE cours CHANGE Id_Cour Id_Cour INT NOT NULL');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EC27AA673');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EB23CDACD');
        $this->addSql('ALTER TABLE evenement CHANGE Id_Evenement Id_Evenement INT NOT NULL');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6BF396750');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D643B01CEF');
        $this->addSql('ALTER TABLE inscription CHANGE Id_Inscription Id_Inscription INT NOT NULL');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93EB95123F');
        $this->addSql('DROP INDEX fk_menu_rest ON menu');
        $this->addSql('ALTER TABLE menu CHANGE id id INT NOT NULL, CHANGE restaurant restaurant VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A2077D053A93');
        $this->addSql('DROP INDEX fk1_plat_menu1 ON plat');
        $this->addSql('ALTER TABLE plat CHANGE id id INT NOT NULL, CHANGE menu menu VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779693C5CE9');
        $this->addSql('ALTER TABLE publication CHANGE Id_Publication Id_Publication INT NOT NULL');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F7FCD65D81');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F7693C5CE9');
        $this->addSql('ALTER TABLE reaction CHANGE Id_Reaction Id_Reaction INT NOT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B23CDACD');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955201B8324');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955693C5CE9');
        $this->addSql('ALTER TABLE reservation CHANGE Id_Reservation Id_Reservation INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FCF60E67C');
        $this->addSql('DROP INDEX fk_rest_user ON restaurant');
        $this->addSql('ALTER TABLE restaurant CHANGE id id INT NOT NULL, CHANGE owner owner VARCHAR(225) NOT NULL');
        $this->addSql('ALTER TABLE table_restaurant DROP FOREIGN KEY FK_B67B4A52B23CDACD');
        $this->addSql('ALTER TABLE table_restaurant CHANGE Id_Table Id_Table INT NOT NULL');
        $this->addSql('ALTER TABLE type_de_musique MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_CF06B61A835033F8 ON type_de_musique');
        $this->addSql('ALTER TABLE type_de_musique DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE type_de_musique CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE user MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user CHANGE id id INT NOT NULL');
    }
}

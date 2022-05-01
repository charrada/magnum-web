<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427214433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_user');
        $this->addSql('DROP TABLE review');
        $this->addSql('ALTER TABLE administrators DROP FOREIGN KEY fk_userID_admin');
        $this->addSql('ALTER TABLE administrators ADD CONSTRAINT FK_CA5E09B711D3633A FOREIGN KEY (ID) REFERENCES Users (ID) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flags DROP FOREIGN KEY fk_userID_flags');
        $this->addSql('DROP INDEX fk_userID_flags ON flags');
        $this->addSql('ALTER TABLE flags ADD flaggedID INT DEFAULT NULL, ADD flaggerID INT DEFAULT NULL, DROP userID, CHANGE offense offense VARCHAR(30) DEFAULT NULL, CHANGE description description VARCHAR(400) NOT NULL');
        $this->addSql('ALTER TABLE flags ADD CONSTRAINT FK_CAC46EBE4E3A9F92 FOREIGN KEY (flaggedID) REFERENCES Users (ID)');
        $this->addSql('ALTER TABLE flags ADD CONSTRAINT FK_CAC46EBE56914050 FOREIGN KEY (flaggerID) REFERENCES Users (ID)');
        $this->addSql('CREATE INDEX fk_flaggerID_flags ON flags (flaggerID)');
        $this->addSql('CREATE INDEX fk_userID_flags ON flags (flaggedID)');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY fk_userID_hist');
        $this->addSql('ALTER TABLE history CHANGE userID userID INT DEFAULT NULL, CHANGE activity activity VARCHAR(30) DEFAULT NULL, CHANGE description description VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_E80749D75FD86D04 FOREIGN KEY (userID) REFERENCES Users (ID)');
        $this->addSql('ALTER TABLE podcasters DROP FOREIGN KEY fk_userID_pod');
        $this->addSql('ALTER TABLE podcasters ADD CONSTRAINT FK_34251B6011D3633A FOREIGN KEY (ID) REFERENCES Users (ID) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tokens DROP FOREIGN KEY fk_userID_tokens');
        $this->addSql('ALTER TABLE tokens CHANGE userID userID INT DEFAULT NULL, CHANGE consumed consumed TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE tokens ADD CONSTRAINT FK_ADF614B85FD86D04 FOREIGN KEY (userID) REFERENCES Users (ID)');
        $this->addSql('ALTER TABLE users ADD discr VARCHAR(255) NOT NULL, CHANGE username username VARCHAR(40) NOT NULL, CHANGE email email VARCHAR(80) NOT NULL, CHANGE password password VARCHAR(72) NOT NULL, CHANGE avatar avatar VARCHAR(120) DEFAULT NULL COMMENT \'The name and extension of the image file that represents the avatar of the user, e.g. "grtcdr.png"\', CHANGE status status VARCHAR(30) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5428AEDF85E0677 ON users (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5428AEDE7927C74 ON users (email)');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY fk_offer_user');
        $this->addSql('ALTER TABLE offer CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EA76ED395 FOREIGN KEY (user_id) REFERENCES Users (ID)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY fk_offer_order');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY fk_order_user');
        $this->addSql('ALTER TABLE `order` CHANGE offer_id offer_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES Users (ID)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939853C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY fk_order_subscription');
        $this->addSql('ALTER TABLE subscription CHANGE order_id order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D38D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, userid INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, location VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date DATE NOT NULL, payant TINYINT(1) NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE event_user (id INT AUTO_INCREMENT NOT NULL, userid INT NOT NULL, eventid INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, userid INT NOT NULL, eventid INT NOT NULL, review VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE Administrators DROP FOREIGN KEY FK_CA5E09B711D3633A');
        $this->addSql('ALTER TABLE Administrators ADD CONSTRAINT fk_userID_admin FOREIGN KEY (ID) REFERENCES users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Flags DROP FOREIGN KEY FK_CAC46EBE4E3A9F92');
        $this->addSql('ALTER TABLE Flags DROP FOREIGN KEY FK_CAC46EBE56914050');
        $this->addSql('DROP INDEX fk_flaggerID_flags ON Flags');
        $this->addSql('DROP INDEX fk_userID_flags ON Flags');
        $this->addSql('ALTER TABLE Flags ADD userID INT NOT NULL, DROP flaggedID, DROP flaggerID, CHANGE offense offense VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(400) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE Flags ADD CONSTRAINT fk_userID_flags FOREIGN KEY (userID) REFERENCES users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX fk_userID_flags ON Flags (userID)');
        $this->addSql('ALTER TABLE History DROP FOREIGN KEY FK_E80749D75FD86D04');
        $this->addSql('ALTER TABLE History CHANGE activity activity VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(200) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE userID userID INT NOT NULL');
        $this->addSql('ALTER TABLE History ADD CONSTRAINT fk_userID_hist FOREIGN KEY (userID) REFERENCES users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873EA76ED395');
        $this->addSql('ALTER TABLE offer CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT fk_offer_user FOREIGN KEY (user_id) REFERENCES users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939853C674EE');
        $this->addSql('ALTER TABLE `order` CHANGE user_id user_id INT NOT NULL, CHANGE offer_id offer_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT fk_offer_order FOREIGN KEY (offer_id) REFERENCES offer (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT fk_order_user FOREIGN KEY (user_id) REFERENCES users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Podcasters DROP FOREIGN KEY FK_34251B6011D3633A');
        $this->addSql('ALTER TABLE Podcasters ADD CONSTRAINT fk_userID_pod FOREIGN KEY (ID) REFERENCES users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D38D9F6D38');
        $this->addSql('ALTER TABLE subscription CHANGE order_id order_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT fk_order_subscription FOREIGN KEY (order_id) REFERENCES `order` (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Tokens DROP FOREIGN KEY FK_ADF614B85FD86D04');
        $this->addSql('ALTER TABLE Tokens CHANGE consumed consumed TINYINT(1) DEFAULT 0 NOT NULL, CHANGE userID userID INT NOT NULL');
        $this->addSql('ALTER TABLE Tokens ADD CONSTRAINT fk_userID_tokens FOREIGN KEY (userID) REFERENCES users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX UNIQ_D5428AEDF85E0677 ON Users');
        $this->addSql('DROP INDEX UNIQ_D5428AEDE7927C74 ON Users');
        $this->addSql('ALTER TABLE Users DROP discr, CHANGE username username VARCHAR(40) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(80) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(72) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE avatar avatar VARCHAR(120) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'The name and extension of the image file that represents the avatar of the user, e.g. "grtcdr.png"\', CHANGE status status VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220420153235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Administrators DROP FOREIGN KEY fk_userID_admin');
        $this->addSql('ALTER TABLE Administrators ADD CONSTRAINT FK_CA5E09B711D3633A FOREIGN KEY (ID) REFERENCES Users (ID) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Flags DROP FOREIGN KEY fk_flaggedID_flags');
        $this->addSql('ALTER TABLE Flags DROP FOREIGN KEY fk_flaggerID_flags');
        $this->addSql('ALTER TABLE Flags CHANGE flaggedID flaggedID INT DEFAULT NULL, CHANGE description description VARCHAR(400) NOT NULL, CHANGE flaggerID flaggerID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Flags ADD CONSTRAINT FK_CAC46EBE4E3A9F92 FOREIGN KEY (flaggedID) REFERENCES Users (ID)');
        $this->addSql('ALTER TABLE Flags ADD CONSTRAINT FK_CAC46EBE56914050 FOREIGN KEY (flaggerID) REFERENCES Users (ID)');
        $this->addSql('ALTER TABLE History DROP FOREIGN KEY fk_userID_hist');
        $this->addSql('ALTER TABLE History CHANGE userID userID INT DEFAULT NULL, CHANGE description description VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE History ADD CONSTRAINT FK_E80749D75FD86D04 FOREIGN KEY (userID) REFERENCES Users (ID)');
        $this->addSql('ALTER TABLE Podcasters DROP FOREIGN KEY fk_userID_pod');
        $this->addSql('ALTER TABLE Podcasters ADD CONSTRAINT FK_34251B6011D3633A FOREIGN KEY (ID) REFERENCES Users (ID) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Tokens DROP FOREIGN KEY fk_userID_tokens');
        $this->addSql('ALTER TABLE Tokens CHANGE userID userID INT DEFAULT NULL, CHANGE consumed consumed TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE Tokens ADD CONSTRAINT FK_ADF614B85FD86D04 FOREIGN KEY (userID) REFERENCES Users (ID)');
        $this->addSql('ALTER TABLE Users ADD discr VARCHAR(255) NOT NULL, CHANGE username username VARCHAR(40) NOT NULL, CHANGE email email VARCHAR(80) NOT NULL, CHANGE password password VARCHAR(72) NOT NULL, CHANGE avatar avatar VARCHAR(120) DEFAULT NULL COMMENT \'The name and extension of the image file that represents the avatar of the user, e.g. "grtcdr.png"\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5428AEDF85E0677 ON Users (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D5428AEDE7927C74 ON Users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Administrators DROP FOREIGN KEY FK_CA5E09B711D3633A');
        $this->addSql('ALTER TABLE Administrators ADD CONSTRAINT fk_userID_admin FOREIGN KEY (ID) REFERENCES Users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Flags DROP FOREIGN KEY FK_CAC46EBE4E3A9F92');
        $this->addSql('ALTER TABLE Flags DROP FOREIGN KEY FK_CAC46EBE56914050');
        $this->addSql('ALTER TABLE Flags CHANGE description description VARCHAR(400) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE flaggedID flaggedID INT NOT NULL, CHANGE flaggerID flaggerID INT NOT NULL');
        $this->addSql('ALTER TABLE Flags ADD CONSTRAINT fk_flaggedID_flags FOREIGN KEY (flaggedID) REFERENCES Users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Flags ADD CONSTRAINT fk_flaggerID_flags FOREIGN KEY (flaggerID) REFERENCES Users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE History DROP FOREIGN KEY FK_E80749D75FD86D04');
        $this->addSql('ALTER TABLE History CHANGE description description VARCHAR(200) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE userID userID INT NOT NULL');
        $this->addSql('ALTER TABLE History ADD CONSTRAINT fk_userID_hist FOREIGN KEY (userID) REFERENCES Users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Podcasters DROP FOREIGN KEY FK_34251B6011D3633A');
        $this->addSql('ALTER TABLE Podcasters ADD CONSTRAINT fk_userID_pod FOREIGN KEY (ID) REFERENCES Users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Tokens DROP FOREIGN KEY FK_ADF614B85FD86D04');
        $this->addSql('ALTER TABLE Tokens CHANGE consumed consumed TINYINT(1) DEFAULT 0 NOT NULL, CHANGE userID userID INT NOT NULL');
        $this->addSql('ALTER TABLE Tokens ADD CONSTRAINT fk_userID_tokens FOREIGN KEY (userID) REFERENCES Users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX UNIQ_D5428AEDF85E0677 ON Users');
        $this->addSql('DROP INDEX UNIQ_D5428AEDE7927C74 ON Users');
        $this->addSql('ALTER TABLE Users DROP discr, CHANGE username username VARCHAR(40) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(80) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(72) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE avatar avatar VARCHAR(120) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'The name and extension of the image file that represents the avatar of the user, e.g. "grtcdr.png"\'');
    }
}

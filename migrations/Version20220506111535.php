<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220506111535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, url LONGTEXT NOT NULL, content VARCHAR(255) NOT NULL, authorID INT DEFAULT NULL, INDEX authorID (authorID), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, articleid INT DEFAULT NULL, userid INT DEFAULT NULL, message VARCHAR(255) NOT NULL, submitDate DATE DEFAULT \'CURRENT_TIMESTAMP\' NOT NULL, INDEX articleID (articleID), INDEX userID (userID), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE podcasters (firstName VARCHAR(40) NOT NULL COMMENT \'This attribute can be used as the name of the podcast and not necessarily that of the account holder.\', lastName VARCHAR(40) NOT NULL COMMENT \'This attribute can be used as the name of the podcast and not necessarily that of the account holder.\', biography VARCHAR(200) DEFAULT NULL COMMENT \'A short and sweet paragraph that tells users a little bit about the podcaster.\', avatar VARCHAR(120) DEFAULT NULL COMMENT \'The name and extension of the image file that represents the avatar of the user, e.g. "grtcdr.png"\', ID INT NOT NULL, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, rate DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (ID INT AUTO_INCREMENT NOT NULL, username VARCHAR(40) NOT NULL, email VARCHAR(80) NOT NULL, password VARCHAR(72) NOT NULL, avatar VARCHAR(120) DEFAULT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E669AF8D935 FOREIGN KEY (authorID) REFERENCES podcasters (ID)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC6B26844C FOREIGN KEY (articleid) REFERENCES article (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCF132696E FOREIGN KEY (userid) REFERENCES users (ID)');
        $this->addSql('ALTER TABLE podcasters ADD CONSTRAINT FK_7B7818B011D3633A FOREIGN KEY (ID) REFERENCES users (ID)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC6B26844C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E669AF8D935');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCF132696E');
        $this->addSql('ALTER TABLE podcasters DROP FOREIGN KEY FK_7B7818B011D3633A');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE podcasters');
        $this->addSql('DROP TABLE rate');
        $this->addSql('DROP TABLE users');
    }
}

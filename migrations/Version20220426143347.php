<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426143347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY article_ibfk_1');
        $this->addSql('ALTER TABLE article CHANGE authorID authorID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E669AF8D935 FOREIGN KEY (authorID) REFERENCES podcasters (ID)');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY commentaire_ibfk_1');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY commentaire_ibfk_2');
        $this->addSql('ALTER TABLE commentaire CHANGE articleID articleID INT DEFAULT NULL, CHANGE userID userID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC5CC8026 FOREIGN KEY (articleID) REFERENCES article (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC5FD86D04 FOREIGN KEY (userID) REFERENCES users (ID)');
        $this->addSql('ALTER TABLE users CHANGE username username VARCHAR(40) NOT NULL, CHANGE email email VARCHAR(80) NOT NULL, CHANGE password password VARCHAR(72) NOT NULL, CHANGE avatar avatar VARCHAR(120) DEFAULT NULL, CHANGE status status VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E669AF8D935');
        $this->addSql('ALTER TABLE article CHANGE authorID authorID INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT article_ibfk_1 FOREIGN KEY (authorID) REFERENCES podcasters (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCC5CC8026');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC5FD86D04');
        $this->addSql('ALTER TABLE commentaire CHANGE articleID articleID INT NOT NULL, CHANGE userID userID INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT commentaire_ibfk_1 FOREIGN KEY (articleID) REFERENCES article (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT commentaire_ibfk_2 FOREIGN KEY (userID) REFERENCES users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users CHANGE username username VARCHAR(40) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(80) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(72) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE avatar avatar VARCHAR(120) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE status status VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

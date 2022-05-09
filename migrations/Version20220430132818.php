<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220430132818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, userid LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', articleid LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', rate DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E669AF8D935');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E669AF8D935');
        $this->addSql('ALTER TABLE article CHANGE url url LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E669AF8D935 FOREIGN KEY (authorID) REFERENCES podcasters (ID)');
        $this->addSql('DROP INDEX fk_23a0e669af8d935 ON article');
        $this->addSql('CREATE INDEX authorID ON article (authorID)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E669AF8D935 FOREIGN KEY (authorID) REFERENCES podcasters (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCC5CC8026');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC5FD86D04');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCC5CC8026');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC5FD86D04');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC6B26844C FOREIGN KEY (articleid) REFERENCES article (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCF132696E FOREIGN KEY (userid) REFERENCES users (ID)');
        $this->addSql('DROP INDEX fk_67f068bcc5cc8026 ON commentaire');
        $this->addSql('CREATE INDEX articleID ON commentaire (articleID)');
        $this->addSql('DROP INDEX fk_67f068bc5fd86d04 ON commentaire');
        $this->addSql('CREATE INDEX userID ON commentaire (userID)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC5CC8026 FOREIGN KEY (articleID) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC5FD86D04 FOREIGN KEY (userID) REFERENCES users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE rate');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E669AF8D935');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E669AF8D935');
        $this->addSql('ALTER TABLE article CHANGE url url VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E669AF8D935 FOREIGN KEY (authorID) REFERENCES podcasters (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX authorid ON article');
        $this->addSql('CREATE INDEX FK_23A0E669AF8D935 ON article (authorID)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E669AF8D935 FOREIGN KEY (authorID) REFERENCES podcasters (ID)');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC6B26844C');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCF132696E');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC6B26844C');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCF132696E');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC5CC8026 FOREIGN KEY (articleID) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC5FD86D04 FOREIGN KEY (userID) REFERENCES users (ID) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX userid ON commentaire');
        $this->addSql('CREATE INDEX FK_67F068BC5FD86D04 ON commentaire (userID)');
        $this->addSql('DROP INDEX articleid ON commentaire');
        $this->addSql('CREATE INDEX FK_67F068BCC5CC8026 ON commentaire (articleID)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC6B26844C FOREIGN KEY (articleid) REFERENCES article (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCF132696E FOREIGN KEY (userid) REFERENCES users (ID)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412004815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, author_id_id INT NOT NULL, url VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_23A0E6669CCBE9A (author_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commantaire (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commantaire_article (commantaire_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_FB8EF956B37771EA (commantaire_id), INDEX IDX_FB8EF9567294869C (article_id), PRIMARY KEY(commantaire_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, message VARCHAR(150) NOT NULL, submit_date DATE NOT NULL, INDEX IDX_67F068BC9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6669CCBE9A FOREIGN KEY (author_id_id) REFERENCES podcaster (id)');
        $this->addSql('ALTER TABLE commantaire_article ADD CONSTRAINT FK_FB8EF956B37771EA FOREIGN KEY (commantaire_id) REFERENCES commantaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commantaire_article ADD CONSTRAINT FK_FB8EF9567294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commantaire_article DROP FOREIGN KEY FK_FB8EF9567294869C');
        $this->addSql('ALTER TABLE commantaire_article DROP FOREIGN KEY FK_FB8EF956B37771EA');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE commantaire');
        $this->addSql('DROP TABLE commantaire_article');
        $this->addSql('DROP TABLE commentaire');
    }
}

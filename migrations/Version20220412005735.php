<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412005735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commantaire_article DROP FOREIGN KEY FK_FB8EF956B37771EA');
        $this->addSql('DROP TABLE commantaire');
        $this->addSql('DROP TABLE commantaire_article');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commantaire (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commantaire_article (commantaire_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_FB8EF956B37771EA (commantaire_id), INDEX IDX_FB8EF9567294869C (article_id), PRIMARY KEY(commantaire_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commantaire_article ADD CONSTRAINT FK_FB8EF9567294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commantaire_article ADD CONSTRAINT FK_FB8EF956B37771EA FOREIGN KEY (commantaire_id) REFERENCES commantaire (id) ON DELETE CASCADE');
    }
}

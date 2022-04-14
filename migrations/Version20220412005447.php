<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412005447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD article_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC8F3EC46 FOREIGN KEY (article_id_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC8F3EC46 ON commentaire (article_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC8F3EC46');
        $this->addSql('DROP INDEX IDX_67F068BC8F3EC46 ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP article_id_id');
    }
}

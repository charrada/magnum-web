<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427214647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users CHANGE dtype discr VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE offer CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EA76ED395 FOREIGN KEY (user_id) REFERENCES Users (ID)');
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
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873EA76ED395');
        $this->addSql('ALTER TABLE offer CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939853C674EE');
        $this->addSql('ALTER TABLE `order` CHANGE user_id user_id INT NOT NULL, CHANGE offer_id offer_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D38D9F6D38');
        $this->addSql('ALTER TABLE subscription CHANGE order_id order_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT fk_order_subscription FOREIGN KEY (order_id) REFERENCES `order` (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Users CHANGE discr dtype VARCHAR(255) NOT NULL');
    }
}

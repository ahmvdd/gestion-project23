<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203122903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories ADD ticket_id INT NOT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('CREATE INDEX IDX_3AF34668700047D2 ON categories (ticket_id)');
        $this->addSql('ALTER TABLE user ADD ticket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649700047D2 ON user (ticket_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668700047D2');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649700047D2');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP INDEX IDX_3AF34668700047D2 ON categories');
        $this->addSql('ALTER TABLE categories DROP ticket_id');
        $this->addSql('DROP INDEX IDX_8D93D649700047D2 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP ticket_id');
    }
}

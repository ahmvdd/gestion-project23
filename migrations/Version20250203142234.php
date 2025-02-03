<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203142234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668700047D2');
        $this->addSql('DROP INDEX IDX_3AF34668700047D2 ON categories');
        $this->addSql('ALTER TABLE categories DROP ticket_id');
        $this->addSql('ALTER TABLE ticket ADD created_by INT DEFAULT NULL, ADD assigned_to INT DEFAULT NULL, ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3DE12AB56 FOREIGN KEY (created_by) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA389EEAF91 FOREIGN KEY (assigned_to) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA312469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3DE12AB56 ON ticket (created_by)');
        $this->addSql('CREATE INDEX IDX_97A0ADA389EEAF91 ON ticket (assigned_to)');
        $this->addSql('CREATE INDEX IDX_97A0ADA312469DE2 ON ticket (category_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649700047D2');
        $this->addSql('DROP INDEX IDX_8D93D649700047D2 ON user');
        $this->addSql('ALTER TABLE user DROP ticket_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories ADD ticket_id INT NOT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('CREATE INDEX IDX_3AF34668700047D2 ON categories (ticket_id)');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3DE12AB56');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA389EEAF91');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA312469DE2');
        $this->addSql('DROP INDEX IDX_97A0ADA3DE12AB56 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA389EEAF91 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA312469DE2 ON ticket');
        $this->addSql('ALTER TABLE ticket DROP created_by, DROP assigned_to, DROP category_id');
        $this->addSql('ALTER TABLE `user` ADD ticket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649700047D2 ON `user` (ticket_id)');
    }
}

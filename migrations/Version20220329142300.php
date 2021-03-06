<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329142300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E663049EF9');
        $this->addSql('DROP TABLE spotlight');
        $this->addSql('DROP INDEX IDX_23A0E663049EF9 ON article');
        $this->addSql('ALTER TABLE article DROP spotlight_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE spotlight (id INT AUTO_INCREMENT NOT NULL, spotlight TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE article ADD spotlight_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E663049EF9 FOREIGN KEY (spotlight_id) REFERENCES spotlight (id)');
        $this->addSql('CREATE INDEX IDX_23A0E663049EF9 ON article (spotlight_id)');
    }
}

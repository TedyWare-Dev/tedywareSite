<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427095516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE on_going_project (id INT AUTO_INCREMENT NOT NULL, progress VARCHAR(255) NOT NULL, budget VARCHAR(255) NOT NULL, project_status VARCHAR(255) NOT NULL, starting_date DATETIME NOT NULL, completion_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE on_going_project_user (on_going_project_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B5D9BFA9C6935E9C (on_going_project_id), INDEX IDX_B5D9BFA9A76ED395 (user_id), PRIMARY KEY(on_going_project_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE on_going_project_user ADD CONSTRAINT FK_B5D9BFA9C6935E9C FOREIGN KEY (on_going_project_id) REFERENCES on_going_project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE on_going_project_user ADD CONSTRAINT FK_B5D9BFA9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE on_going_project_user DROP FOREIGN KEY FK_B5D9BFA9C6935E9C');
        $this->addSql('DROP TABLE on_going_project');
        $this->addSql('DROP TABLE on_going_project_user');
    }
}

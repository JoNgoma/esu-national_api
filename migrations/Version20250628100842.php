<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250628100842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE educative_systeme (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name_educ VARCHAR(255) NOT NULL, descript_educ LONGTEXT DEFAULT NULL, INDEX IDX_D0B336C4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE educative_systeme ADD CONSTRAINT FK_D0B336C4A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE educative_systeme DROP FOREIGN KEY FK_D0B336C4A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE educative_systeme
        SQL);
    }
}

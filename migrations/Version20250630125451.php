<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250630125451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE province (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE university (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, province_id INT NOT NULL, name VARCHAR(255) NOT NULL, post_office_box VARCHAR(255) DEFAULT NULL, adress LONGTEXT NOT NULL, phone VARCHAR(16) NOT NULL, INDEX IDX_A07A85ECA76ED395 (user_id), INDEX IDX_A07A85ECE946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE university_educative_systeme (university_id INT NOT NULL, educative_systeme_id INT NOT NULL, INDEX IDX_EAFA378B309D1878 (university_id), INDEX IDX_EAFA378B2B93883F (educative_systeme_id), PRIMARY KEY(university_id, educative_systeme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE university ADD CONSTRAINT FK_A07A85ECA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE university ADD CONSTRAINT FK_A07A85ECE946114A FOREIGN KEY (province_id) REFERENCES province (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE university_educative_systeme ADD CONSTRAINT FK_EAFA378B309D1878 FOREIGN KEY (university_id) REFERENCES university (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE university_educative_systeme ADD CONSTRAINT FK_EAFA378B2B93883F FOREIGN KEY (educative_systeme_id) REFERENCES educative_systeme (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE university DROP FOREIGN KEY FK_A07A85ECA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE university DROP FOREIGN KEY FK_A07A85ECE946114A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE university_educative_systeme DROP FOREIGN KEY FK_EAFA378B309D1878
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE university_educative_systeme DROP FOREIGN KEY FK_EAFA378B2B93883F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE province
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE university
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE university_educative_systeme
        SQL);
    }
}

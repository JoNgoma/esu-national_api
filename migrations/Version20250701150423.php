<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250701150423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, faculte_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_C1765B6372C3434F (faculte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE domain (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE domain_university (domain_id INT NOT NULL, university_id INT NOT NULL, INDEX IDX_31F899A9115F0EE5 (domain_id), INDEX IDX_31F899A9309D1878 (university_id), PRIMARY KEY(domain_id, university_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE faculte (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE faculte_university (faculte_id INT NOT NULL, university_id INT NOT NULL, INDEX IDX_9B9FADF172C3434F (faculte_id), INDEX IDX_9B9FADF1309D1878 (university_id), PRIMARY KEY(faculte_id, university_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE spinneret (id INT AUTO_INCREMENT NOT NULL, domain_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_9DCA45D6115F0EE5 (domain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE departement ADD CONSTRAINT FK_C1765B6372C3434F FOREIGN KEY (faculte_id) REFERENCES faculte (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE domain_university ADD CONSTRAINT FK_31F899A9115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE domain_university ADD CONSTRAINT FK_31F899A9309D1878 FOREIGN KEY (university_id) REFERENCES `university` (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE faculte_university ADD CONSTRAINT FK_9B9FADF172C3434F FOREIGN KEY (faculte_id) REFERENCES faculte (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE faculte_university ADD CONSTRAINT FK_9B9FADF1309D1878 FOREIGN KEY (university_id) REFERENCES `university` (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE spinneret ADD CONSTRAINT FK_9DCA45D6115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id)
        SQL);
      
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6372C3434F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE domain_university DROP FOREIGN KEY FK_31F899A9115F0EE5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE domain_university DROP FOREIGN KEY FK_31F899A9309D1878
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE faculte_university DROP FOREIGN KEY FK_9B9FADF172C3434F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE faculte_university DROP FOREIGN KEY FK_9B9FADF1309D1878
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE spinneret DROP FOREIGN KEY FK_9DCA45D6115F0EE5
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE departement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE domain
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE domain_university
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE faculte
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE faculte_university
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE spinneret
        SQL);
        
    }
}

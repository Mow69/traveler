<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191025122303 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE destination (id INT AUTO_INCREMENT NOT NULL, longitude INT NOT NULL, latitude INT NOT NULL, created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, travel_id INT NOT NULL, caption LONGTEXT DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, INDEX IDX_16DB4F897E3C61F9 (owner_id), INDEX IDX_16DB4F89ECAB15B3 (travel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE travel (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, departure DATE DEFAULT NULL, distance_traveled DOUBLE PRECISION DEFAULT NULL, created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F897E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89ECAB15B3 FOREIGN KEY (travel_id) REFERENCES travel (id)');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL, ADD created DATETIME NOT NULL, DROP username, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89ECAB15B3');
        $this->addSql('DROP TABLE destination');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE travel');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP roles, DROP created, CHANGE email email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628155432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test2 (id INT AUTO_INCREMENT NOT NULL, test_id INT NOT NULL, quantite INT NOT NULL, prix INT NOT NULL, INDEX IDX_13BB8D581E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE test2 ADD CONSTRAINT FK_13BB8D581E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE categorie ADD couleur VARCHAR(20) DEFAULT NULL, CHANGE type type VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test2 DROP FOREIGN KEY FK_13BB8D581E5D0459');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE test2');
        $this->addSql('ALTER TABLE categorie DROP couleur, CHANGE type type INT NOT NULL');
    }
}

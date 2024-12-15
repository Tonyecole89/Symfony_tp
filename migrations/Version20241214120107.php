<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241214120107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create course and professor tables without category.';
    }

    public function up(Schema $schema): void
    {
        // Créer les tables `course` et `professeur`
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, professeur_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_169E6FB9BAB22EE9 (professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_17A55299E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        // Ajouter les clés étrangères
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        
        // Ne pas ajouter de références à la table `category` si elle n'existe plus
        // Supprimer ces lignes si la table `category` n'est pas nécessaire
        // $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)');  
        // $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        // $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // Supprimer les tables `course` et `professeur`
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9BAB22EE9');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE professeur');
        
        // Ne pas supprimer les références à `category` si elle n'existe plus
        // $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        // $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        // $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D12469DE2');
    }
}

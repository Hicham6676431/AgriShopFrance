<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240216075530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD raison_sociale VARCHAR(151) DEFAULT NULL, ADD numero_siret VARCHAR(50) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, ADD adresse VARCHAR(151) DEFAULT NULL, ADD ville VARCHAR(151) DEFAULT NULL, ADD cp INT DEFAULT NULL, ADD heure_ouverture TIME DEFAULT NULL, ADD heure_fermeture TIME DEFAULT NULL, ADD jour_ouveture VARCHAR(151) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP raison_sociale, DROP numero_siret, DROP description, DROP adresse, DROP ville, DROP cp, DROP heure_ouverture, DROP heure_fermeture, DROP jour_ouveture');
    }
}

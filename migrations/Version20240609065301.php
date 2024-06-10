<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240609065301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite_image ADD CONSTRAINT FK_BF1CF859A2843073 FOREIGN KEY (actualite_id) REFERENCES actualite (id)');
        $this->addSql('DROP INDEX IDX_32EC552A2843073 ON property_image');
        $this->addSql('ALTER TABLE property_image DROP actualite_id');
        $this->addSql('ALTER TABLE property_image ADD CONSTRAINT FK_32EC552549213EC FOREIGN KEY (property_id) REFERENCES properties (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property_image DROP FOREIGN KEY FK_32EC552549213EC');
        $this->addSql('ALTER TABLE property_image ADD actualite_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_32EC552A2843073 ON property_image (actualite_id)');
        $this->addSql('ALTER TABLE actualite_image DROP FOREIGN KEY FK_BF1CF859A2843073');
    }
}

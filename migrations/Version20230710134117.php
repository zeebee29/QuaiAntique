<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710134117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ouverture_hebdo ADD num_jsem INT NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE user_id user_id INT DEFAULT NULL, CHANGE tel tel_reserv VARCHAR(14) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ouverture_hebdo DROP num_jsem');
        $this->addSql('ALTER TABLE reservation CHANGE user_id user_id INT NOT NULL, CHANGE tel_reserv tel VARCHAR(14) NOT NULL');
    }
}

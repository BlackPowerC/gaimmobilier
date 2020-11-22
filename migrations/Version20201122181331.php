<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201122181331 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE immo_option (immo_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_FE397A38ACCF8247 (immo_id), INDEX IDX_FE397A38A7C41D6F (option_id), PRIMARY KEY(immo_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE immo_option ADD CONSTRAINT FK_FE397A38ACCF8247 FOREIGN KEY (immo_id) REFERENCES immo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE immo_option ADD CONSTRAINT FK_FE397A38A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE option_immo');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE option_immo (option_id INT NOT NULL, immo_id INT NOT NULL, INDEX IDX_C235FC26ACCF8247 (immo_id), INDEX IDX_C235FC26A7C41D6F (option_id), PRIMARY KEY(option_id, immo_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE option_immo ADD CONSTRAINT FK_C235FC26A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE option_immo ADD CONSTRAINT FK_C235FC26ACCF8247 FOREIGN KEY (immo_id) REFERENCES immo (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE immo_option');
    }
}

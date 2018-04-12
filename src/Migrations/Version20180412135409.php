<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180412135409 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F712469DE2');
        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F755B127A4');
        $this->addSql('ALTER TABLE food CHANGE price price NUMERIC(10, 0) NOT NULL');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F755B127A4 FOREIGN KEY (added_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(64) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F755B127A4');
        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F712469DE2');
        $this->addSql('ALTER TABLE food CHANGE price price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F755B127A4 FOREIGN KEY (added_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}

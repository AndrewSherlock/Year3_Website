<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180314200837 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE food (id INT AUTO_INCREMENT NOT NULL, added_by_id INT DEFAULT NULL, category_id INT DEFAULT NULL, reviews_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, summary LONGTEXT NOT NULL, photo_link VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price NUMERIC(10, 0) NOT NULL, date_added DATE NOT NULL, INDEX IDX_D43829F755B127A4 (added_by_id), INDEX IDX_D43829F712469DE2 (category_id), INDEX IDX_D43829F78092D97F (reviews_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, added_by_id INT DEFAULT NULL, food_id INT DEFAULT NULL, price NUMERIC(10, 0) NOT NULL, summary LONGTEXT NOT NULL, stars NUMERIC(10, 0) NOT NULL, INDEX IDX_794381C655B127A4 (added_by_id), INDEX IDX_794381C6BA8E87C4 (food_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F755B127A4 FOREIGN KEY (added_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F78092D97F FOREIGN KEY (reviews_id) REFERENCES review (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C655B127A4 FOREIGN KEY (added_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F712469DE2');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6BA8E87C4');
        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F755B127A4');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C655B127A4');
        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F78092D97F');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE food');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE review');
    }
}

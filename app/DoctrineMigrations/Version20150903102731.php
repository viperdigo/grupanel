<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150903102731 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE audit_log (id INT AUTO_INCREMENT NOT NULL, fk_user INT DEFAULT NULL, entity VARCHAR(255) NOT NULL, entity_id VARCHAR(255) NOT NULL, `values` LONGTEXT NOT NULL, user_ip VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_F6E1C0F51AD0877 (fk_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, created_id INT DEFAULT NULL, updated_id INT DEFAULT NULL, user_type_id INT DEFAULT NULL, username VARCHAR(20) NOT NULL, name VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, salt VARCHAR(255) NOT NULL, roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', isActive TINYINT(1) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, plainPassword VARCHAR(255) DEFAULT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_1483A5E9989D9B62 (slug), INDEX IDX_1483A5E95EE01E44 (created_id), INDEX IDX_1483A5E9960CC7F3 (updated_id), INDEX IDX_1483A5E99D419299 (user_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_types (id INT AUTO_INCREMENT NOT NULL, created_id INT DEFAULT NULL, updated_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_BBF272685EE01E44 (created_id), INDEX IDX_BBF27268960CC7F3 (updated_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE audit_log ADD CONSTRAINT FK_F6E1C0F51AD0877 FOREIGN KEY (fk_user) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E95EE01E44 FOREIGN KEY (created_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9960CC7F3 FOREIGN KEY (updated_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E99D419299 FOREIGN KEY (user_type_id) REFERENCES user_types (id)');
        $this->addSql('ALTER TABLE user_types ADD CONSTRAINT FK_BBF272685EE01E44 FOREIGN KEY (created_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_types ADD CONSTRAINT FK_BBF27268960CC7F3 FOREIGN KEY (updated_id) REFERENCES users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE audit_log DROP FOREIGN KEY FK_F6E1C0F51AD0877');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E95EE01E44');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9960CC7F3');
        $this->addSql('ALTER TABLE user_types DROP FOREIGN KEY FK_BBF272685EE01E44');
        $this->addSql('ALTER TABLE user_types DROP FOREIGN KEY FK_BBF27268960CC7F3');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E99D419299');
        $this->addSql('DROP TABLE audit_log');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE user_types');
    }
}

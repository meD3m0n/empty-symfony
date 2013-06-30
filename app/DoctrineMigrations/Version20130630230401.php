<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Create Table Notes
 */
class Version20130630230401 extends AbstractMigration
{
    /**
     * Schema Up
     *
     * @param Schema $schema
     *
     * @return null
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("CREATE TABLE notes
            (
                id INT AUTO_INCREMENT NOT NULL,
                description VARCHAR(255) NOT NULL,
                `for` VARCHAR(255) NOT NULL,
                soft_deleted TINYINT(1) NOT NULL,
                PRIMARY KEY(id)
            )
        DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
    }

    /**
     * Schema Down
     *
     * @param Schema $schema
     *
     * @return null
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("DROP TABLE notes");
    }
}

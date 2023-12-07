<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231106160800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE connection_session_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE operation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tunnel_information_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE connection_session (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, closed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, session_identification VARCHAR(255) NOT NULL, tunnel_type VARCHAR(15) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniqueSessionByTunnel ON connection_session (session_identification, tunnel_type)');
        $this->addSql('COMMENT ON COLUMN connection_session.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN connection_session.closed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE operation (id INT NOT NULL, connection_id VARCHAR(255) NOT NULL, operation_info JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, response_info JSON DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, transaction_info VARCHAR(255) DEFAULT NULL, tunnel_type VARCHAR(255) NOT NULL, order_id VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN operation.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN operation.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tunnel_information (id INT NOT NULL, type VARCHAR(15) NOT NULL, tunnel_url VARCHAR(255) NOT NULL, is_active BOOLEAN DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, removed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX tunnel_idx ON tunnel_information (type, tunnel_url)');
        $this->addSql('CREATE INDEX tunnel_url_idx ON tunnel_information (tunnel_url)');
        $this->addSql('COMMENT ON COLUMN tunnel_information.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN tunnel_information.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN tunnel_information.removed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql("INSERT INTO tunnel_information(id, type, tunnel_url, is_active, created_at) VALUES(1, 'PROD', 'https://152.206.64.214:5976', true, '2023-11-06 00:00:00'), (2, 'TEST', 'https://152.206.64.212:5976', true, '2023-11-06 00:00:00')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE connection_session_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE operation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tunnel_information_id_seq CASCADE');
        $this->addSql('DROP TABLE connection_session');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE tunnel_information');
    }
}

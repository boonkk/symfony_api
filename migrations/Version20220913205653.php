<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220913205653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX app_unique_role ON app_role (role)');
        $this->addSql('CREATE UNIQUE INDEX app_unique_email ON app_user (email)');
        $this->addSql('CREATE UNIQUE INDEX app_unique_username ON app_user (username)');
        $this->addSql('CREATE UNIQUE INDEX app_unique ON application (name)');
        $this->addSql('ALTER TABLE user ADD api_token VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6497BA2F5EB ON user (api_token)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D6497BA2F5EB ON `user`');
        $this->addSql('ALTER TABLE `user` DROP api_token');
        $this->addSql('DROP INDEX app_unique_role ON app_role');
        $this->addSql('DROP INDEX app_unique_email ON app_user');
        $this->addSql('DROP INDEX app_unique_username ON app_user');
        $this->addSql('DROP INDEX app_unique ON application');
    }
}

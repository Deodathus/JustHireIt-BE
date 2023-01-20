<?php

declare(strict_types=1);

namespace App\Modules\Client\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120131120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates client_group_permissions table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table client_group_permissions (
                id BINARY(36) not null unique,
                name VARCHAR(255) not null unique
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table client_group_permissions
        ');
    }
}

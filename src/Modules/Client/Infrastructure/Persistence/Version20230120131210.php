<?php

declare(strict_types=1);

namespace App\Modules\Client\Infrastructure\Persistence;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120131210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates client_group_permission_toggle table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table client_group_permission_toggle (
                group_id BINARY(36) not null,
                permission_name VARCHAR(255) not null,
                status bool not null,
                foreign key (group_id) references client_groups(id),
                foreign key (permission_name) references client_group_permissions(name)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table client_group_permission_toggle
        ');
    }
}

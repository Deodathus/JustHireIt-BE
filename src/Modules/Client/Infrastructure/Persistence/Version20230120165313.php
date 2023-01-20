<?php

declare(strict_types=1);

namespace App\Modules\Client\Infrastructure\Persistence;

use App\Modules\Client\Domain\Enum\Permissions;
use App\Modules\Client\Domain\ValueObject\PermissionId;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120165313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creates clients_groups';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table clients_groups (
                group_id BINARY(36) not null,
                client_id BINARY(36) not null,
                foreign key (group_id) references client_groups(id),
                foreign key (client_id) references clients(id)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table clients_groups
        ');
    }
}
